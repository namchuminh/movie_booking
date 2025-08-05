@extends('admin.layouts.app')
@section('title', 'Quản Lý Ghế Ngồi')

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
                    <li class="breadcrumb-item active">Ghế Ngồi</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('admin.seats.index') }}">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-3">
                        <label for="seat_code">Mã Ghế</label>
                        <input type="text" name="seat_code" value="{{ request('seat_code') }}" class="form-control" placeholder="A1, B2...">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="seat_type">Loại Ghế</label>
                        <select name="seat_type" class="form-control">
                            <option value="">-- Chọn loại ghế --</option>
                            <option value="Thường" {{ old('seat_type') == 'Thường' ? 'selected' : '' }}>Thường</option>
                            <option value="VIP" {{ old('seat_type') == 'VIP' ? 'selected' : '' }}>VIP</option>
                            <option value="Đôi" {{ old('seat_type') == 'Đôi' ? 'selected' : '' }}>Ghế Đôi</option>
                            <option value="Trẻ Em" {{ old('seat_type') == 'Trẻ Em' ? 'selected' : '' }}>Ghế Trẻ Em</option>
                            <option value="Người Khuyết Tật" {{ old('seat_type') == 'Người Khuyết Tật' ? 'selected' : '' }}>Ghế Người Khuyết Tật</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="room_name">Tên Phòng</label>
                        <input type="text" name="room_name" value="{{ request('room_name') }}" class="form-control" placeholder="Phòng 1, Phòng VIP...">
                    </div>
                    <div class="form-group col-md-3 text-right">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-search"></i> Lọc
                            </button>
                            <a href="{{ route('admin.seats.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Xóa lọc
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.seats.create') }}" class="btn btn-primary float-right">
                <i class="fa fa-plus"></i> Thêm Ghế Mới
            </a>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mã Ghế</th>
                        <th>Loại Ghế</th>
                        <th>Tên Phòng</th>
                        <th>Rạp</th>
                        <th>Giá Ghế</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($seats as $seat)
                        <tr>
                            <td>{{ $loop->iteration + ($seats->currentPage() - 1) * $seats->perPage() }}</td>
                            <td>{{ $seat->seat_code }}</td>
                            <td>{{ $seat->seat_type }}</td>
                            <td>{{ $seat->room->name ?? '-' }}</td>
                            <td>{{ $seat->room->cinema->name ?? '-' }}</td>
                            <td>{{ number_format($seat->price, 0, ',', ',') }} VNĐ</td>
                            <td>
                                <a href="{{ route('admin.seats.edit', $seat->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.seats.destroy', $seat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa ghế này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="6">Không có ghế nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $seats->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
</section>
@endsection
