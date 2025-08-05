<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Vé Xem Phim</title>
    <style>
        body {
            margin: 0;
            font-family: 'Courier New', Courier, monospace;
            background-color: white;
            padding: 20px;
        }

        .ticket {
            width: 360px;
            margin: auto;
            padding: 15px;
            border: 2px dashed #000;
            border-radius: 5px;
            background: #f8f8f8;
        }

        .header {
            text-align: center;
            font-weight: bold;
            font-size: 15px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .cinema-info, .movie-info, .price-info, .footer {
            font-size: 15px;
            line-height: 1.5;
        }

        .section {
            margin-bottom: 10px;
        }

        .barcode {
            text-align: center;
            margin-top: 15px;
        }

        .barcode img {
            width: 180px;
            height: auto;
        }

        .print-btn {
            text-align: center;
            margin-top: 20px;
        }

        .print-btn button {
            padding: 8px 20px;
            font-size: 14px;
            background: black;
            color: white;
            border: none;
            cursor: pointer;
        }

        @media print {
            .print-btn {
                display: none;
            }
            body {
                background: white;
            }
        }
    </style>
</head>
<body>

<div class="ticket">
    {{-- Tiêu đề --}}
    <div class="header">
        THẺ VÀO<br>PHÒNG CHIẾU PHIM
    </div>

    {{-- Thông tin rạp --}}
    <div class="cinema-info section">
        <strong>{{ $ticket->seat->room->cinema->name }}</strong><br>
        {{ $ticket->seat->room->cinema->location ?? 'Chưa có địa chỉ' }}
    </div>

    {{-- Ngày giờ, ghế, phòng --}}
    <div class="section movie-info">
        Ngày: {{ \Carbon\Carbon::parse($ticket->showtime->show_date)->format('d/M/Y') }} &nbsp;&nbsp; Giờ: {{ $ticket->showtime->show_time }}<br>
        Phòng: {{ $ticket->seat->room->name }} &nbsp;&nbsp; Ghế: {{ $ticket->seat->seat_code }}<br>
        Nhân viên: {{ auth()->user()->name ?? 'Admin' }}
    </div>

    {{-- Tên phim --}}
    <div class="section" style="text-transform: uppercase; font-weight: bold; font-size: 14px;">
        {{ $ticket->showtime->movie->title }}
    </div>

    {{-- Giá vé --}}
    <div class="price-info section">
        Loại vé: Người lớn<br>
        Giá vé: {{ number_format($ticket->showtime->price, 0) }} VNĐ (đã gồm VAT)<br>
        Giá ghế: {{ number_format($ticket->seat->price, 0) }} VNĐ (đã gồm VAT)<br>
        <strong>Tổng: {{ number_format($ticket->showtime->price + $ticket->seat->price, 0) }} VNĐ</strong>
    </div>

    {{-- Mã QR --}}
    <div class="barcode">
        @if ($ticket->ticketCode)
            <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ urlencode(route('admin.ticket-codes.index', ['code' => $ticket->ticketCode->code])) }}&size=120x120" alt="QR Code">
        @else
            <p>Không có mã vé</p>
        @endif
    </div>

    <hr>

    {{-- Cảm ơn quý khách --}}
    <div class="footer">
        Cảm ơn quý khách đã đặt vé!<br>
        Hãy giữ vé này để vào phòng chiếu.
    </div>
</div>

<div class="print-btn">
    <button onclick="window.print()">🖨️ In Vé</button>
</div>

<script>
    window.onload = function () {
        setTimeout(() => window.print(), 400);
    };
</script>

</body>
</html>
