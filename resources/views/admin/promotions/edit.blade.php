@extends('admin.layouts.app')
@section('title', 'Chỉnh Sửa Khuyến Mãi')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Chỉnh Sửa Khuyến Mãi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.promotions.index') }}">Khuyến Mãi</a></li>
                    <li class="breadcrumb-item active">Chỉnh Sửa</li>
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
                    <h3 class="card-title">Chỉnh sửa thông tin khuyến mãi</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.promotions.update', $promotion->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Tiêu Đề</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $promotion->title) }}" placeholder="Tên khuyến mãi">
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Mô Tả</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Nội dung mô tả">{{ old('description', $promotion->description) }}</textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Ngày Bắt Đầu</label>
                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $promotion->start_date) }}">
                            @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Ngày Kết Thúc</label>
                            <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $promotion->end_date) }}">
                            @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Ảnh Khuyến Mãi</label><br>
                            @if($promotion->image)
                                <img src="{{ asset($promotion->image) }}" alt="Ảnh khuyến mãi" class="mb-2" style="max-height: 150px;">
                            @endif
                            <input type="file" name="image" class="form-control-file">
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="text-right">
                            <a href="{{ route('admin.promotions.index') }}" class="btn btn-secondary">Quay Lại</a>
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
