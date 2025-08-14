@extends('web.layouts.app')
@section('title', $cinemaDetail->name)

@section('content')
    <div class="cinema-hero2 py-4">
        <div class="container">
            <div class="d-flex align-items-start gap-3">
                {{-- Avatar/logo rạp --}}
                <div class="cinema-avatar2 rounded-circle overflow-hidden flex-shrink-0">
                    @if(!empty($cinemaDetail->image))
                        <img src="{{ asset($cinemaDetail->image) }}" alt="{{ $cinemaDetail->name }}" class="w-100 h-100">
                    @endif
                </div>

                {{-- Thông tin --}}
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                        <h5 class="mb-0 fw-semibold">{{ $cinemaDetail->name }}</h5>
                        <span class="badge bg-primary-subtle text-primary border border-primary">{{ $cinemaDetail->type }}</span>
                    </div>

                    <div class="text-muted small mb-2">
                        {{ $cinemaDetail->location }}{{ $cinemaDetail->location ? ', ' : '' }}{{ $cinemaDetail->province }}
                    </div>

                    {{-- Meta: Bản đồ · Tỉnh/TP · Tên cụm rạp --}}
                    <div class="cinema-meta2 small mt-2 d-flex flex-wrap align-items-center gap-2">
                        <a class="link-primary text-decoration-none"
                            href="https://www.google.com/maps/search/?api=1&query={{ urlencode(($cinemaDetail->location ? $cinemaDetail->location . ', ' : '') . $cinemaDetail->province) }}"
                            target="_blank">Bản đồ</a>
                        <span class="text-secondary">·</span>
                        <span class="text-muted">{{ $cinemaDetail->province }}</span>
                        <span class="text-secondary">·</span>
                        <span class="text-muted">{{ $cinemaDetail->name }}</span>
                    </div>

                    @if(!empty($cinemaDetail->description))
                        <div class="text-muted small mt-2">{!! nl2br(e($cinemaDetail->description)) !!}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="container my-4">
        <div class="row">
            <!-- CỘT 3: LỊCH CHIẾU -->
            <div class="col-md-7">
                <!-- TAB NGÀY -->
                <div class="d-flex justify-content-between mb-2 p-0 border rounded" style="background-color: #edf2f9;">
                    <div class="d-flex">
                        @foreach ($availableDates as $date)
                            @php
                                $carbon = \Carbon\Carbon::parse($date);
                                $formattedDate = $carbon->format('j/n');
                                $weekday = $carbon->translatedFormat('D');
                                $isActive = request('date') === $date || (!request('date') && $loop->first);
                            @endphp

                            <a href="{{ request()->fullUrlWithQuery(['date' => $date]) }}"
                                class="p-2 time-showtimes btn btn-sm text-center {{ $isActive ? 'text-muted' : 'text-muted' }}"
                                style="width: 80px; min-height: 48px; border-radius: 0; {{ $isActive ? 'background-color: #c7d6ec; border-color: #bdcfe9;' : '' }}">
                                {{ $formattedDate }}<br>
                                <small>{{ $weekday }}</small>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- THÔNG BÁO -->
                <div class="alert alert-warning py-3 px-3 mb-2" style="font-size: 14px; background-color: #f6c343;">
                    <i class="bi bi-info-circle me-2"></i>Nhấn vào suất chiếu để tiến hành mua vé
                </div>

                <!-- ĐỊA CHỈ RẠP -->
                @if ($selectedCinemaId)
                    @php
                        $selectedCinema = \App\Models\Cinema::find($selectedCinemaId);
                        $formattedDate = $selectedDate 
                            ? \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d/m/Y') 
                            : '';
                    @endphp

                    @if ($selectedCinema)
                        <div class="border p-3 rounded text-dark mb-3 py-2" style="font-size: 13px; background: #edf2f9;">
                            <div class="mb-2">
                                <b>{{ $selectedCinema->name }}</b>
                                <b class="text-muted">
                                    @if ($formattedDate)
                                        · {{ $formattedDate }}
                                    @endif
                                </b>
                            </div>
                            <span class="text-muted">
                                {{ $selectedCinema->location }} – 
                            </span>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($selectedCinema->location) }}" class="text-decoration-none" target="_blank">Bản đồ</a>
                        </div>
                    @endif
                @endif

                <!-- PHIM -->
                @foreach ($showtimes as $date => $dayShowtimes)
                    @php
                        $carbonDate = \Carbon\Carbon::parse($date);
                        $formatted = $carbonDate->format('d/m') . ' - ' . $carbonDate->translatedFormat('l'); // VD: 08/08 - Thứ Năm
                        $groupedByMovie = $dayShowtimes->groupBy('movie_id');
                    @endphp

                    @foreach ($groupedByMovie as $movieShowtimes)
                        @php
                            $movie = $movieShowtimes->first()->movie;
                        @endphp

                        <div class="bg-white rounded border p-3 mb-3">
                            <div class="d-flex">
                                <img src="{{ asset($movie->image) }}" width="120" height="150" class="rounded me-3">
                                <div>
                                    <h6 class="mb-1"><a href="{{ route('movies.show', $movie->id) }}" class="text-decoration-none fw-bold text-dark">{{ $movie->title }}</a></h6>

                                    <div class="text-muted mb-1" style="font-size: 13px;">
                                        {{ $movie->director ?? 'Đạo diễn ẩn danh' }} · {{ $movie->language }} ·
                                        {{ $movie->duration }} phút ·
                                        @if ($movie->trailer_url)
                                            <a href="{{ $movie->trailer_url }}" target="_blank">Trailer</a>
                                        @endif
                                        <br>
                                        <span class="text-muted">{{ $movie->genre }}</span>
                                    </div>

                                    <div class="text-dark mb-2 fw-bold mt-2" style="font-size: 13px;">
                                        {{ $movie->language }}
                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($movieShowtimes as $showtime)
                                            @php
                                                $seatPrices = $showtime->room->seats->pluck('price');
                                                $seatPrice = $seatPrices->min() ?? 0;
                                                $finalPrice = $showtime->price + $seatPrice;
                                            @endphp

                                            <button class="btn btn-sm" style="border-color: black; font-size: 11px;">
                                                {{ \Carbon\Carbon::parse($showtime->show_time)->format('H:i') }}<br>
                                                <small class="text-muted">
                                                    {{ rtrim(rtrim(number_format($finalPrice / 1000, 1), '0'), '.') }}K
                                                </small>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
    <script>
        window.history.replaceState({}, document.title, "{{ url()->current() }}");
    </script>
@endsection