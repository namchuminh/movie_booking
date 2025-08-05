@extends('admin.layouts.app')
@section('title', 'Cập Nhật Phim')

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
                    <li class="breadcrumb-item active">Cập Nhật Phim</li>
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
                    <h3 class="card-title">Chỉnh sửa thông tin phim</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.movies.update', $movie->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Tên Phim</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $movie->title) }}" placeholder="Nhập tên phim">
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Thể Loại</label>
                            <select name="genre" class="form-control">
                                <option value="">-- Chọn thể loại --</option>
                                @foreach (['Hành động', 'Tình cảm', 'Kinh dị', 'Hài hước', 'Phiêu lưu', 'Hoạt hình', 'Khoa học viễn tưởng', 'Tài liệu', 'Âm nhạc', 'Chiến tranh'] as $genre)
                                    <option value="{{ $genre }}" {{ old('genre', $movie->genre) == $genre ? 'selected' : '' }}>{{ $genre }}</option>
                                @endforeach
                            </select>
                            @error('genre') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Thời Lượng (phút)</label>
                            <input type="number" name="duration" class="form-control" value="{{ old('duration', $movie->duration) }}" placeholder="120">
                            @error('duration') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Ngày Khởi Chiếu</label>
                            <input type="date" name="release_date" class="form-control" value="{{ old('release_date', $movie->release_date) }}">
                            @error('release_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Ngôn Ngữ</label>
                            <input type="text" name="language" class="form-control" value="{{ old('language', $movie->language) }}" placeholder="Tiếng Việt, English...">
                            @error('language') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Ảnh Poster</label>
                            @if($movie->image)
                                <div class="mb-2">
                                    <img src="{{ asset($movie->image) }}" alt="Poster" width="150" height="200">
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control-file">
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Trailer URL</label>
                            <input type="text" name="trailer_url" class="form-control" value="{{ old('trailer_url', $movie->trailer_url) }}" placeholder="https://youtube.com/...">
                            @error('trailer_url') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Diễn Viên</label>
                            <textarea name="actors" class="form-control" rows="2" placeholder="Tên các diễn viên, cách nhau bởi dấu phẩy">{{ old('actors', $movie->actors) }}</textarea>
                            @error('actors') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Đạo Diễn</label>
                            <input type="text" name="director" class="form-control" value="{{ old('director', $movie->director) }}" placeholder="Tên đạo diễn">
                            @error('director') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Mô Tả</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Mô tả ngắn về phim...">{{ old('description', $movie->description) }}</textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="text-right">
                            <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">Quay Lại</a>
                            <button type="submit" class="btn btn-primary">Cập Nhật Phim</button>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>
</div>
</section>

@endsection
