@extends('admin.layouts.app')
@section('title', 'Quản Lý Khuyến Mãi')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quản Lý Khuyến Mãi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Khuyến Mãi</li>
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
            <form method="GET" action="{{ route('admin.promotions.index') }}">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-3">
                        <label for="title">Tiêu đề</label>
                        <input type="text" name="title" id="title" value="{{ request('title') }}"
                            class="form-control" placeholder="Nhập tiêu đề khuyến mãi">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="start_date">Từ ngày</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                            class="form-control">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="end_date">Đến ngày</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                            class="form-control">
                    </div>

                    <div class="form-group col-md-3 text-right">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-search"></i> Lọc
                            </button>
                            <a href="{{ route('admin.promotions.index') }}" class="btn btn-secondary">
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
            <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary float-right">
                <i class="fa fa-plus"></i> Thêm Khuyến Mãi
            </a>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ảnh</th>
                        <th>Tiêu Đề</th>
                        <th>Ngày Áp Dụng</th>
                        <th>Ngày Kết Thúc</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($promotions as $promotion)
                        <tr>
                            <td>{{ $loop->iteration + ($promotions->currentPage() - 1) * $promotions->perPage() }}</td>
                            <td>
                                @if($promotion->image)
                                    <img src="{{ asset($promotion->image) }}" alt="Ảnh khuyến mãi" width="150" height="120">
                                @else
                                    <span class="text-muted">Không có ảnh</span>
                                @endif
                            </td>
                            <td>{{ $promotion->title }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($promotion->start_date)->format('d/m/Y') }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($promotion->end_date)->format('d/m/Y') }}
                            </td>
                            <td>
                                <a href="{{ route('admin.promotions.edit', $promotion->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.promotions.destroy', $promotion->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa khuyến mãi này?')">
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
                            <td colspan="11">Không có khuyến mãi nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            {{ $promotions->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
</section>
@endsection
