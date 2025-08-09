@extends('admin.layouts.app')
@section('title', 'Khuyến Mãi Theo Phim')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Khuyến Mãi Theo Phim</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Khuyến Mãi Theo Phim</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.ticket-promotions.create') }}" class="btn btn-primary float-right">
                <i class="fa fa-plus"></i> Áp Dụng Khuyến Mãi
            </a>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên Phim</th>
                        <th>Khuyến Mãi</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ticketPromotions as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($ticketPromotions->currentPage() - 1) * $ticketPromotions->perPage() }}</td>
                            <td>
                                {{ $item->movie->title ?? 'N/A' }}
                            </td>
                            <td>{{ $item->promotion->title ?? 'N/A' }}<br>Giá trị giảm: {{ $item->promotion->value ?? 'N/A' }}%</td>
                            <td>
                                <a href="{{ route('admin.ticket-promotions.edit', $item->movie_id ) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.ticket-promotions.destroy', $item->movie_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa áp dụng này?')">
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
                            <td colspan="11">Chưa có áp dụng khuyến mãi nào cho suất chiếu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            {{ $ticketPromotions->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
</section>
@endsection
