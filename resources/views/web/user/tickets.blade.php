@extends('web.layouts.app')
@section('title', 'Vé đã đặt')

@section('content')
    <div
        class="container-fluid movie-banner d-flex flex-column justify-content-center align-items-center text-white text-center">
        <h5 class="fw-bold mb-3 text-white">Vé đã đặt</h5>
        <p class="mb-0">
            Quản lý thông tin vé đã đặt của bạn.
        </p>
    </div>
    <div class="container" style="position: sticky; z-index: 999; margin-top: -35px;">
        <div class="d-flex align-items-center gap-3 pb-4 mt-1">
            <div class="avatar-wrap rounded-circle overflow-hidden">
                <img src="{{ $user->avatar ?? '' }}" alt="avatar"
                    class="w-100 h-100">
            </div>
            <div class="flex-grow-1">
                <div class="align-items-center gap-2 flex-wrap mt-4">
                    <h5 class="mb-0 fw-semibold">{{ $user->username }}</h5>
                    <h5 class="mb-0 text-muted mt-1" style="font-size: 14px;">{{ $user->email }}</h5>
                </div>
            </div>
        </div>

        {{-- Tabs --}}
        <ul class="nav nav-tabs small mb-4">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user') }}">Tài khoản</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('profile.tickets') }}">Vé Đã Đặt</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}">Đăng Xuất</a>
            </li>
        </ul>
        
        {{-- Card form --}}
        <div class="row justify-content-start">
            <div class="col-12 col-lg-12 col-xl-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
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
                                        <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('tickets.print', ['id' => $ticket->id]) }}" target="_blank" class="btn btn-danger btn-sm">
                                                <i class="bi bi-printer"></i> In Vé
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="12">Không có vé nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $tickets->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Styles --}}
    <style>
        .profile-hero .container {
            backdrop-filter: none;
        }

        .avatar-wrap {
            width: 96px;
            height: 96px;
            background: #fff;
            border: 2px solid #e5e7eb;
        }

        .avatar-preview {
            width: 64px;
            height: 64px;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
        }

        .nav-tabs .nav-link {
            color: #6b7280;
        }

        .nav-tabs .nav-link.active {
            color: #111827;
            font-weight: 600;
        }
        .form-control:disabled {
            background-color: white;
            opacity: 1;
            color: #6b7280;
            cursor: not-allowed;
        }
        .profile-form input:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }

        .active>.page-link, .page-link.active {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .page-link {
            color: #dc3545;
        }
        .page-link:focus {
            box-shadow: unset;
        }
    </style>
@endsection