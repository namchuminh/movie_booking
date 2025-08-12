@extends('web.layouts.app')
@section('title', 'Mua vé - ' . $showtime->movie->title)
@section('content')
    {{-- Steps --}}
    <style>
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #94a3b8;
            /* Màu xám nhạt */
            font-size: 12px;
            background-color: white !important;
        }

        .step i {
            font-size: 20px;
        }

        .step.active {
            color: #dc2626 !important;
            /* Màu đỏ */
        }

        .step.active i {
            color: #dc2626 !important;
        }
    </style>

    <div class="d-flex justify-content-center align-items-center mb-3 bg-white small"
        style="border-bottom: 1px solid #e3ebf6 !important; gap: 6rem !important;">
        <div class="step">
            <i class="bi bi-grid-fill"></i>
            Chọn ghế
        </div>
        <i class="bi bi-chevron-right text-muted"></i>
        <div class="step">
            <i class="bi bi-credit-card-fill"></i>
            Thanh toán
        </div>
        <i class="bi bi-chevron-right text-muted"></i>
        <div class="step active">
            <i class="bi bi-ticket-perforated-fill"></i>
            Thông tin vé
        </div>
    </div>

    <div class="container py-3">
        <div class="row g-4">
            {{-- LEFT: Thông tin đơn + danh sách ghế --}}
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="fw-semibold">{{ $showtime->movie->title }}</div>
                        <div class="small text-muted">
                            {{ optional(optional($showtime->room)->cinema)->name }} —
                            Suất {{ \Carbon\Carbon::parse($showtime->show_time)->format('H:i') }},
                            {{ \Carbon\Carbon::parse($showtime->show_date)->format('d/m/Y') }} —
                            Phòng {{ optional($showtime->room)->name }}
                        </div>
                    </div>
                </div>
                <div class="alert alert-warning py-3 px-3 mb-3 shadow-sm" style="font-size: 14px; background-color: #f6c343;">
                    <i class="bi bi-info-circle me-2"></i>Vui lòng <b>"In Vé"</b> về máy trước khi tới rạp chiếu phim.
                </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-semibold">Ghế đã chọn</div>
                    <div class="card-body p-0">
                        <div class="table-responsive p-2">
                            <table class="table table-sm align-middle mb-0 table-lg">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:20%">Mã ghế</th>
                                        <th style="width:30%">Loại</th>
                                        <th style="width:20%">Giá Tiền</th>
                                        <th style="width:30%" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($selected as $s)
                                        <tr>
                                            <td class="fw-semibold">{{ $s['code'] }}</td>
                                            <td>{{ $s['type'] }}</td>
                                            <td>{{ number_format($s['price']) }} ₫</td>
                                            <th class="text-center">
                                                <a href="{{ route('tickets.print', ['id' => $s['ticket_id']]) }}" target="_blank" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-printer"></i> In Vé
                                                </a>
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .step {
            padding: 6px 10px;
            border-radius: 6px;
            background: #f6f7fb
        }

        .step.active {
            background: #e9f1ff;
            color: #3b82f6;
            font-weight: 600
        }

        .seatmap-wrapper {
            display: flex;
            gap: 10px
        }

        .row-labels {
            display: flex;
            flex-direction: column;
            gap: 6px;
            padding-top: 2px
        }

        .row-label {
            width: 28px;
            height: 28px;
            background: #6b7280;
            color: #fff;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px
        }

        .grid {
            display: flex;
            flex-direction: column;
            gap: 6px
        }

        .grid-row {
            display: flex;
            gap: 6px
        }

        /* Seat */
        .seat {
            width: 24px;
            height: 24px;
            border-radius: 4px;
            border: 0;
            background: #e5e7eb
        }

        .seat.available {
            background: #e5e7eb;
            cursor: pointer
        }

        .seat.sold {
            background: #cbd5e1;
            cursor: not-allowed
        }

        .seat.blocked {
            background: #eeeeee;
            cursor: not-allowed;
            opacity: .7
        }

        .seat.gap {
            visibility: hidden
        }

        .seat.selected {
            box-shadow: 0 0 0 3px #22c55e inset;
            background: #22c55e33
        }

        /* Legend */
        .legend {
            display: inline-block;
            width: 18px;
            height: 18px;
            border-radius: 4px;
            margin-right: 6px;
            vertical-align: middle
        }

        .legend-selected {
            box-shadow: 0 0 0 3px #22c55e inset;
            background: #22c55e33
        }

        .legend-blocked {
            background: #d1d5db
        }

        .legend-sold {
            background: #cbd5e1
        }

        .legend-type {
            width: 14px;
            height: 14px;
            background: #e5e7eb;
            border: 1px solid #d1d5db;
            border-radius: 3px
        }
        .table-lg th,
        .table-lg td {
            padding-top: 1rem;  /* tăng khoảng cách trên */
            padding-bottom: 1rem; /* tăng khoảng cách dưới */
            font-size: 1.05rem;  /* chữ to hơn một chút */
        }
        .form-control:focus {
            border-color: #dee2e6 !important;
            box-shadow: unset !important;
        }
    </style>
@endsection