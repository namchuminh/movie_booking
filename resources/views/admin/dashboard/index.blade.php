@extends('admin.layouts.app')
@section('title', 'Bảng Điều Khiển')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Tiêu đề + breadcrumb --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Trang Chủ</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ url('admin') }}">Hệ Thống</a></li>
                                <li class="breadcrumb-item active">Trang Chủ</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KPI cards --}}
            <div class="row">
                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <i class="bx bx-building-house float-right m-0 h2 text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">SỐ RẠP</h6>
                            <h3 class="mb-3">{{ number_format($cinemasCount) }}</h3>
                            <span class="text-muted">Tổng rạp đang quản lý</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <i class="bx bx-movie-play float-right m-0 h2 text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">SỐ PHIM</h6>
                            <h3 class="mb-3">{{ number_format($moviesCount) }}</h3>
                            <span class="text-muted">Tiêu đề hiện có</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <i class="bx bx-dollar-circle float-right m-0 h2 text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">DOANH THU - HÔM NAY</h6>
                            <h3 class="mb-3">{{ number_format($todayRevenue) }}đ</h3>
                            <span class="text-muted">Theo múi giờ Việt Nam</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Chart + Bảng --}}
            <div class="row">
                <div class="col-lg-8">
                    <div class="card pb-5">
                        <div class="card-body mt-2">
                            <h4 class="card-title d-inline-block mb-4">Doanh Thu Theo Tháng</h4>
                            <div id="revWrap" style="height:500px;">
                                <canvas id="revChart" style="display:block; width:100%; height:100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title d-inline-block mb-4">Bảng doanh thu · {{ $year }}</h4>
                            <div class="table-responsive mt-3">
                                <table class="table table-centered table-hover mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Tháng</th>
                                            <th class="text-right">Doanh thu (VND)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($monthlyRevenue as $m => $total)
                                            <tr>
                                                <td>Tháng {{ $m }}</td>
                                                <td class="text-right">{{ number_format($total) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="table-light font-weight-bold">
                                            <td class="text-right">Tổng năm</td>
                                            <td class="text-right">{{ number_format(array_sum($monthlyRevenue)) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="text-muted mt-2 mb-0" style="font-size:12px">Nguồn: tickets × showtimes.price</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // tránh trình duyệt tự khôi phục vị trí cuộn
            if ('scrollRestoration' in history) history.scrollRestoration = 'manual';

            const labels = @json($labels);
            const data = @json($values);

            const ctx = document.getElementById('revChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: { labels, datasets: [{ label: 'Doanh thu (VND)', data, tension: .35, fill: true }] },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,     // dùng chiều cao cố định của wrap
                    animation: false,               // tắt animation để không giật trang
                    resizeDelay: 200,               // giảm tần suất resize
                    scales: {
                        y: { beginAtZero: true, ticks: { callback: v => new Intl.NumberFormat('vi-VN').format(v) } }
                    },
                    plugins: { legend: { display: false } }
                }
            });

            // đảm bảo ở đầu trang sau khi render chart
            window.scrollTo({ top: 0, left: 0, behavior: 'auto' });
        });
    </script>
@endsection