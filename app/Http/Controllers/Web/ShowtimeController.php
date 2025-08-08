<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Showtime;
use Illuminate\Support\Facades\DB;
use App\Models\Cinema;
use Illuminate\Support\Carbon;

class ShowtimeController extends Controller
{
    public function index()
    {
        // 2. Lấy danh sách tỉnh có rạp
        $provincesWithCinemas = Cinema::select('province')
            ->distinct()
            ->orderBy('province')
            ->pluck('province')
            ->toArray();

        // 3. Đếm số lượng rạp theo tỉnh
        $cinemaCounts = Cinema::select('province', DB::raw('COUNT(*) as count'))
            ->groupBy('province')
            ->pluck('count', 'province')
            ->toArray();

        // 4. Dữ liệu khu vực để hiển thị
        $areas = collect($provincesWithCinemas)->map(function ($province) use ($cinemaCounts) {
            return [
                'province' => $province,
                'count' => $cinemaCounts[$province] ?? 0
            ];
        });

        // 5. Province & cinema đang được chọn
        $selectedProvince = request('province') ?? $provincesWithCinemas[0] ?? null;
        $selectedCinemaId = request('cinema_id');
        $selectedDate = request('date'); // ngày được chọn từ giao diện (format: Y-m-d)

        // 6. Nhóm rạp theo loại
        $cinemasByType = collect();
        if ($selectedProvince) {
            $cinemasByType = Cinema::where('province', $selectedProvince)
                ->orderBy('type')
                ->orderBy('name')
                ->get()
                ->groupBy('type');
        }

        // 7. Lấy danh sách ngày có suất chiếu (nếu đã chọn rạp)
        $showtimes = collect();
        $availableDates = collect();

        // Nếu chưa có request thì tự chọn tỉnh đầu tiên và rạp đầu tiên
        if (!$selectedCinemaId) {
            $firstProvince = $provincesWithCinemas[0] ?? null;

            if ($firstProvince) {
                $firstCinemaId = Cinema::where('province', $firstProvince)
                    ->orderBy('name')
                    ->value('id');

                if ($firstCinemaId) {
                    $selectedProvince = $firstProvince;
                    $selectedCinemaId = $firstCinemaId;
                }
            }
        }

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

        return view('web.showtimes.index', compact(
            'areas',
            'cinemasByType',
            'selectedCinemaId',
            'selectedProvince',
            'showtimes',
            'availableDates',
            'selectedDate',
            'selectedProvinceDisplay',
            'selectedCinemaIdDisplay'
        ));
    }
}
