@extends('web.layouts.app')
@section('title', 'Sắp chiếu')

@section('content')

<div class="container-fluid mb-3 movie-banner d-flex flex-column justify-content-center align-items-center text-white text-center">
    <h5 class="fw-bold mb-3 text-white">Sắp chiếu</h5>
    <p class="mb-0">
        Danh sách các phim dự kiến sẽ khởi chiếu tại các hệ thống rạp trên toàn quốc.
    </p>
</div>

<div class="container my-4">
    <div class="row">

        <!-- Bộ lọc bên trái -->
        <div class="col-lg-2 d-none d-lg-block">
            @php
                $sort = request('sort');
                $genre = request('genre');
                $language = request('language');

                $genres = [
                    'Hành động', 'Tình cảm', 'Kinh dị', 'Hài hước',
                    'Phiêu lưu', 'Hoạt hình', 'Khoa học viễn tưởng',
                    'Tài liệu', 'Âm nhạc', 'Chiến tranh'
                ];

                $languages = ['Tiếng Việt', 'Lồng tiếng', 'Phụ đề'];
            @endphp

            <!-- Thể loại -->
            <div class="dropdown mb-3">
                <button class="btn border-dark w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    {{ $genre ?? 'Thể loại' }}
                </button>
                <ul class="dropdown-menu w-100 shadow-sm">
                    <li>
                        <a class="dropdown-item {{ is_null($genre) ? 'active' : '' }}"
                           href="{{ route('movies.coming_soon', array_filter([
                               'language' => $language,
                               'sort' => $sort
                           ])) }}">
                            Tất cả
                        </a>
                    </li>
                    @foreach ($genres as $item)
                        <li>
                            <a class="dropdown-item {{ $genre === $item ? 'active' : '' }}"
                               href="{{ route('movies.coming_soon', array_filter([
                                   'genre' => $item,
                                   'language' => $language,
                                   'sort' => $sort
                               ])) }}">
                                {{ $item }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Ngôn ngữ -->
            <div class="dropdown mb-3">
                <button class="btn border-dark w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    {{ $language ?? 'Ngôn ngữ' }}
                </button>
                <ul class="dropdown-menu w-100 shadow-sm">
                    <li>
                        <a class="dropdown-item {{ is_null($language) ? 'active' : '' }}"
                           href="{{ route('movies.coming_soon', array_filter([
                               'genre' => $genre,
                               'sort' => $sort
                           ])) }}">
                            Tất cả
                        </a>
                    </li>
                    @foreach ($languages as $lang)
                        <li>
                            <a class="dropdown-item {{ $language === $lang ? 'active' : '' }}"
                               href="{{ route('movies.coming_soon', array_filter([
                                   'genre' => $genre,
                                   'sort' => $sort,
                                   'language' => $lang
                               ])) }}">
                                {{ $lang }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Danh sách phim -->
        <div class="col-12 col-lg-10">
            <div class="row">
                @forelse ($movies as $movie)
                    <div class="col-6 col-sm-4 col-md-3 col-xxl-1-5 mb-4">
                        <a href="{{ route('movies.show', $movie->id) }}" class="movie-card shadow-sm text-dark">
                            <div class="poster-wrapper position-relative">
                                <img src="{{ $movie->image }}" class="w-100 h-100" alt="{{ $movie->title }}">
                                <span class="badge-custom bg-danger text-white fw-semibold">{{ $movie->age }}+</span>
                            </div>
                            <div class="p-2">
                                <div class="fw-semibold small text-truncate" title="{{ $movie->title }}">
                                    {{ $movie->title }}
                                </div>
                                <div class="d-flex justify-content-between small text-muted">
                                    <span>Khởi chiếu: {{ \Carbon\Carbon::parse($movie->release_date)->format('d/m') }}</span>
                                    @if ($movie->rating)
                                        <span class="text-success">
                                            <i class="bi bi-hand-thumbs-up"></i> {{ $movie->rating }}%
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">Không có phim phù hợp.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection