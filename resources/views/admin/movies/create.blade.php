@extends('admin.layouts.app')
@section('title', 'Thêm Phim')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quản Lý Phim</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.movies.index') }}">Quản Lý Phim</a></li>
                    <li class="breadcrumb-item active">Thêm Phim</li>
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
                    <h3 class="card-title">Nhập thông tin phim</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.movies.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Tên Phim</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Nhập tên phim">
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Thể Loại</label>
                            <select name="genre" class="form-control">
                                <option value="">-- Chọn thể loại --</option>
                                <option value="Hành động" {{ old('genre') == 'Hành động' ? 'selected' : '' }}>Hành động</option>
                                <option value="Tình cảm" {{ old('genre') == 'Tình cảm' ? 'selected' : '' }}>Tình cảm</option>
                                <option value="Kinh dị" {{ old('genre') == 'Kinh dị' ? 'selected' : '' }}>Kinh dị</option>
                                <option value="Hài hước" {{ old('genre') == 'Hài hước' ? 'selected' : '' }}>Hài hước</option>
                                <option value="Phiêu lưu" {{ old('genre') == 'Phiêu lưu' ? 'selected' : '' }}>Phiêu lưu</option>
                                <option value="Hoạt hình" {{ old('genre') == 'Hoạt hình' ? 'selected' : '' }}>Hoạt hình</option>
                                <option value="Khoa học viễn tưởng" {{ old('genre') == 'Khoa học viễn tưởng' ? 'selected' : '' }}>Khoa học viễn tưởng</option>
                                <option value="Tài liệu" {{ old('genre') == 'Tài liệu' ? 'selected' : '' }}>Tài liệu</option>
                                <option value="Âm nhạc" {{ old('genre') == 'Âm nhạc' ? 'selected' : '' }}>Âm nhạc</option>
                                <option value="Chiến tranh" {{ old('genre') == 'Chiến tranh' ? 'selected' : '' }}>Chiến tranh</option>
                            </select>
                            @error('genre') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Thời Lượng (phút)</label>
                            <input type="number" name="duration" class="form-control" value="{{ old('duration') }}" placeholder="120">
                            @error('duration') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Ngày Khởi Chiếu</label>
                            <input type="date" name="release_date" class="form-control" value="{{ old('release_date') }}">
                            @error('release_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Ngôn Ngữ</label>
                            <input type="text" name="language" class="form-control" value="{{ old('language') }}" placeholder="Tiếng Việt, English...">
                            @error('language') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Ảnh Poster</label>
                            <input type="file" name="image" class="form-control-file">
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Trailer URL</label>
                            <input type="text" name="trailer_url" class="form-control" value="{{ old('trailer_url') }}" placeholder="https://youtube.com/...">
                            @error('trailer_url') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Diễn Viên</label>
                            <textarea name="actors" class="form-control" rows="2" placeholder="Tên các diễn viên, cách nhau bởi dấu phẩy">{{ old('actors') }}</textarea>
                            @error('actors') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Đạo Diễn</label>
                            <input type="text" name="director" class="form-control" value="{{ old('director') }}" placeholder="Tên đạo diễn">
                            @error('director') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Mô Tả</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Mô tả ngắn về phim...">{{ old('description') }}</textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="text-right">
                            <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">Quay Lại</a>
                            <button type="submit" class="btn btn-primary">Thêm Phim</button>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>
</div>
</section>

@endsection
