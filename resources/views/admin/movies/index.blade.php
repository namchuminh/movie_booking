@extends('admin.layouts.app')
@section('title', 'Quản Lý Phim')

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
                        <li class="breadcrumb-item active">Phim</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <form class="form-inline row" method="GET" action="{{ route('admin.movies.index') }}">
                        <div class="col-md-3 mb-3">
                            <label for="title">Tên phim</label>
                            <input type="text" name="title" id="title" value="{{ request('title') }}" class="form-control w-100" placeholder="Tên phim">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="genre">Thể loại</label>
                            <input type="text" name="genre" id="genre" value="{{ request('genre') }}" class="form-control w-100" placeholder="Thể loại">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="release_date_from">Từ ngày</label>
                            <input type="date" name="release_date_from" id="release_date_from" value="{{ request('release_date_from') }}" class="form-control w-100">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="release_date_to">Đến ngày</label>
                            <input type="date" name="release_date_to" id="release_date_to" value="{{ request('release_date_to') }}" class="form-control w-100">
                        </div>

                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-search"></i> Lọc</button>
                            <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Xóa lọc</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.movies.create') }}" class="btn btn-primary float-right">
                        <i class="fa fa-plus"></i> Thêm Phim Mới
                    </a>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ảnh</th>
                                <th>Tên Phim</th>
                                <th>Thể Loại</th>
                                <th>Thời Lượng</th>
                                <th>Khởi Chiếu</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($movies as $movie)
                                <tr>
                                    <td>{{ $loop->iteration + ($movies->currentPage() - 1) * $movies->perPage() }}</td>
                                    <td>
                                        @if($movie->image)
                                            <img src="{{ asset($movie->image) }}" alt="{{ $movie->title }}" width="100" height="150">
                                        @else
                                            <span class="text-muted">Không có ảnh</span>
                                        @endif
                                    </td>
                                    <td>{{ $movie->title }}</td>
                                    <td>{{ $movie->genre }}</td>
                                    <td>{{ $movie->duration }} phút</td>
                                    <td>{{ \Carbon\Carbon::parse($movie->release_date)->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Xóa phim này?')">
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
                                    <td colspan="7">Không có phim nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $movies->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </section>
@endsection