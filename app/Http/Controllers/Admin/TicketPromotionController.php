<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Showtime;
use App\Models\Promotion;
use App\Models\TicketPromotion;
use App\Models\Movie;
use Illuminate\Http\Request;

class TicketPromotionController extends Controller
{
    public function index()
    {
        $ticketPromotions = TicketPromotion::with(['movie', 'promotion'])->paginate(10);
        return view('admin.ticket_promotions.index', compact('ticketPromotions'));
    }

    public function create()
    {
        // Lấy phim đang chiếu hoặc sắp chiếu
        $movies = Movie::where('release_date', '>=', now())->latest()->get();

        $promotions = Promotion::select('id', 'title', 'start_date', 'end_date', 'value')->get();

        return view('admin.ticket_promotions.create', compact('movies', 'promotions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'promo_id' => 'required|exists:promotions,id',
        ], [
            'movie_id.required' => 'Phim là bắt buộc.',
            'promo_id.required' => 'Khuyến mãi là bắt buộc.',
            'movie_id.exists' => 'Phim không tồn tại.',
            'promo_id.exists' => 'Khuyến mãi không tồn tại.',
            'promo_id.unique' => 'Khuyến mãi này đã được áp dụng cho phim này.',
            'movie_id.unique' => 'Phim này đã có khuyến mãi mãi.',
        ]);

        $exists = TicketPromotion::where('movie_id', $request->movie_id)
                                ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['msg' => 'Phim này hiện đã áp dụng giảm giá rồi!'])->withInput();
        }

        TicketPromotion::create($request->only(['movie_id', 'promo_id']));

        return redirect()->route('admin.ticket-promotions.index')->with('success', 'Áp dụng khuyến mãi thành công.');
    }

    public function edit($id)
    {
        $ticketPromotion = TicketPromotion::findOrFail($id);
        $movies = Movie::where('release_date', '>=', now())->latest()->get();
        $promotions = Promotion::all();
        return view('admin.ticket_promotions.edit', compact('ticketPromotion', 'movies', 'promotions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'promo_id' => 'required|exists:promotions,id',
        ], [
            'movie_id.required' => 'Phim là bắt buộc.',
            'promo_id.required' => 'Khuyến mãi là bắt buộc.',
            'movie_id.exists' => 'Phim không tồn tại.',
            'promo_id.exists' => 'Khuyến mãi không tồn tại.',
            'promo_id.unique' => 'Khuyến mãi này đã được áp dụng cho phim này.',
            'movie_id.unique' => 'Phim này đã có khuyến mãi mãi.',
        ]);

        $ticketPromotion = TicketPromotion::findOrFail($id);

        $ticketPromotion->update([
            'movie_id' => $request->movie_id,
            'promo_id' => $request->promo_id,
        ]);

        return redirect()->route('admin.ticket-promotions.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        //Tìm theo movie_id
        $ticketPromotion = TicketPromotion::where('movie_id', $id)->firstOrFail();

        $ticketPromotion->delete();

        return redirect()->route('admin.ticket-promotions.index')->with('success', 'Xóa thành công.');
    }
}
