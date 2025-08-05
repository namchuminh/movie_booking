@extends('admin.layouts.app')
@section('title', 'Sửa Người Dùng')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quản Lý Người Dùng</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Người Dùng</a></li>
                    <li class="breadcrumb-item active">Sửa Người Dùng</li>
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
                    <h3 class="card-title">Chỉnh sửa thông tin người dùng</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.profiles.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Tên Đăng Nhập</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" placeholder="Tên đăng nhập">
                            @error('username') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" placeholder="Email">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Mật Khẩu Mới (để trống nếu không đổi)</label>
                            <input type="password" name="password" class="form-control" placeholder="Mật khẩu mới">
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Nhập Lại Mật Khẩu</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu">
                            @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Ảnh Đại Diện</label><br>
                            @if ($user->avatar)
                                <img src="{{ asset($user->avatar) }}" alt="avatar" width="120" height="120" class="mb-2">
                            @endif
                            <input type="file" name="avatar" class="form-control-file">
                            @error('avatar') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="text-right">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Quay Lại</a>
                            <button type="submit" class="btn btn-primary">Cập Nhật</button>
                        </div>

                    </form>
                </div>
            </div> 
        </div>
    </div>
</div>
</section>

@endsection
