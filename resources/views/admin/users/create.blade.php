@extends('admin.layouts.app')
@section('title', 'Thêm Người Dùng')

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
                    <li class="breadcrumb-item active">Thêm Người Dùng</li>
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
                    <h3 class="card-title">Nhập thông tin người dùng</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Tên Đăng Nhập</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="Tên đăng nhập">
                            @error('username') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Mật Khẩu</label>
                            <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Nhập Lại Mật Khẩu</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu">
                            @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Vai Trò</label>
                            <select name="role" class="form-control">
                                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Nhân Viên</option>
                                <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Khách Hàng</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Ảnh Đại Diện</label>
                            <input type="file" name="avatar" class="form-control-file">
                            @error('avatar') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="text-right">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay Lại</a>
                            <button type="submit" class="btn btn-primary">Thêm Người Dùng</button>
                        </div>

                    </form>
                </div>
            </div> 
        </div>
    </div>
</div>
</section>

@endsection
