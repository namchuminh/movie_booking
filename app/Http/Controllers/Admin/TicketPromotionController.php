<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Showtime;
use App\Models\Promotion;
use App\Models\TicketPromotion;
use Illuminate\Http\Request;

class TicketPromotionController extends Controller
{
    public function index()
    {
        $ticketPromotions = TicketPromotion::with(['showtime', 'promotion'])->paginate(10);
        return view('admin.ticket_promotions.index', compact('ticketPromotions'));
    }

    public function create()
    {
        $showtimes = Showtime::with([
            'movie:id,title',
            'room:id,name,cinema_id', // load thêm cinema_id từ room
            'room.cinema:id,name'     // load quan hệ cinema từ room
        ])->select('id', 'movie_id', 'room_id', 'show_time')->get();

        $promotions = Promotion::select('id', 'title', 'start_date', 'end_date')->get();

        return view('admin.ticket_promotions.create', compact('showtimes', 'promotions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'promo_id' => 'required|exists:promotions,id',
        ]);

        $exists = TicketPromotion::where('showtime_id', $request->showtime_id)
                                ->where('promo_id', $request->promo_id)
                                ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['msg' => 'Khuyến mãi này đã được áp dụng cho suất chiếu!'])->withInput();
        }

        TicketPromotion::create($request->only(['showtime_id', 'promo_id']));

        return redirect()->route('admin.ticket-promotions.index')->with('success', 'Áp dụng khuyến mãi thành công.');
    }

    public function edit($id)
    {
        $ticketPromotion = TicketPromotion::findOrFail($id);
        $showtimes = Showtime::all();
        $promotions = Promotion::all();
        return view('admin.ticket_promotions.edit', compact('ticketPromotion', 'showtimes', 'promotions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'promo_id' => 'required|exists:promotions,id',
        ], [
            'showtime_id.required' => 'Suất chiếu là bắt buộc.',
            'promo_id.required' => 'Khuyến mãi là bắt buộc.',
            'showtime_id.exists' => 'Suất chiếu không tồn tại.',
            'promo_id.exists' => 'Khuyến mãi không tồn tại.',
            'promo_id.unique' => 'Khuyến mãi này đã được áp dụng cho suất chiếu này.',
            'showtime_id.unique' => 'Suất chiếu này đã có khuyến mãi mãi.',
        ]);

        $ticketPromotion = TicketPromotion::findOrFail($id);

        $ticketPromotion->update([
            'showtime_id' => $request->showtime_id,
            'promo_id' => $request->promo_id,
        ]);

        return redirect()->route('admin.ticket-promotions.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        //Tìm theo showtime_id
        $ticketPromotion = TicketPromotion::where('showtime_id', $id)->firstOrFail();

        $ticketPromotion->delete();

        return redirect()->route('admin.ticket-promotions.index')->with('success', 'Xóa thành công.');
    }
}
