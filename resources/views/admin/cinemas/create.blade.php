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
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                        placeholder="Tên rạp">
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Tên Chuỗi Rạp</label>
                                    <select name="type" class="form-control">
                                        <option value="">-- Chọn chuỗi rạp --</option>
                                        @php
                                            $brands = [
                                                'CGV',
                                                'Lotte Cinema',
                                                'BHD Star Cineplex',
                                                'Galaxy Cinema',
                                                'Cinestar',
                                                'Mega GS',
                                                'Beta Cineplex',
                                                'Beta Cinema',
                                                'DCine',
                                                'Starlight',
                                                'Rap Tháng 8',
                                                'Rap Bến Thành',
                                                'Rap Đống Đa',
                                                'Cinebox',
                                                'YouCine',
                                                'The Loop',
                                                'Nhà Văn Hóa',
                                                'Xe chiếu phim lưu động',
                                            ];
                                        @endphp

                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand }}" {{ old('type') == $brand ? 'selected' : '' }}>
                                                {{ $brand }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                @php
                                    $areas = [
                                        ['name' => 'Tp. Hồ Chí Minh'],
                                        ['name' => 'Đồng Nai'],
                                        ['name' => 'Đắk Lắk'],
                                        ['name' => 'Đà Nẵng'],
                                        ['name' => 'Bình Định'],
                                        ['name' => 'Thái Nguyên'],
                                        ['name' => 'Hà Nội'],
                                        ['name' => 'Lâm Đồng'],
                                        ['name' => 'Thanh Hóa'],
                                        ['name' => 'Bắc Giang'],
                                        ['name' => 'Khánh Hòa'],
                                        ['name' => 'Sóc Trăng'],
                                        ['name' => 'Thừa Thiên – Huế'],
                                        ['name' => 'Gia Lai'],
                                        ['name' => 'Long An'],
                                        ['name' => 'Quảng Bình'],
                                        ['name' => 'Tiền Giang'],
                                        ['name' => 'Quảng Trị'],
                                        ['name' => 'Bình Dương'],
                                        ['name' => 'Kon Tum'],
                                        ['name' => 'Quảng Nam'],
                                        ['name' => 'Kiên Giang'],
                                        ['name' => 'Lào Cai'],
                                    ];
                                @endphp

                                <div class="form-group">
                                    <label>Tỉnh Thành</label>
                                    <select name="province" class="form-control">
                                        <option value="">-- Chọn tỉnh thành --</option>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area['name'] }}" {{ old('province') == $area['name'] ? 'selected' : '' }}>
                                                {{ $area['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('province') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Địa Chỉ</label>
                                    <input type="text" name="location" class="form-control" value="{{ old('location') }}"
                                        placeholder="Địa chỉ chi tiết">
                                    @error('location') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Số Điện Thoại</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}"
                                        placeholder="0123 456 789">
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