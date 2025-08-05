<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seat;
use App\Models\Room;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function index(Request $request)
    {
        $query = Seat::with('room.cinema');

        if ($request->filled('seat_code')) {
            $query->where('seat_code', 'like', '%' . $request->seat_code . '%');
        }

        if ($request->filled('seat_type')) {
            $query->where('seat_type', 'like', '%' . $request->seat_type . '%');
        }

        if ($request->filled('room_name')) {
            $query->whereHas('room', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->room_name . '%');
            });
        }

        $seats = $query->latest()->paginate(10)->appends($request->all());

        return view('admin.seats.index', compact('seats'));
    }

    public function create()
    {
        $rooms = Room::with('cinema')->get();
        return view('admin.seats.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id'    => 'required|exists:rooms,id',
            'seat_code'  => 'required|string|max:10|unique:seats,seat_code',
            'seat_type'  => 'required|string|max:50',
            'price'      => 'required|numeric|min:0',
        ], [
            'room_id.required' => 'Vui lòng chọn phòng.',
            'seat_code.required' => 'Vui lòng nhập mã ghế.',
            'seat_code.unique' => 'Mã ghế đã tồn tại.',
            'seat_type.required' => 'Vui lòng nhập loại ghế.',
            'seat_type.max' => 'Loại ghế không được vượt quá 50 ký tự.',
            'price.required' => 'Vui lòng nhập giá ghế.',
            'price.numeric' => 'Giá ghế phải là một số.',
            'price.min' => 'Giá ghế phải lớn hơn hoặc bằng 0.',
        ]);

        Seat::create($request->only(['room_id', 'seat_code', 'seat_type', 'price']));

        return redirect()->route('admin.seats.index')->with('success', 'Thêm ghế thành công.');
    }

    public function show($id)
    {
        $seat = Seat::with('room.cinema')->findOrFail($id);
        return view('admin.seats.show', compact('seat'));
    }

    public function edit($id)
    {
        $seat = Seat::findOrFail($id);
        $rooms = Room::with('cinema')->get();
        return view('admin.seats.edit', compact('seat', 'rooms'));
    }

    public function update(Request $request, $id)
    {
        $seat = Seat::findOrFail($id);

        $request->validate([
            'room_id'    => 'required|exists:rooms,id',
            'seat_code'  => 'required|string|max:10|unique:seats,seat_code,' . $seat->id,
            'seat_type'  => 'required|string|max:50',
            'price'      => 'required|numeric|min:0',
        ], [
            'room_id.required' => 'Vui lòng chọn phòng.',
            'seat_code.required' => 'Vui lòng nhập mã ghế.',
            'seat_code.unique' => 'Mã ghế đã tồn tại.',
            'seat_type.required' => 'Vui lòng nhập loại ghế.',
            'seat_type.max' => 'Loại ghế không được vượt quá 50 ký tự.',
            'price.required' => 'Vui lòng nhập giá ghế.',
            'price.numeric' => 'Giá ghế phải là một số.',
            'price.min' => 'Giá ghế phải lớn hơn hoặc bằng 0.',
        ]);

        $seat->update($request->only(['room_id', 'seat_code', 'seat_type', 'price']));

        return redirect()->route('admin.seats.edit', $id)->with('success', 'Cập nhật ghế thành công.');
    }

    public function destroy($id)
    {
        $seat = Seat::findOrFail($id);
        $seat->delete();

        return redirect()->route('admin.seats.index')->with('success', 'Xóa ghế thành công.');
    }
}
