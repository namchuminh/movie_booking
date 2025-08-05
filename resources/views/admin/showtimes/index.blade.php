@extends('admin.layouts.app')
@section('title', 'Quản Lý Suất Chiếu')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quản Lý Suất Chiếu</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Suất Chiếu</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('admin.showtimes.index') }}">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-3">
                        <label for="movie_title">Tên phim</label>
                        <input type="text" name="movie_title" value="{{ request('movie_title') }}" class="form-control" placeholder="Nhập tên phim">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="show_date">Ngày chiếu</label>
                        <input type="date" name="show_date" value="{{ request('show_date') }}" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="cinema_name">Tên rạp</label>
                        <input type="text" name="cinema_name" value="{{ request('cinema_name') }}" class="form-control" placeholder="Tên rạp">
                    </div>
                    <div class="form-group col-md-3 text-right">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-search"></i> Lọc
                            </button>
                            <a href="{{ route('admin.showtimes.index') }}" class="btn btn-secondary">
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
            <a href="{{ route('admin.showtimes.create') }}" class="btn btn-primary float-right">
                <i class="fa fa-plus"></i> Thêm Suất Chiếu
            </a>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên Phim</th>
                        <th>Tên Rạp</th>
                        <th>Phòng</th>
                        <th>Ngày Chiếu</th>
                        <th>Giờ Chiếu</th>
                        <th>Giá Vé</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($showtimes as $showtime)
                        <tr>
                            <td>{{ $loop->iteration + ($showtimes->currentPage() - 1) * $showtimes->perPage() }}</td>
                            <td>{{ $showtime->movie->title ?? '-' }}</td>
                            <td>{{ $showtime->room->cinema->name ?? '-' }}</td>
                            <td>{{ $showtime->room->name ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($showtime->show_date)->format('d/m/Y') }}</td>
                            <td>{{ $showtime->show_time }}</td>
                            <td>{{ number_format($showtime->price, 0, ',', ',') }} VNĐ</td>
                            <td>
                                <a href="{{ route('admin.showtimes.edit', $showtime->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.showtimes.destroy', $showtime->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa suất chiếu này?')">
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
                            <td colspan="7">Không có suất chiếu nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $showtimes->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
</section>
@endsection
