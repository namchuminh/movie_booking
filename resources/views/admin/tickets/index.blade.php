@extends('admin.layouts.app')
@section('title', 'Quản Lý Vé Xem Phim')

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
                    <li class="breadcrumb-item active">Vé</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('admin.tickets.index') }}">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-2">
                        <label for="movie_title">Tên phim</label>
                        <input type="text" name="movie_title" value="{{ request('movie_title') }}" class="form-control" placeholder="Nhập tên phim">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="cinema_name">Tên rạp</label>
                        <input type="text" name="cinema_name" value="{{ request('cinema_name') }}" class="form-control" placeholder="Tên rạp">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="room_name">Tên phòng</label>
                        <input type="text" name="room_name" value="{{ request('room_name') }}" class="form-control" placeholder="Tên phòng">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="user_name">Tên người dùng</label>
                        <input type="text" name="user_name" value="{{ request('user_name') }}" class="form-control" placeholder="Tên người dùng">
                    </div>
                    <div class="form-group col-md-4 text-right">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-search"></i> Lọc
                            </button>
                            <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">
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
            <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary float-right">
                <i class="fa fa-plus"></i> Thêm Vé
            </a>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên Phim</th>
                        <th>Tên Rạp</th>
                        <th>Tên Phòng</th>
                        <th>Ghế</th>
                        <th>Ngày Chiếu</th>
                        <th>Giờ Chiếu</th>
                        <th>Giá Vé</th>
                        <th>Người Dùng</th>
                        <th>Ngày Đặt</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                        <tr>
                            <td>{{ $loop->iteration + ($tickets->currentPage() - 1) * $tickets->perPage() }}</td>
                            <td>{{ $ticket->showtime->movie->title ?? '-' }}</td>
                            <td>{{ $ticket->seat->room->cinema->name ?? '-' }}</td>
                            <td>{{ $ticket->seat->room->name ?? '-' }}</td>
                            <td>{{ $ticket->seat->seat_code ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($ticket->showtime->show_date)->format('d/m/Y') }}</td>
                            <td>{{ $ticket->showtime->show_time }}</td>
                            <td>{{ number_format($ticket->showtime->price + $ticket->seat->price, 0) }} VNĐ</td>
                            <td>{{ $ticket->user->username ?? '-' }}</td>
                            <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.tickets.print', $ticket->id) }}" target="_blank" class="btn btn-info btn-sm">
                                    <i class="fas fa-print"></i> In Vé
                                </a>
                                <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa vé này?')">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="12">Không có vé nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $tickets->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
</section>
@endsection
