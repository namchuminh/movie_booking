<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Showtime;
use App\Models\Movie;
use App\Models\Room;
use Illuminate\Http\Request;

class ShowtimeController extends Controller
{
    public function index(Request $request)
    {
        $query = Showtime::with(['movie', 'room.cinema']);

        if ($request->filled('movie_title')) {
            $query->whereHas('movie', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->movie_title . '%');
            });
        }

        if ($request->filled('show_date')) {
            $query->where('show_date', $request->show_date);
        }

        if ($request->filled('cinema_name')) {
            $query->whereHas('room.cinema', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->cinema_name . '%');
            });
        }

        $showtimes = $query->latest()->paginate(10)->appends($request->all());

        return view('admin.showtimes.index', compact('showtimes'));
    }

    public function create()
    {
        $movies = Movie::all();
        $rooms = Room::with('cinema')->get();
        return view('admin.showtimes.create', compact('movies', 'rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'movie_id'   => 'required|exists:movies,id',
            'room_id'    => 'required|exists:rooms,id',
            'show_date'  => 'required|date',
            'show_time'  => 'required|date_format:H:i',
            'price'      => 'required|numeric|min:0',
        ], [
            'movie_id.required' => 'Vui lòng chọn phim.',
            'room_id.required' => 'Vui lòng chọn phòng.',
            'show_date.required' => 'Vui lòng chọn ngày chiếu.',
            'show_time.required' => 'Vui lòng nhập giờ chiếu.',
            'price.required' => 'Vui lòng nhập giá vé.',
            'price.numeric' => 'Giá vé phải là một số.',
            'price.min' => 'Giá vé phải lớn hơn hoặc bằng 0.',
        ]);

        Showtime::create($request->only(['movie_id', 'room_id', 'show_date', 'show_time', 'price']));

        return redirect()->route('admin.showtimes.index')->with('success', 'Thêm suất chiếu thành công.');
    }

    public function show($id)
    {
        $showtime = Showtime::with(['movie', 'room.cinema'])->findOrFail($id);
        return view('admin.showtimes.show', compact('showtime'));
    }

    public function edit($id)
    {
        $showtime = Showtime::findOrFail($id);
        $movies = Movie::all();
        $rooms = Room::with('cinema')->get();
        return view('admin.showtimes.edit', compact('showtime', 'movies', 'rooms'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'movie_id'   => 'required|exists:movies,id',
            'room_id'    => 'required|exists:rooms,id',
            'show_date'  => 'required|date',
            'show_time'  => 'required|date_format:H:i',
            'price'      => 'required|numeric|min:0',
        ], [
            'movie_id.required' => 'Vui lòng chọn phim.',
            'room_id.required' => 'Vui lòng chọn phòng.',
            'show_date.required' => 'Vui lòng chọn ngày chiếu.',
            'show_time.required' => 'Vui lòng nhập giờ chiếu.',
            'price.required' => 'Vui lòng nhập giá vé.',            
            'price.numeric' => 'Giá vé phải là một số.',
            'price.min' => 'Giá vé phải lớn hơn hoặc bằng 0.',
        ]);

        $showtime = Showtime::findOrFail($id);
        $showtime->update($request->only(['movie_id', 'room_id', 'show_date', 'show_time', 'price']));

        return redirect()->route('admin.showtimes.edit', $id)->with('success', 'Cập nhật suất chiếu thành công.');
    }

    public function destroy($id)
    {
        $showtime = Showtime::findOrFail($id);
        $showtime->delete();

        return redirect()->route('admin.showtimes.index')->with('success', 'Xóa suất chiếu thành công.');
    }
}
