<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::query();

        if ($request->filled('title')) {
            $query->where('title', 'LIKE', '%' . $request->title . '%');
        }

        if ($request->filled('genre')) {
            $query->where('genre', 'LIKE', '%' . $request->genre . '%');
        }

        if ($request->filled('release_date_from')) {
            $query->whereDate('release_date', '>=', $request->release_date_from);
        }

        if ($request->filled('release_date_to')) {
            $query->whereDate('release_date', '<=', $request->release_date_to);
        }

        $movies = $query->latest()->paginate(10)->appends($request->all());

        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'genre'         => 'required|string|max:100',
            'duration'      => 'required|integer|min:1',
            'release_date'  => 'required|date',
            'language'      => 'nullable|string|max:100',
            'trailer_url'   => 'nullable|string|max:1000',
            'actors'        => 'nullable|string',
            'director'      => 'nullable|string|max:100',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required'        => 'Vui lòng nhập tên phim.',
            'genre.required'        => 'Vui lòng chọn thể loại.',
            'duration.required'     => 'Vui lòng nhập thời lượng.',
            'duration.integer'      => 'Thời lượng phải là số.',
            'release_date.required' => 'Vui lòng nhập ngày khởi chiếu.',
            'image.image'           => 'Tệp phải là hình ảnh.',
            'image.mimes'           => 'Ảnh chỉ chấp nhận jpeg, png, jpg, gif.',
            'image.max'             => 'Kích thước ảnh không quá 2MB.'
        ]);

        $data = $request->only([
            'title', 'genre', 'duration', 'release_date', 'language',
            'rating', 'trailer_url', 'actors', 'director', 'description'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/movies', 'public');
            $data['image'] = 'storage/' . $path;
        }

        Movie::create($data);

        return redirect()->route('admin.movies.index')->with('success', 'Thêm phim thành công.');
    }

    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.movies.show', compact('movie'));
    }

    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.movies.edit', compact('movie'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'genre'         => 'required|string|max:100',
            'duration'      => 'required|integer|min:1',
            'release_date'  => 'required|date',
            'language'      => 'nullable|string|max:100',
            'trailer_url'   => 'nullable|string|max:1000',
            'actors'        => 'nullable|string',
            'director'      => 'nullable|string|max:100',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required'        => 'Vui lòng nhập tên phim.',
            'genre.required'        => 'Vui lòng chọn thể loại.',
            'duration.required'     => 'Vui lòng nhập thời lượng.',
            'duration.integer'      => 'Thời lượng phải là số.',
            'release_date.required' => 'Vui lòng nhập ngày khởi chiếu.',
            'image.image'           => 'Tệp phải là hình ảnh.',
            'image.mimes'           => 'Ảnh chỉ chấp nhận jpeg, png, jpg, gif.',
            'image.max'             => 'Kích thước ảnh không quá 2MB.'
        ]);

        $movie = Movie::findOrFail($id);

        $data = $request->only([
            'title', 'genre', 'duration', 'release_date', 'language',
            'rating', 'trailer_url', 'actors', 'director', 'description'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/movies', 'public');
            $data['image'] = 'storage/' . $path;
        }

        $movie->update($data);

        return redirect()->route('admin.movies.edit', $movie->id)->with('success', 'Cập nhật phim thành công.');
    }

    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();

        return redirect()->route('admin.movies.index')->with('success', 'Xóa phim thành công.');
    }
}
