@extends('admin.layouts.app')
@section('title', 'Thêm Vé Xem Phim')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quản Lý Vé</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.tickets.index') }}">Danh Sách Vé</a></li>
                    <li class="breadcrumb-item active">Thêm Vé</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Nhập thông tin vé</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.tickets.store') }}">
                        @csrf

                        {{-- Suất chiếu --}}
                        <div class="form-group">
                            <label>Suất Chiếu</label>
                            <select name="showtime_id" id="showtimeSelect" class="form-control">
                                <option value="">-- Chọn suất chiếu --</option>
                                @foreach($showtimes as $show)
                                    <option 
                                        value="{{ $show->id }}" 
                                        data-price="{{ $show->price ?? 0 }}" 
                                        {{ old('showtime_id') == $show->id ? 'selected' : '' }}
                                    >
                                        {{ $show->movie->title }} - {{ $show->show_date }} {{ $show->show_time }} ({{ number_format($show->price ?? 0) }}đ)
                                    </option>
                                @endforeach
                            </select>
                            @error('showtime_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- Ghế ngồi --}}
                        <div class="form-group">
                            <label>Ghế Ngồi</label>
                            <select name="seat_id" id="seatSelect" class="form-control">
                                <option value="">-- Chọn ghế --</option>
                                @foreach($seats as $seat)
                                    <option 
                                        value="{{ $seat->id }}" 
                                        data-price="{{ $seat->price ?? 0 }}" 
                                        {{ old('seat_id') == $seat->id ? 'selected' : '' }}
                                    >
                                        {{ $seat->seat_code }} - {{ $seat->room->name ?? 'Phòng?' }} ({{ $seat->room->cinema->name ?? 'Rạp?' }}) - {{ number_format($seat->price ?? 0) }}đ
                                    </option>
                                @endforeach
                            </select>
                            @error('seat_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- Giá vé (tự động tính) --}}
                        <div class="form-group">
                            <label>Giá Vé</label>
                            <input 
                                type="text" 
                                name="price" 
                                id="priceInput" 
                                class="form-control" 
                                value="{{ old('price') }}" 
                                readonly 
                                placeholder="Giá sẽ tự động tính"
                            >
                            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- Người dùng --}}
                        <div class="form-group">
                            <label>Tên Người Dùng</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="Nhập tên người dùng">
                            @error('username') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- Nút hành động --}}
                        <div class="text-right">
                            <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">Quay Lại</a>
                            <button type="submit" class="btn btn-primary">Thêm Vé</button>
                        </div>

                    </form>
                </div>
            </div> 
        </div>
    </div>
</div>
</section>
<script>
    function formatPriceVND(value) {
        return value.toLocaleString('vi-VN') + ' VNĐ';
    }

    function updatePrice() {
        const showtimePrice = parseFloat(document.querySelector('#showtimeSelect option:checked')?.dataset?.price || 0);
        const seatPrice = parseFloat(document.querySelector('#seatSelect option:checked')?.dataset?.price || 0);
        const total = Math.floor(showtimePrice + seatPrice); // đảm bảo số nguyên

        document.getElementById('priceInput').value = formatPriceVND(total);
    }

    document.getElementById('showtimeSelect').addEventListener('change', updatePrice);
    document.getElementById('seatSelect').addEventListener('change', updatePrice);

    window.addEventListener('DOMContentLoaded', updatePrice);
</script>
@endsection
