<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Cinema;
use App\Models\Movie;

class DashboardController extends Controller
{
    public function index()
    {
        // Múi giờ Việt Nam
        $tz = 'Asia/Ho_Chi_Minh';

        // --- Thống kê nhanh ---
        $cinemasCount = Cinema::count();
        $moviesCount  = Movie::count();

        // --- Doanh thu trong NGÀY theo VN (quy về UTC khi query) ---
        $startLocal = Carbon::now($tz)->startOfDay();
        $endLocal   = Carbon::now($tz)->endOfDay();
        $startUtc   = $startLocal->copy()->timezone('UTC');
        $endUtc     = $endLocal->copy()->timezone('UTC');

        $todayRevenue = DB::table('tickets')
            ->join('showtimes', 'tickets.showtime_id', '=', 'showtimes.id')
            ->whereBetween('tickets.created_at', [$startUtc, $endUtc])
            ->sum('showtimes.price');

        // --- Doanh thu theo THÁNG trong năm hiện tại (group theo giờ VN) ---
        $year = Carbon::now($tz)->year;

        // Prefix rõ bảng để tránh mơ hồ
        $rawMonth = 'MONTH(CONVERT_TZ(tickets.created_at,"+00:00","+07:00"))';
        $rawYear  = 'YEAR(CONVERT_TZ(tickets.created_at,"+00:00","+07:00"))';

        $rows = DB::table('tickets')
            ->join('showtimes', 'tickets.showtime_id', '=', 'showtimes.id')
            ->selectRaw("$rawMonth as month, SUM(showtimes.price) as total")
            ->whereRaw("$rawYear = ?", [$year])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month'); // [month => total]

        // Build mảng đủ 12 tháng
        $monthlyRevenue = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyRevenue[$m] = (float) ($rows[$m] ?? 0);
        }

        // Chart.js labels/values
        $labels = ['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'];
        $values = array_values($monthlyRevenue);

        return view('admin.dashboard.index', [
            'cinemasCount'   => $cinemasCount,
            'moviesCount'    => $moviesCount,
            'todayRevenue'   => (float) $todayRevenue,
            'year'           => $year,
            'labels'         => $labels,
            'values'         => $values,
            'monthlyRevenue' => $monthlyRevenue,
        ]);
    }
}
