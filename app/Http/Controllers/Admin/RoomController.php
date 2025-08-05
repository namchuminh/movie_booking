<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Cinema;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with('cinema');

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', 'LIKE', '%' . $request->type . '%');
        }

        if ($request->filled('cinema_name')) {
            $query->whereHas('cinema', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->cinema_name . '%');
            });
        }

        $rooms = $query->latest()->paginate(10)->appends($request->all());

        $cinemas = Cinema::all();

        return view('admin.rooms.index', compact('rooms', 'cinemas'));
    }

    public function create()
    {
        $cinemas = Cinema::all();
        return view('admin.rooms.create', compact('cinemas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cinema_id' => 'required|exists:cinemas,id',
            'name'      => 'required|string|max:255',
            'capacity'  => 'required|integer|min:1',
            'type'      => 'nullable|string|max:100',
        ], [
            'cinema_id.required' => 'Vui lòng chọn rạp.',
            'cinema_id.exists'   => 'Rạp không tồn tại.',
            'name.required'      => 'Vui lòng nhập tên phòng.',
            'capacity.required'  => 'Vui lòng nhập sức chứa.',
            'capacity.integer'   => 'Sức chứa phải là số.',
            'capacity.min'       => 'Sức chứa phải lớn hơn 0.',
        ]);

        Room::create($request->only(['cinema_id', 'name', 'capacity', 'type']));

        return redirect()->route('admin.rooms.index')->with('success', 'Thêm phòng thành công.');
    }

    public function show($id)
    {
        $room = Room::with('cinema')->findOrFail($id);
        return view('admin.rooms.show', compact('room'));
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        $cinemas = Cinema::all();
        return view('admin.rooms.edit', compact('room', 'cinemas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cinema_id' => 'required|exists:cinemas,id',
            'name'      => 'required|string|max:255',
            'capacity'  => 'required|integer|min:1',
            'type'      => 'nullable|string|max:100',
        ], [
            'cinema_id.required' => 'Vui lòng chọn rạp.',
            'cinema_id.exists'   => 'Rạp không tồn tại.',
            'name.required'      => 'Vui lòng nhập tên phòng.',
            'capacity.required'  => 'Vui lòng nhập sức chứa.',
            'capacity.integer'   => 'Sức chứa phải là số.',
            'capacity.min'       => 'Sức chứa phải lớn hơn 0.',
        ]);

        $room = Room::findOrFail($id);
        $room->update($request->only(['cinema_id', 'name', 'capacity', 'type']));

        return redirect()->route('admin.rooms.edit', $id)->with('success', 'Cập nhật phòng thành công.');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Xóa phòng thành công.');
    }
}
