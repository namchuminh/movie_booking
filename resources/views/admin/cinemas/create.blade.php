@extends('admin.layouts.app')
@section('title', 'Thêm Rạp Phim')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quản Lý Rạp Phim</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.cinemas.index') }}">Rạp Phim</a></li>
                    <li class="breadcrumb-item active">Thêm Rạp</li>
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
                    <h3 class="card-title">Nhập thông tin rạp</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cinemas.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Tên Rạp</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Tên rạp">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Địa Chỉ</label>
                            <input type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="Địa chỉ chi tiết">
                            @error('location') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Số Điện Thoại</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="0123 456 789">
                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Ảnh Đại Diện</label>
                            <input type="file" name="image" class="form-control-file">
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="text-right">
                            <a href="{{ route('admin.cinemas.index') }}" class="btn btn-secondary">Quay Lại</a>
                            <button type="submit" class="btn btn-primary">Thêm Rạp</button>
                        </div>

                    </form>
                </div>
            </div> 
        </div>
    </div>
</div>
</section>

@endsection
