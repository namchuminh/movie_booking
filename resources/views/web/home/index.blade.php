@extends('web.layouts.app')
@section('title', 'Trang Chủ')

@section('content')
    <div class="container-fluid bg-light py-4 border-bottom">
        <div class="container">
            <h5 class="text-center mb-4">Mua vé theo phim</h5>

            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3 justify-content-center">
                @foreach ($movies->take(9) as $movie)
                    <div class="col bg-white border rounded" style="max-width: 140px;">
                        <div>
                            <div class="position-relative">
                                <a href="#" class="text-decoration-none border-none">
                                    <img src="{{ asset($movie->image) }}" class="rounded w-100" style="height: 170px;">
                                </a>
                                <a href="#"
                                    class="fw-bold position-absolute bottom-0 start-0 end-0 bg-danger text-white py-1 text-decoration-none text-center"
                                    style="font-size: 12px;">Mua vé</a>
                            </div>
                            <div class="text-dark mt-2 fw-bold" style="font-size: 13px; overflow: hidden;">
                                <a href="#" class="text-decoration-none text-dark">{{ $movie->title }}</a>
                            </div>
                            <div class="text-muted fw-bold" style="font-size: 12px;">
                                {{ \Carbon\Carbon::parse($movie->release_date)->format('d/m') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- PHẦN 'MUA VÉ THEO RẠP' CHUẨN THEO GIAO DIỆN HÌNH ẢNH MỚI -->

    <div class="container my-4">
        <h5 class="text-center mb-4">Mua vé theo rạp</h5>
        <div class="row">
            <!-- CỘT 1: KHU VỰC -->
            <div class="col-md-3">
                <div class="bg-white rounded shadow-sm py-2 px-2" style="font-size: 14px;">
                    <div class="fw-bold mb-2 text-secondary">Khu vực</div>
                    <ul class="list-group list-group-flush">
                        @foreach ($areas as $index => $area)
                            <li class="list-group-item p-0">
                                <a href="{{ route('home', ['province' => $area['province']]) }}"
                                    class="d-flex justify-content-between align-items-center px-3 py-2 text-decoration-none
                                                {{ $area['province'] === $selectedProvinceDisplay ? 'text-white bg-danger fw-bold rounded' : 'text-muted' }}">
                                    {{ $area['province'] }}
                                    <span
                                        class="badge 
                                                        {{ $area['province'] === $selectedProvinceDisplay ? 'bg-light text-danger' : 'bg-light text-dark' }}">
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
                <div class="bg-white rounded shadow-sm py-2 px-2" style="font-size: 14px;">
                    @php
                        $defaultSelectedId = optional($cinemasByType->first()->first())->id;
                        $activeId = $selectedCinemaId ?? $defaultSelectedId;
                    @endphp

                    @foreach ($cinemasByType as $type => $cinemas)
                        <div class="fw-bold {{ !$loop->first ? 'my-2' : 'mb-2' }} text-secondary">
                            {{ $type }}
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($cinemas as $cinema)
                                <li
                                    class="list-group-item {{ $cinema->id == $activeId ? 'text-white bg-danger fw-bold rounded' : '' }}">
                                    <a href="{{ route('home', ['province' => $selectedProvinceDisplay, 'cinema_id' => $cinema->id]) }}"
                                        class="text-decoration-none d-block {{ $cinema->id == $activeId ? 'text-white' : 'text-muted' }}">
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
                <div class="d-flex justify-content-between mb-2 bg-light p-2">
                    <div class="d-flex gap-2 flex-wrap">
                        @foreach ($availableDates as $date)
                        @php
                            $carbon = \Carbon\Carbon::parse($date);
                            $formattedDate = $carbon->format('j/n');
                            $weekday = $carbon->translatedFormat('D');
                            $isActive = request('date') === $date || (!request('date') && $loop->first);
                        @endphp

                        <a href="{{ request()->fullUrlWithQuery(['date' => $date]) }}"
                            class="btn btn-sm border-end pe-3 text-center fw-bold {{ $isActive ? 'text-danger' : 'text-muted' }}"
                            style="width: 60px; min-height: 48px; border-radius: 0;">
                            {{ $formattedDate }}<br>
                            <small>{{ $weekday }}</small>
                        </a>
                    @endforeach
                    </div>
                </div>

                <!-- THÔNG BÁO -->
                <div class="alert alert-warning py-2 px-3 mb-2" style="font-size: 14px;">
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
                        <div class="bg-light p-2 rounded text-muted mb-3" style="font-size: 13px;">
                            <b>{{ $selectedCinema->name }}</b>
                            @if ($formattedDate)
                                · {{ $formattedDate }}
                            @endif
                            <br>
                            {{ $selectedCinema->location }} – 
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($selectedCinema->location) }}" target="_blank">Bản đồ</a>
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

                        <div class="bg-white rounded shadow-sm p-3 mb-3">
                            <div class="d-flex">
                                <img src="{{ asset($movie->image) }}" width="120" height="150" class="rounded me-3">
                                <div>
                                    <h6 class="mb-1">{{ $movie->title }}</h6>

                                    <div class="text-muted mb-1" style="font-size: 13px;">
                                        {{ $movie->director ?? 'Đạo diễn ẩn danh' }} · {{ $movie->language }} ·
                                        {{ $movie->duration }} phút ·
                                        @if ($movie->trailer_url)
                                            <a href="{{ $movie->trailer_url }}" target="_blank">Trailer</a>
                                        @endif
                                        <br>
                                        <span class="fw-bold">{{ $movie->genre }}</span>
                                    </div>

                                    <div class="text-dark mb-2 fw-bold mt-2" style="font-size: 13px;">2D Phụ Đề
                                        {{ $movie->language }}
                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($movieShowtimes as $showtime)
                                            @php
                                                $seatPrices = $showtime->room->seats->pluck('price');
                                                $seatPrice = $seatPrices->min() ?? 0;
                                                $finalPrice = $showtime->price + $seatPrice;
                                            @endphp

                                            <button class="btn btn-sm" style="border-color: black;">
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
@endsection