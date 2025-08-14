@extends('web.layouts.app')
@section('title', 'Tài khoản - ' . ($user->username ?? 'Tài khoản'))

@section('content')
    <div
        class="container-fluid movie-banner d-flex flex-column justify-content-center align-items-center text-white text-center">
        <h5 class="fw-bold mb-3 text-white">Tài khoản</h5>
        <p class="mb-0">
            Quản lý thông tin tài khoản của bạn.
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
                <a class="nav-link active" href="{{ route('user') }}">Tài khoản</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile.tickets') }}">Vé Đã Đặt</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}">Đăng Xuất</a>
            </li>
        </ul>
        
        {{-- Card form --}}
        <div class="row justify-content-start">
            <div class="col-12 col-lg-9 col-xl-9">
                @if(session('status'))
                    <div class="alert alert-warning">{{ session('status') }}</div>
                @endif
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('profile') }}" method="POST" enctype="multipart/form-data" class="row g-3 profile-form">
                            @csrf
                            @method('PUT')

                            {{-- Username --}}
                            <div class="col-md-6">
                                <label class="form-label">Tên tài khoản</label>
                                <input type="text" class="form-control" value="{{ $user->username }}" disabled>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                            </div>

                            {{-- Password --}}
                            <div class="col-md-6">
                                <label class="form-label">Mật khẩu mới</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Nhập mật khẩu mới">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Confirm password --}}
                            <div class="col-md-6">
                                <label class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    placeholder="Nhập lại mật khẩu">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Avatar --}}
                            <div class="col-md-12">
                                <label class="form-label">Ảnh đại diện</label>
                                <div class="input-group">
                                    <input class="form-control @error('avatar') is-invalid @enderror" type="file"
                                        name="avatar" accept="image/*" id="avatarInput">
                                    <button class="btn btn-outline-secondary" type="button" id="btnAvatarReset">Xoá</button>
                                    @error('avatar')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="small text-muted mt-1">JPG/PNG ≤ 2MB, tỉ lệ vuông đẹp nhất.</div>
                            </div>

                            {{-- Preview avatar --}}
                            <div class="col-12 d-flex align-items-center gap-3 mt-2">
                                <div class="avatar-preview rounded-circle overflow-hidden">
                                    <img id="avatarPreview"
                                        src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->username) . '&background=E5E7EB&color=111827&size=128' }}"
                                        class="w-100 h-100" style="object-fit: cover;">
                                </div>
                                <span class="text-muted small">Xem trước ảnh đại diện</span>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-dark px-4">Cập nhật</button>
                            </div>
                        </form>
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
    </style>

    {{-- JS: preview avatar + (mock) verify phone --}}
    <script>
        document.getElementById('avatarInput')?.addEventListener('change', e => {
            const file = e.target.files?.[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = ev => document.getElementById('avatarPreview').src = ev.target.result;
                reader.readAsDataURL(file);
            }
        });
        document.getElementById('btnAvatarReset')?.addEventListener('click', () => {
            document.getElementById('avatarInput').value = '';
        });
    </script>
@endsection