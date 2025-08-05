@extends('admin.layouts.app')
@section('title', 'Quản Lý Mã Vé')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quản Lý Mã Vé</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Mã Vé</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('admin.ticket-codes.index') }}">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-3">
                        <label for="code">Mã vé</label>
                        <input type="text" name="code" value="{{ request('code') }}" class="form-control" placeholder="Nhập mã vé">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="movie_title">Tên phim</label>
                        <input type="text" name="movie_title" value="{{ request('movie_title') }}" class="form-control" placeholder="Nhập tên phim">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="cinema_name">Tên rạp</label>
                        <input type="text" name="cinema_name" value="{{ request('cinema_name') }}" class="form-control" placeholder="Nhập tên rạp">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="username">Người dùng</label>
                        <input type="text" name="username" value="{{ request('username') }}" class="form-control" placeholder="Tên người dùng">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="show_date">Ngày chiếu</label>
                        <input type="date" name="show_date" value="{{ request('show_date') }}" class="form-control">
                    </div>
                    <div class="form-group col-md-9 text-right">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-search"></i> Lọc
                            </button>
                            <a href="{{ route('admin.ticket-codes.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Xóa lọc
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mã Vé</th>
                        <th>Tên Phim</th>
                        <th>Tên Rạp</th>
                        <th>Tên Phòng</th>
                        <th>Ghế</th>
                        <th>Ngày Chiếu</th>
                        <th>Giờ</th>
                        <th>Người Dùng</th>
                        <th>Ngày Đặt</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ticketCodes as $code)
                        <tr>
                            <td>{{ $loop->iteration + ($ticketCodes->currentPage() - 1) * $ticketCodes->perPage() }}</td>
                            <td>{{ $code->code }}</td>
                            <td>{{ $code->ticket->showtime->movie->title ?? '-' }}</td>
                            <td>{{ $code->ticket->seat->room->cinema->name ?? '-' }}</td>
                            <td>{{ $code->ticket->seat->room->name ?? '-' }}</td>
                            <td>{{ $code->ticket->seat->seat_code ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($code->ticket->showtime->show_date)->format('d/m/Y') }}</td>
                            <td>{{ $code->ticket->showtime->show_time }}</td>
                            <td>{{ $code->ticket->user->username ?? '-' }}</td>
                            <td>{{ $code->ticket->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="11">Không tìm thấy mã vé nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $ticketCodes->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
</section>
@endsection
