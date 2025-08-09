<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cinema;
use App\Models\Showtime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class CinemaController extends Controller
{
    public function show($id)
    {
        $cinemaDetail = Cinema::findOrFail($id);
        $selectedDate = request('date'); // ngày được chọn từ giao diện (format: Y-m-d)

        $showtimes = collect();
        $availableDates = collect();

        $selectedCinemaId = $id;

        if ($selectedCinemaId) {
            // Danh sách ngày có suất chiếu
            $availableDates = Showtime::whereHas('room.cinema', function ($q) use ($selectedCinemaId) {
                $q->where('cinemas.id', $selectedCinemaId);
            })
                ->where('show_date', '>=', now())
                ->select(DB::raw('DATE(show_date) as date'))
                ->distinct()
                ->orderBy('date')
                ->pluck('date'); // ['2025-08-06', '2025-08-07', ...]

            // Tìm ngày bắt đầu
            $today = Carbon::today()->toDateString();
            $startDate = $selectedDate;

            if (!$selectedDate) {
                $hasTodayShow = Showtime::whereDate('show_date', $today)
                    ->whereHas('room.cinema', fn($q) => $q->where('cinemas.id', $selectedCinemaId))
                    ->exists();

                $startDate = $hasTodayShow
                    ? $today
                    : Showtime::whereDate('show_date', '>', $today)
                        ->whereHas('room.cinema', fn($q) => $q->where('cinemas.id', $selectedCinemaId))
                        ->orderBy('show_date')
                        ->limit(1)
                        ->value('show_date');
            }

            // Lấy danh sách suất chiếu theo ngày
            if ($startDate) {
                $showtimes = Showtime::whereHas('room.cinema', function ($q) use ($selectedCinemaId) {
                    $q->where('cinemas.id', $selectedCinemaId);
                })
                    ->whereDate('show_date', $startDate)
                    ->with(['movie', 'room.seats', 'room.cinema'])
                    ->orderBy('show_time')
                    ->get()
                    ->groupBy('movie_id'); // Group by movie để hiển thị cho mỗi phim
            }
        }

        $selectedProvinceDisplay = request('province') ?? $provincesWithCinemas[0] ?? null;
        $selectedCinemaIdDisplay = request('cinema_id');

        return view('web.cinemas.show', compact('cinemaDetail', 'showtimes', 'availableDates', 'selectedCinemaIdDisplay', 'selectedDate', 'selectedCinemaId'));
    }
}
