@extends('admin.layouts.app')
@section('title', 'Quản Lý Phòng Chiếu')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quản Lý Phòng Chiếu</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Phòng Chiếu</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('admin.rooms.index') }}">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-3">
                        <label for="name">Tên phòng</label>
                        <input type="text" name="name" id="name" value="{{ request('name') }}" class="form-control" placeholder="Nhập tên phòng">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="type">Loại phòng</label>
                        <select name="type" class="form-control">
                            <option value="">-- Chọn loại phòng --</option>
                            <option value="2D" {{ old('type') == '2D' ? 'selected' : '' }}>2D</option>
                            <option value="3D" {{ old('type') == '3D' ? 'selected' : '' }}>3D</option>
                            <option value="IMAX" {{ old('type') == 'IMAX' ? 'selected' : '' }}>IMAX</option>
                            <option value="4DX" {{ old('type') == '4DX' ? 'selected' : '' }}>4DX</option>
                            <option value="LUXURY" {{ old('type') == 'LUXURY' ? 'selected' : '' }}>Luxury</option>
                            <option value="STARIUM" {{ old('type') == 'STARIUM' ? 'selected' : '' }}>Starium</option>
                            <option value="DOLBY ATMOS" {{ old('type') == 'DOLBY ATMOS' ? 'selected' : '' }}>Dolby Atmos</option>
                            <option value="GOLD CLASS" {{ old('type') == 'GOLD CLASS' ? 'selected' : '' }}>Gold Class</option>
                            <option value="KIDS" {{ old('type') == 'KIDS' ? 'selected' : '' }}>Dành cho trẻ em</option>
                            <option value="COUPLE" {{ old('type') == 'COUPLE' ? 'selected' : '' }}>Couple</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="cinema_name">Tên rạp</label>
                        <input type="text" name="cinema_name" id="cinema_name" value="{{ request('cinema_name') }}" class="form-control" placeholder="Tên rạp">
                    </div>
                    <div class="form-group col-md-3 text-right">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-search"></i> Lọc
                            </button>
                            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">
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
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary float-right">
                <i class="fa fa-plus"></i> Thêm Phòng Mới
            </a>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên phòng</th>
                        <th>Tên rạp</th>
                        <th>Loại phòng</th>
                        <th>Sức chứa</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rooms as $room)
                        <tr>
                            <td>{{ $loop->iteration + ($rooms->currentPage() - 1) * $rooms->perPage() }}</td>
                            <td>{{ $room->name }}</td>
                            <td>{{ $room->cinema->name ?? '-' }}</td>
                            <td>{{ $room->type }}</td>
                            <td>{{ $room->capacity }}</td>
                            <td>
                                <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa phòng này?')">
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
                            <td colspan="7">Không có phòng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $rooms->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
</section>
@endsection
