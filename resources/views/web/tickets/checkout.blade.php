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
        <div class="step active">
            <i class="bi bi-credit-card-fill"></i>
            Thanh toán
        </div>
        <i class="bi bi-chevron-right text-muted"></i>
        <div class="step">
            <i class="bi bi-ticket-perforated-fill"></i>
            Thông tin vé
        </div>
    </div>

    <div class="container py-3">
        <div class="row g-4">
            {{-- LEFT: Thông tin đơn + danh sách ghế --}}
            <div class="col-lg-8">
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

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-semibold">Ghế đã chọn</div>
                    <div class="card-body p-0">
                        <div class="table-responsive p-2">
                            <table class="table table-sm align-middle mb-0 table-lg">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:20%">Mã ghế</th>
                                        <th style="width:30%">Loại</th>
                                        <th class="text-end" style="width:20%">Giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($selected as $s)
                                        <tr>
                                            <td class="fw-semibold">{{ $s['code'] }}</td>
                                            <td>{{ $s['type'] }}</td>
                                            <td class="text-end">{{ number_format($s['price']) }} ₫</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-end">Tổng</th>
                                        <th class="text-end h5 mb-0">{{ number_format($total) }} ₫</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Form thanh toán --}}
            <div class="col-lg-4">
                <form method="post" action="{{ route('tickets.payment') }}">
                    @csrf
                    <input type="hidden" name="seat_ids" value="{{ $seatIds }}">
                    <input type="hidden" name="amount" value="{{ $total }}">

                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-white fw-semibold">Thông tin liên hệ</div>
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="form-label">Họ và tên</label>
                                <input name="customer_name" class="form-control" value="{{ auth()->user() ? auth()->user()->username : '' }}" required>
                                @error('customer_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Email</label>
                                <input name="customer_email" type="email" class="form-control" value="{{ auth()->user() ? auth()->user()->email : '' }}" required>
                                @error('customer_email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Số điện thoại</label>
                                <input name="customer_phone" class="form-control" required>
                                @error('customer_phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-white fw-semibold">Phương thức thanh toán</div>
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="pay_method" id="pm1" value="card"
                                    checked>
                                <label class="form-check-label" for="pm1">Chuyển Khoản</label>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-danger w-100">Thanh toán {{ number_format($total) }} ₫</button>
                    <a href="{{ route('tickets.show', $showtime->id) }}" class="btn btn-outline-secondary w-100 mt-2">←
                        Quay lại chọn ghế</a>
                </form>
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