@extends('web.layouts.app')
@section('title', 'Tìm kiếm')

@section('content')

    <div class="container-fluid mb-3 movie-banner d-flex flex-column justify-content-center align-items-center text-white text-center">
        <h5 class="fw-bold mb-3 text-white">Tìm kiếm phim</h5>
        <p class="mb-0">
            Kết quả tìm kiếm cho: <strong>{{ request('query') }}</strong>
        </p>
    </div>

    <div class="container my-4">
        <div class="row">
            <!-- Bộ lọc bên trái (hiển thị trên màn hình lớn) -->
            <div class="col-lg-2 d-none d-lg-block">
                @php
                    $sort = request('sort');
                    $genre = request('genre');
                    $language = request('language');
                @endphp

                <div class="dropdown mb-3">
                    <button class="btn border-dark w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        {{ $sort === 'oldest' ? 'Cũ nhất' : 'Mới nhất' }}
                    </button>
                    <ul class="dropdown-menu w-100 shadow-sm">
                        <li>
                            <a class="dropdown-item {{ $sort === 'newest' || !$sort ? 'active' : '' }}"
                            href="{{ route('search', array_filter([
                                'genre' => $genre,
                                'language' => $language,
                                'sort' => 'newest'
                            ])) }}">
                            Mới nhất
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ $sort === 'oldest' ? 'active' : '' }}"
                            href="{{ route('search', array_filter([
                                'genre' => $genre,
                                'language' => $language,
                                'sort' => 'oldest'
                            ])) }}">
                            Cũ nhất
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Bộ lọc Thể loại -->
                @php
                    $genres = [
                        'Hành động', 'Tình cảm', 'Kinh dị', 'Hài hước',
                        'Phiêu lưu', 'Hoạt hình', 'Khoa học viễn tưởng',
                        'Tài liệu', 'Âm nhạc', 'Chiến tranh'
                    ];

                    $selectedGenre = request('genre');
                @endphp

                <div class="dropdown mb-3">
                    <button class="btn border-dark w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        {{ $selectedGenre ?? 'Thể loại' }}
                    </button>
                    <ul class="dropdown-menu w-100 shadow-sm">
                        <li>
                            <a class="dropdown-item {{ is_null($genre) ? 'active' : '' }}"
                            href="{{ route('search', array_filter([
                                'language' => $language,
                                'sort' => $sort
                            ])) }}">
                                Tất cả
                            </a>
                        </li>
                        @foreach ($genres as $item)
                            <li>
                                <a class="dropdown-item {{ $genre === $item ? 'active' : '' }}"
                                href="{{ route('search', array_filter([
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

                @php
                    $languages = ['Tiếng Việt', 'Lồng tiếng', 'Phụ đề'];
                @endphp

                <div class="dropdown mb-3">
                    <button class="btn border-dark w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        {{ $language ?? 'Ngôn ngữ' }}
                    </button>
                    <ul class="dropdown-menu w-100 shadow-sm">
                        <li>
                            <a class="dropdown-item {{ is_null($language) ? 'active' : '' }}"
                            href="{{ route('search', array_filter([
                                'genre' => $genre,
                                'sort' => $sort
                            ])) }}">
                                Tất cả
                            </a>
                        </li>
                        @foreach ($languages as $lang)
                            <li>
                                <a class="dropdown-item {{ $language === $lang ? 'active' : '' }}"
                                href="{{ route('search', array_filter([
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
                                <!-- Poster -->
                                <div class="poster-wrapper position-relative">
                                    <img src="{{ $movie->image }}" class="w-100 h-100" alt="{{ $movie->title }}">

                                    <span class="badge-custom bg-danger text-white fw-semibold">{{ $movie->age }}+</span>
                                </div>

                                <!-- Info -->
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