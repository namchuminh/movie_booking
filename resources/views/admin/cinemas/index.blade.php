@extends('admin.layouts.app')
@section('title', 'Quản Lý Rạp')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quản Lý Rạp Chiếu</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Rạp</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('admin.cinemas.index') }}">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-3">
                        <label for="name">Tên rạp</label>
                        <input type="text" name="name" id="name" value="{{ request('name') }}"
                            class="form-control" placeholder="Nhập tên rạp">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="location">Địa chỉ</label>
                        <input type="text" name="location" id="location" value="{{ request('location') }}"
                            class="form-control" placeholder="Nhập địa chỉ">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" name="phone" id="phone" value="{{ request('phone') }}"
                            class="form-control" placeholder="Nhập số điện thoại">
                    </div>

                    <div class="form-group col-md-3 text-right">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-search"></i> Lọc
                            </button>
                            <a href="{{ route('admin.cinemas.index') }}" class="btn btn-secondary">
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
            <a href="{{ route('admin.cinemas.create') }}" class="btn btn-primary float-right">
                <i class="fa fa-plus"></i> Thêm Rạp Mới
            </a>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ảnh</th>
                        <th>Tên Rạp</th>
                        <th>Địa Chỉ</th>
                        <th>Điện Thoại</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cinemas as $cinema)
                        <tr>
                            <td>{{ $loop->iteration + ($cinemas->currentPage() - 1) * $cinemas->perPage() }}</td>
                            <td>
                                @if($cinema->image)
                                    <img src="{{ asset($cinema->image) }}" alt="{{ $cinema->name }}" width="150" height="150">
                                @else
                                    <span class="text-muted">Không có ảnh</span>
                                @endif
                            </td>
                            <td>{{ $cinema->name }}</td>
                            <td>{{ $cinema->location }}</td>
                            <td>{{ $cinema->phone ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.cinemas.edit', $cinema->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.cinemas.destroy', $cinema->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa rạp này?')">
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
                            <td colspan="6">Không có rạp nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $cinemas->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
</section>
@endsection
