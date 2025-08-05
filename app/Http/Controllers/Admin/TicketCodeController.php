<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TicketCode;

class TicketCodeController extends Controller
{
    public function index(Request $request)
    {
        $query = TicketCode::with(['ticket.showtime.movie', 'ticket.seat.room.cinema', 'ticket.user']);

        if ($request->filled('code')) {
            $query->where('code', 'like', '%' . $request->code . '%');
        }

        if ($request->filled('movie_title')) {
            $query->whereHas('ticket.showtime.movie', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->movie_title . '%');
            });
        }

        if ($request->filled('cinema_name')) {
            $query->whereHas('ticket.seat.room.cinema', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->cinema_name . '%');
            });
        }

        if ($request->filled('username')) {
            $query->whereHas('ticket.user', function ($q) use ($request) {
                $q->where('username', 'like', '%' . $request->username . '%');
            });
        }

        if ($request->filled('show_date')) {
            $query->whereHas('ticket.showtime', function ($q) use ($request) {
                $q->where('show_date', $request->show_date);
            });
        }

        $ticketCodes = $query->latest()->paginate(10);

        return view('admin.ticket_codes.index', compact('ticketCodes'));
    }

    public function show($code)
    {
        $ticketCode = TicketCode::with(['ticket.showtime.movie', 'ticket.seat.room.cinema', 'ticket.user'])
            ->where('code', $code)
            ->firstOrFail();

        return view('admin.ticket_codes.show', compact('ticketCode'));
    }

    public function create() {}
    public function store(Request $request) {}
    public function edit($id) {}
    public function update(Request $request, $id) {}
    public function destroy($id) {}
}
