<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use Illuminate\Http\Request;

class CinemaController extends Controller
{
    public function index(Request $request)
    {
        $query = Cinema::query();

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->filled('location')) {
            $query->where('location', 'LIKE', '%' . $request->location . '%');
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'LIKE', '%' . $request->phone . '%');
        }

        $cinemas = $query->latest()->paginate(10)->appends($request->all());

        return view('admin.cinemas.index', compact('cinemas'));
    }

    public function create()
    {
        return view('admin.cinemas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'location'  => 'required|string|max:500',
            'phone'    => 'nullable|string|max:50',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'province' => 'required|string|max:100',
            'type'     => 'required|string|max:100',
        ], [
            'name.required'     => 'Vui lòng nhập tên rạp.',
            'location.required'  => 'Vui lòng nhập địa chỉ.',
            'image.image'       => 'Tệp phải là hình ảnh.',
            'image.mimes'       => 'Ảnh chỉ chấp nhận jpeg, png, jpg, gif.',
            'image.max'         => 'Kích thước ảnh không quá 2MB.',
            'province.required' => 'Vui lòng chọn tỉnh thành.',
            'type.required'     => 'Vui lòng chọn loại rạp.',
        ]);

        $data = $request->only(['name', 'location', 'phone', 'province', 'type']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/cinemas', 'public');
            $data['image'] = 'storage/' . $path;
        }

        Cinema::create($data);

        return redirect()->route('admin.cinemas.index')->with('success', 'Thêm rạp thành công.');
    }

    public function show($id)
    {
        $cinema = Cinema::findOrFail($id);
        return view('admin.cinemas.show', compact('cinema'));
    }

    public function edit($id)
    {
        $cinema = Cinema::findOrFail($id);
        return view('admin.cinemas.edit', compact('cinema'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'location'  => 'required|string|max:500',
            'phone'    => 'nullable|string|max:50',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'province' => 'required|string|max:100',
            'type'     => 'required|string|max:100',
        ], [
            'name.required'     => 'Vui lòng nhập tên rạp.',
            'location.required'  => 'Vui lòng nhập địa chỉ.',
            'image.image'       => 'Tệp phải là hình ảnh.',
            'image.mimes'       => 'Ảnh chỉ chấp nhận jpeg, png, jpg, gif.',
            'image.max'         => 'Kích thước ảnh không quá 2MB.',
            'province.required' => 'Vui lòng chọn tỉnh thành.',
            'type.required'     => 'Vui lòng chọn loại rạp.',
        ]);

        $cinema = Cinema::findOrFail($id);

        $data = $request->only(['name', 'location', 'phone', 'province', 'type']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/cinemas', 'public');
            $data['image'] = 'storage/' . $path;
        }

        $cinema->update($data);

        return redirect()->route('admin.cinemas.edit', $id)->with('success', 'Cập nhật rạp thành công.');
    }

    public function destroy($id)
    {
        $cinema = Cinema::findOrFail($id);
        $cinema->delete();

        return redirect()->route('admin.cinemas.index')->with('success', 'Xóa rạp thành công.');
    }
}
