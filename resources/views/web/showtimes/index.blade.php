@extends('web.layouts.app')
@section('title', 'Lịch chiếu phim rạp')

@section('content')

    <div class="container-fluid mb-3 movie-banner d-flex flex-column justify-content-center align-items-center text-white text-center">
            <h5 class="fw-bold mb-3 text-white">Lịch chiếu</h5>
            <p class="mb-0">
                Tìm lịch chiếu phim / rạp nhanh nhất với chỉ 1 bước!
            </p>
    </div>
    <div class="container my-4">
        <div class="row">
            <!-- CỘT 1: KHU VỰC -->
            <div class="col-md-3">
                <div class="bg-light rounded border" style="font-size: 14px;">
                    <div class="fw-bold text-dark p-3"  style="background-color: #edf2f9;">Khu vực</div>
                    <ul class="list-group list-group-flush">
                        @foreach ($areas as $index => $area)
                            <li class="list-group-item p-0 bg-white">
                                <a href="{{ route('showtimes.index', ['province' => $area['province']]) }}"
                                    class="d-flex justify-content-between align-items-center px-3 py-3 text-decoration-none
                                                {{ $area['province'] === $selectedProvinceDisplay ? 'text-white bg-active' : 'text-muted' }}">
                                    {{ $area['province'] }}
                                    <span
                                        class="badge 
                                                        {{ $area['province'] === $selectedProvinceDisplay ? 'bg-active text-white' : 'bg-active text-white' }}">
                                        {{ $area['count'] }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>


            <!-- CỘT 2: RẠP -->
            <div class="col-md-3">
                <div class="bg-light rounded border" style="font-size: 14px;">
                    @php
                        $defaultSelectedId = optional($cinemasByType->first()->first())->id;
                        $activeId = $selectedCinemaId ?? $defaultSelectedId;
                    @endphp

                    @foreach ($cinemasByType as $type => $cinemas)
                        <div class="fw-bold p-3 text-dark" style="background: #edf2f9;">
                            {{ $type }}
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($cinemas as $cinema)
                                <li
                                    class="list-group-item {{ $cinema->id == $activeId ? 'text-white bg-active' : 'bg-white' }}">
                                    <a href="{{ route('showtimes.index', ['province' => $selectedProvinceDisplay, 'cinema_id' => $cinema->id]) }}"
                                        class="py-2 text-decoration-none d-block {{ $cinema->id == $activeId ? 'text-white' : 'text-muted' }}">
                                        {{ $cinema->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </div>

            <!-- CỘT 3: LỊCH CHIẾU -->
            <div class="col-md-6">
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
                                    <h6 class="mb-1"><a href="#" class="text-decoration-none fw-bold text-dark">{{ $movie->title }}</a></h6>

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

                                            <a href="{{ route('tickets.show', $showtime->id) }}" class="btn btn-sm" style="border-color: black; font-size: 11px;">
                                                {{ \Carbon\Carbon::parse($showtime->show_time)->format('H:i') }}<br>
                                                <small class="text-muted">
                                                    {{ rtrim(rtrim(number_format($finalPrice / 1000, 1), '0'), '.') }}K
                                                </small>
                                            </a>
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