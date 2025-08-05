<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Ticket, Showtime, Seat, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with(['showtime.movie', 'seat.room.cinema', 'user']);

        if ($request->filled('movie_title')) {
            $query->whereHas('showtime.movie', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->movie_title . '%');
            });
        }

        if ($request->filled('cinema_name')) {
            $query->whereHas('seat.room.cinema', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->cinema_name . '%');
            });
        }

        if ($request->filled('room_name')) {
            $query->whereHas('seat.room', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->room_name . '%');
            });
        }

        if ($request->filled('user_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('username', 'like', '%' . $request->user_name . '%');
            });
        }

        $tickets = $query->latest()->paginate(10)->appends($request->all());

        return view('admin.tickets.index', compact('tickets'));
    }

    public function create()
    {
        $showtimes = Showtime::with('movie')->get();
        $seats = Seat::with('room.cinema')->get();
        $users = User::all();

        return view('admin.tickets.create', compact('showtimes', 'seats', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seat_id'     => 'required|exists:seats,id',
            'username'     => 'required|exists:users,username',
        ], [
            'showtime_id.required' => 'Vui lòng chọn suất chiếu.',
            'showtime_id.exists'   => 'Suất chiếu không tồn tại.',
            'seat_id.required'     => 'Vui lòng chọn ghế ngồi.',
            'seat_id.exists'       => 'Ghế ngồi không hợp lệ.',
            'username.required'     => 'Vui lòng chọn người dùng.',
            'username.exists'       => 'Người dùng không hợp lệ.',
        ]);

        DB::beginTransaction();

        try {
            $user_id = User::where('username', $request->username)->value('id');

            $ticket = Ticket::create($request->only(['showtime_id', 'seat_id']) + ['user_id' => $user_id]);

            $ticket->ticketCode()->create([
                'code' => strtoupper(uniqid('TKT')),
            ]);

            DB::commit();

            return redirect()->route('admin.tickets.index')->with('success', 'Thêm vé thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi khi tạo vé: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $ticket = Ticket::with([
            'showtime.movie',
            'seat.room.cinema',
            'user',
            'ticketCode'
        ])->findOrFail($id);

        return view('admin.tickets.show', compact('ticket'));
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $showtimes = Showtime::with('movie')->get();
        $seats = Seat::with('room.cinema')->get();
        $users = User::all();

        return view('admin.tickets.edit', compact('ticket', 'showtimes', 'seats', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seat_id'     => 'required|exists:seats,id',
            'username'    => 'required|exists:users,username',
        ], [
            'showtime_id.required' => 'Vui lòng chọn suất chiếu.',
            'showtime_id.exists'   => 'Suất chiếu không tồn tại.',
            'seat_id.required'     => 'Vui lòng chọn ghế ngồi.',
            'seat_id.exists'       => 'Ghế ngồi không hợp lệ.',
            'username.required'    => 'Vui lòng chọn người dùng.',
            'username.exists'      => 'Người dùng không hợp lệ.',
        ]);

        try {
            $ticket = Ticket::findOrFail($id);

            $user_id = User::where('username', $request->username)->value('id');

            $ticket->update([
                'showtime_id' => $request->showtime_id,
                'seat_id'     => $request->seat_id,
                'user_id'     => $user_id,
            ]);

            return redirect()->route('admin.tickets.edit', $id)->with('success', 'Cập nhật vé thành công.');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi cập nhật vé: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('admin.tickets.index')->with('success', 'Xóa vé thành công.');
    }

    public function print($id)
    {
        $ticket = Ticket::with(['showtime.movie', 'seat.room.cinema', 'user'])->findOrFail($id);

        // Logic to generate the printable view
        return view('admin.tickets.print', compact('ticket'));
    }
}
