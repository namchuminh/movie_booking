@extends('admin.layouts.app')
@section('title', 'Chỉnh Sửa Ghế Ngồi')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quản Lý Ghế Ngồi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.seats.index') }}">Ghế Ngồi</a></li>
                    <li class="breadcrumb-item active">Chỉnh Sửa Ghế</li>
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
                    <h3 class="card-title">Chỉnh sửa thông tin ghế</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.seats.update', $seat->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Phòng Chiếu</label>
                            <select name="room_id" class="form-control">
                                <option value="">-- Chọn phòng --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ (old('room_id', $seat->room_id) == $room->id) ? 'selected' : '' }}>
                                        {{ $room->name }} ({{ $room->cinema->name ?? 'Không rõ rạp' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Mã Ghế</label>
                            <input type="text" name="seat_code" class="form-control" value="{{ old('seat_code', $seat->seat_code) }}" placeholder="A1, B2...">
                            @error('seat_code') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Loại Ghế</label>
                            <select name="seat_type" class="form-control">
                                <option value="">-- Chọn loại ghế --</option>
                                <option value="Thường" {{ old('seat_type', $seat->seat_type) == 'Thường' ? 'selected' : '' }}>Thường</option>
                                <option value="VIP" {{ old('seat_type', $seat->seat_type) == 'VIP' ? 'selected' : '' }}>VIP</option>
                                <option value="Đôi" {{ old('seat_type', $seat->seat_type) == 'Đôi' ? 'selected' : '' }}>Ghế Đôi</option>
                                <option value="Trẻ Em" {{ old('seat_type', $seat->seat_type) == 'Trẻ Em' ? 'selected' : '' }}>Ghế Trẻ Em</option>
                                <option value="Người Khuyết Tật" {{ old('seat_type', $seat->seat_type) == 'Người Khuyết Tật' ? 'selected' : '' }}>Ghế Người Khuyết Tật</option>
                            </select>
                            @error('seat_type') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Giá Ghế</label>
                            <input type="text" name="price" class="form-control" value="{{ old('price', $seat->price) }}" placeholder="Nhập giá ghế">
                            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="text-right">
                            <a href="{{ route('admin.seats.index') }}" class="btn btn-secondary">Quay Lại</a>
                            <button type="submit" class="btn btn-primary">Cập Nhật Ghế</button>
                        </div>

                    </form>
                </div>
            </div> 
        </div>
    </div>
</div>
</section>

@endsection
