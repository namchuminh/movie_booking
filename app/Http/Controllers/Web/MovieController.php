<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Cinema;
use App\Models\Showtime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    public function show($id)
    {
        $movie = Movie::findOrFail($id);

        // Lấy các suất chiếu có mã phim bằng $id
        $showtimes = Showtime::query()
            ->where('movie_id', $id)
            ->with('room.cinema')
            ->orderBy('show_date')
            ->orderBy('show_time')
            ->get();

        // Nhóm theo rạp (cinema)
        $byCinema = $showtimes->groupBy(fn($st) => $st->room->cinema->id);

        return view('web.movies.show', compact('movie', 'showtimes', 'byCinema'));
    }

    public function nowShowing(Request $request)
    {
        $genre = $request->query('genre');
        $language = $request->query('language');
        $sort = $request->query('sort'); // 'newest' hoặc 'oldest'

        $movies = Movie::query()
            ->when($genre, fn($q) => $q->where('genre', $genre))
            ->when($language, fn($q) => $q->where('language', $language))
            ->whereDate('release_date', '<=', now())
            ->when($sort === 'oldest', fn($q) => $q->orderBy('release_date'))
            ->when($sort === 'newest' || !$sort, fn($q) => $q->orderByDesc('release_date'))
            ->paginate(15);

        return view('web.movies.now_showing', compact('movies', 'genre', 'language', 'sort'));
    }

    public function comingSoon(Request $request)
    {
        $genre = $request->query('genre');
        $language = $request->query('language');

        $movies = Movie::query()
            ->when($genre, fn($q) => $q->where('genre', $genre))
            ->when($language, fn($q) => $q->where('language', $language))
            ->whereDate('release_date', '>', now())
            ->orderBy('release_date') // gần đến trước, xa đến sau
            ->paginate(15);

        return view('web.movies.coming_soon', compact('movies', 'genre', 'language'));
    }

    public function thisMonth(Request $request)
    {
        $query = Movie::query();

        // Lọc theo tháng hiện tại
        $query->whereMonth('release_date', now()->month)
            ->whereYear('release_date', now()->year);

        // Lọc thể loại nếu có
        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        // Lọc ngôn ngữ nếu có
        if ($request->filled('language')) {
            $query->where('language', $request->language);
        }

        // Sắp xếp theo "mới nhất" hoặc "cũ nhất"
        if ($request->sort === 'oldest') {
            $query->orderBy('release_date', 'asc');
        } else {
            $query->orderBy('release_date', 'desc');
        }

        // Lấy danh sách phim
        $movies = $query->get();

        return view('web.movies.this_month', compact('movies'));
    }
}
