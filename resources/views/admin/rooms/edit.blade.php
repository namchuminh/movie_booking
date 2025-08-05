@extends('admin.layouts.app')
@section('title', 'Chỉnh Sửa Phòng Chiếu')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Chỉnh Sửa Phòng Chiếu</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.rooms.index') }}">Phòng Chiếu</a></li>
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
                    <h3 class="card-title">Cập nhật thông tin phòng</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.rooms.update', $room->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Rạp</label>
                            <select name="cinema_id" class="form-control">
                                <option value="">-- Chọn rạp --</option>
                                @foreach($cinemas as $cinema)
                                    <option value="{{ $cinema->id }}" {{ old('cinema_id', $room->cinema_id) == $cinema->id ? 'selected' : '' }}>
                                        {{ $cinema->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cinema_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Tên Phòng</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $room->name) }}" placeholder="Phòng 1, Phòng VIP...">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Sức Chứa</label>
                            <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $room->capacity) }}" placeholder="120">
                            @error('capacity') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Loại Phòng</label>
                            <select name="type" class="form-control">
                                <option value="">-- Chọn loại phòng --</option>
                                @php
                                    $types = ['2D','3D','IMAX','4DX','LUXURY','STARIUM','DOLBY ATMOS','GOLD CLASS','KIDS','COUPLE'];
                                @endphp
                                @foreach($types as $type)
                                    <option value="{{ $type }}" {{ old('type', $room->type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="text-right">
                            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Quay Lại</a>
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
