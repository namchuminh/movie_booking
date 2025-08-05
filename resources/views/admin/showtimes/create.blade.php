@extends('admin.layouts.app')
@section('title', 'Thêm Suất Chiếu')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quản Lý Suất Chiếu</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.showtimes.index') }}">Suất Chiếu</a></li>
                    <li class="breadcrumb-item active">Thêm Suất</li>
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
                    <h3 class="card-title">Nhập thông tin suất chiếu</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.showtimes.store') }}">
                        @csrf

                        <div class="form-group">
                            <label>Phim</label>
                            <select name="movie_id" class="form-control">
                                <option value="">-- Chọn phim --</option>
                                @foreach($movies as $movie)
                                    <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
                                        {{ $movie->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('movie_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Phòng Chiếu</label>
                            <select name="room_id" class="form-control">
                                <option value="">-- Chọn phòng --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                        {{ $room->name }} ({{ $room->cinema->name ?? 'Không rõ rạp' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Ngày Chiếu</label>
                            <input type="date" name="show_date" class="form-control" value="{{ old('show_date') }}">
                            @error('show_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Giờ Chiếu</label>
                            <input type="time" name="show_time" class="form-control" value="{{ old('show_time') }}">
                            @error('show_time') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Giá Vé</label>
                            <input type="number" name="price" class="form-control" value="{{ old('price') }}" placeholder="Nhập giá vé" min="0">
                            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="text-right">
                            <a href="{{ route('admin.showtimes.index') }}" class="btn btn-secondary">Quay Lại</a>
                            <button type="submit" class="btn btn-primary">Thêm Suất Chiếu</button>
                        </div>

                    </form>
                </div>
            </div> 
        </div>
    </div>
</div>
</section>

@endsection
