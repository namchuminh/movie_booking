@extends('admin.layouts.app')
@section('title', 'Quản Lý Người Dùng')

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
                    <li class="breadcrumb-item active">Người Dùng</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">

    {{-- FORM LỌC --}}
    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('admin.users.index') }}">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-3">
                        <label for="username">Tên đăng nhập</label>
                        <input type="text" name="username" value="{{ request('username') }}" class="form-control" placeholder="Nhập username">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="email">Email</label>
                        <input type="text" name="email" value="{{ request('email') }}" class="form-control" placeholder="Nhập email">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="role">Vai trò</label>
                        <select name="role" class="form-control">
                            <option value="">-- Tất cả --</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Khách Hàng</option>
                            <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Nhân Viên</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 text-right">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-search"></i> Lọc
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Xóa lọc
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- DANH SÁCH --}}
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary float-right">
                <i class="fa fa-plus"></i> Thêm Người Dùng
            </a>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ảnh Đại Diện</th>
                        <th>Tên Đăng Nhập</th>
                        <th>Email</th>
                        <th>Vai Trò</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td>
                                @if($user->avatar)
                                    <img src="{{ asset($user->avatar) }}" alt="avatar" width="80" height="80" class="rounded-circle">
                                @else
                                    <span class="text-muted">Không có ảnh</span>
                                @endif
                            </td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @switch($user->role)
                                    @case('admin')
                                        <span class="badge badge-danger">Admin</span>
                                        @break
                                    @case('customer')
                                        <span class="badge badge-success">Khách Hàng</span>
                                        @break
                                    @case('staff')
                                        <span class="badge badge-info">Nhân Viên</span>
                                        @break
                                    @default
                                        <span class="badge badge-secondary">Không xác định</span>
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa người dùng này?')">
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
                            <td colspan="6">Không có người dùng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
</section>
@endsection
