<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;

class PromotionController extends Controller
{
    public function index()
    {
        $start = now()->startOfMonth();
        $end   = now()->endOfMonth();

        $promotions = Promotion::query()
            ->whereDate('start_date', '<=', $end)
            ->whereDate('end_date', '>=', $start)
            ->orderBy('start_date')
            ->with(['movies' => function ($q) {
                $q->select('movies.id','title','image','genre', 'duration', 'release_date'); // tùy cột bạn có
            }])
            ->withCount('movies')
            ->get();

        return view('web.promotions.index', compact('promotions'));
    }
}
