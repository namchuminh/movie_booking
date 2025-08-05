@extends('admin.layouts.app')
@section('title', 'Thêm Phòng Chiếu')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quản Lý Phòng Chiếu</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.rooms.index') }}">Phòng Chiếu</a></li>
                    <li class="breadcrumb-item active">Thêm Phòng</li>
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
                    <h3 class="card-title">Nhập thông tin phòng chiếu</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.rooms.store') }}">
                        @csrf

                        <div class="form-group">
                            <label>Rạp</label>
                            <select name="cinema_id" class="form-control">
                                <option value="">-- Chọn rạp --</option>
                                @foreach($cinemas as $cinema)
                                    <option value="{{ $cinema->id }}" {{ old('cinema_id') == $cinema->id ? 'selected' : '' }}>
                                        {{ $cinema->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cinema_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Tên Phòng</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Phòng 1, Phòng VIP...">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Sức Chứa</label>
                            <input type="number" name="capacity" class="form-control" value="{{ old('capacity') }}" placeholder="120">
                            @error('capacity') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Loại Phòng</label>
                            <select name="type" class="form-control">
                                <option value="">-- Chọn loại phòng --</option>
                                <option value="2D" {{ old('type') == '2D' ? 'selected' : '' }}>2D</option>
                                <option value="3D" {{ old('type') == '3D' ? 'selected' : '' }}>3D</option>
                                <option value="IMAX" {{ old('type') == 'IMAX' ? 'selected' : '' }}>IMAX</option>
                                <option value="4DX" {{ old('type') == '4DX' ? 'selected' : '' }}>4DX</option>
                                <option value="LUXURY" {{ old('type') == 'LUXURY' ? 'selected' : '' }}>Luxury</option>
                                <option value="STARIUM" {{ old('type') == 'STARIUM' ? 'selected' : '' }}>Starium</option>
                                <option value="DOLBY ATMOS" {{ old('type') == 'DOLBY ATMOS' ? 'selected' : '' }}>Dolby Atmos</option>
                                <option value="GOLD CLASS" {{ old('type') == 'GOLD CLASS' ? 'selected' : '' }}>Gold Class</option>
                                <option value="KIDS" {{ old('type') == 'KIDS' ? 'selected' : '' }}>Dành cho trẻ em</option>
                                <option value="COUPLE" {{ old('type') == 'COUPLE' ? 'selected' : '' }}>Couple</option>
                            </select>
                            @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="text-right">
                            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Quay Lại</a>
                            <button type="submit" class="btn btn-primary">Thêm Phòng</button>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>
</div>
</section>

@endsection
