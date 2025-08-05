@extends('admin.layouts.app')
@section('title', 'Chỉnh Sửa Khuyến Mãi Suất Chiếu')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Chỉnh Sửa Khuyến Mãi Suất Chiếu</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.ticket-promotions.index') }}">Khuyến Mãi Suất Chiếu</a></li>
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
                    <h3 class="card-title">Chỉnh sửa thông tin</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.ticket-promotions.update', $ticketPromotion->showtime_id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Suất Chiếu</label>
                            <select name="showtime_id" class="form-control">
                                <option value="">-- Chọn suất chiếu --</option>
                                @foreach($showtimes as $showtime)
                                    <option value="{{ $showtime->id }}" 
                                        {{ old('showtime_id', $ticketPromotion->showtime_id) == $showtime->id ? 'selected' : '' }}>
                                        {{ $showtime->movie->title }} | {{ $showtime->room->cinema->name }} - {{ $showtime->room->name }} | {{ $showtime->show_time }}
                                    </option>
                                @endforeach
                            </select>
                            @error('showtime_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Khuyến Mãi</label>
                            <select name="promo_id" class="form-control">
                                <option value="">-- Chọn khuyến mãi --</option>
                                @foreach($promotions as $promo)
                                    <option value="{{ $promo->id }}" 
                                        {{ old('promo_id', $ticketPromotion->promo_id) == $promo->id ? 'selected' : '' }}>
                                        {{ $promo->title }} | {{ $promo->value }}% ({{ \Carbon\Carbon::parse($promo->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($promo->end_date)->format('d/m/Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('promo_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="text-right">
                            <a href="{{ route('admin.ticket-promotions.index') }}" class="btn btn-secondary">Quay Lại</a>
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
