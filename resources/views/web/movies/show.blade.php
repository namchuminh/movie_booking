@extends('web.layouts.app')
@section('title', 'Phim đang chiếu rạp')

@section('content')
    @php
        // Chuẩn hoá dữ liệu hiển thị
        $genres = array_filter(array_map('trim', explode(',', (string) ($movie->genre ?? ''))));
        $actors = array_filter(array_map('trim', explode(',', (string) ($movie->actors ?? ''))));
        $directors = array_filter(array_map('trim', explode(',', (string) ($movie->director ?? ''))));
        $producers = array_filter(array_map('trim', explode(',', (string) ($movie->producer ?? '')))); // nếu bạn có cột producer
        $poster = $movie->image;
        $bg = $movie->image; // nếu có backdrop riêng thì thay ở đây
    @endphp
    <div class="movie-hero position-relative text-white">
        <div class="hero-bg" style="background-image:url('{{ $bg }}');"></div>
        <div class="hero-overlay"></div>

        <div class="container py-4 py-lg-5 position-relative">
            <div class="row g-4">
                {{-- Poster --}}
                <div class="col-12 col-md-4 col-lg-3 d-flex justify-content-center justify-content-md-start">
                    <div class="poster shadow-lg rounded overflow-hidden">
                        <img src="{{ asset($poster) }}" alt="{{ $movie->title }}" class="w-100 h-100">
                    </div>
                </div>

                {{-- Info --}}
                <div class="col-12 col-md-8 col-lg-6">
                    <h2 class="fw-bold mb-1">{{ $movie->title }}</h2>
                    <div class="text-white-50 mb-3">
                        {{ $movie->title_en ?? '' }}
                        @if($genres)
                            – {{ implode(', ', $genres) }}
                        @endif
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <button class="btn btn-sm btn-outline-light"><i class="bi bi-hand-thumbs-up"></i> Thích</button>
                        <button class="btn btn-sm btn-outline-light"><i class="bi bi-chat-dots"></i> Đánh giá</button>
                        @if(!empty($movie->trailer_url))
                            <a href="{{ $movie->trailer_url }}" target="_blank" class="btn btn-sm btn-light text-dark">
                                <i class="bi bi-play-btn-fill"></i> Trailer
                            </a>
                        @endif
                        <a href="#" class="btn btn-sm btn-danger">
                            Mua vé
                        </a>
                    </div>

                    {{-- Description --}}
                    @if(!empty($movie->description))
                        <div class="mb-3 lh-base text-white-75">
                            {!! nl2br(e($movie->description)) !!}
                        </div>
                    @endif

                    {{-- Meta --}}
                    <div class="d-flex flex-wrap gap-4 small text-white-75">
                        @if(!empty($movie->release_date))
                            <div><i class="bi bi-calendar-event"></i> Khởi chiếu
                                <strong>{{ \Carbon\Carbon::parse($movie->release_date)->format('d/m/Y') }}</strong>
                            </div>
                        @endif
                        @if(!empty($movie->duration))
                            <div><i class="bi bi-clock-history"></i> Thời lượng <strong>{{ $movie->duration }}</strong> phút
                            </div>
                        @endif
                        @if(!empty($movie->rating))
                            <div><i class="bi bi-person-exclamation"></i> Giới hạn tuổi <strong>{{ $movie->rating }}</strong>
                            </div>
                        @endif
                        @if(!empty($movie->language))
                            <div><i class="bi bi-translate"></i> Ngôn ngữ <strong>{{ $movie->language }}</strong></div>
                        @endif
                    </div>
                </div>

                {{-- Right column: credits --}}
                <div class="col-12 col-lg-3">
                    @if($actors)
                        <div class="mb-3">
                            <div class="fw-semibold">Diễn viên</div>
                            <div class="small">
                                @foreach($actors as $a)
                                    <a href="#" class="link-light text-decoration-none">{{ $a }}</a>@if(!$loop->last), @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($directors)
                        <div class="mb-3">
                            <div class="fw-semibold">Đạo diễn</div>
                            <div class="small">
                                @foreach($directors as $d)
                                    <span class="text-danger">{{ $d }}</span>@if(!$loop->last), @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($producers)
                        <div class="mb-2">
                            <div class="fw-semibold">Nhà sản xuất</div>
                            <div class="small">
                                @foreach($producers as $p)
                                    <span class="text-danger">{{ $p }}</span>@if(!$loop->last), @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="container my-4">
        <style>
            /* ====== UI Polish ====== */
            .cinema-card {
                border: 1px solid #e6eaf1;
                border-radius: 12px;
                overflow: hidden;
                background: #fff
            }

            .cinema-head {
                display: flex;
                align-items: flex-start;
                gap: 10px;
                padding: 14px 16px;
                background: linear-gradient(180deg, #f6f9ff, #eef4ff)
            }

            .cinema-name {
                font-weight: 600;
                color: #0f1c2e
            }

            .cinema-addr {
                font-size: 13px;
                color: #6b7280
            }

            .cinema-actions a {
                font-size: 12px
            }

            .format-badge {
                font-weight: 600;
                margin-bottom: 8px;
                color: #0f1c2e
            }

            .slot-wrap {
                display: flex;
                flex-wrap: wrap;
                gap: 10px
            }

            .slot {
                border: 1px solid #c9d4e5;
                border-radius: 8px;
                padding: 6px 10px;
                min-width: 72px;
                text-align: center;
                background: #fff;
                transition: .15s
            }

            .slot:hover {
                transform: translateY(-1px);
                box-shadow: 0 2px 10px rgba(16, 24, 40, .06)
            }

            .slot-time {
                font-weight: 700;
                line-height: 1
            }

            .slot-price {
                font-size: 12px;
                color: #6b7280;
                margin-top: 2px
            }

            .slot.disabled {
                background: #f3f4f6;
                border-color: #e5e7eb;
                color: #a3aab4;
                pointer-events: none
            }

            .room-head {
                font-weight: 600;
                margin: 10px 0 8px 0;
                color: #111827
            }

            .cinema-toggle {
                cursor: pointer;
                user-select: none
            }

            .cinema-body {
                padding: 12px 16px;
                border-top: 1px solid #eef1f6
            }

            .cinema-item+.cinema-item {
                margin-top: 10px
            }
        </style>

        @php
            // Group theo RẠP (cinema)
            $byCinema = $showtimes->groupBy(fn($st) => $st->room->cinema->id);
            $today = now()->toDateString();
            $nowTime = now()->format('H:i:s');
        @endphp

        <div class="container my-4">
            @forelse($byCinema as $cinemaId => $items)
                @php
                    $cinema = $items->first()->room->cinema;
                    // Group thêm theo PHÒNG (room) nếu rạp có nhiều phòng
                    $byRoom = $items->groupBy('room_id');
                @endphp

                <div class="cinema-card mb-3" x-data="{open: {{ $loop->first ? 'true' : 'false' }}}">
                    {{-- Header rạp --}}
                    <div class="cinema-head cinema-toggle" @click="open = !open">
                        <div class="flex-fill">
                            <div class="cinema-name">{{ $cinema->name }}</div>
                            <div class="cinema-addr">
                                {{ $cinema->location }}
                                <span class="cinema-actions ms-2">
                                    <a href="{{ route('cinemas.show', $cinema->id) }}" class="text-muted text-decoration-none">Thông tin rạp</a> –
                                    <a href="{{ route('cinemas.show', $cinema->id) }}" class="text-muted text-decoration-none">Bản đồ</a>
                                </span>
                            </div>
                        </div>
                        <div>
                            <svg :style="{transform: open ? 'rotate(180deg)' : 'rotate(0deg)'}" width="18" height="18"
                                viewBox="0 0 24 24">
                                <path d="M6 9l6 6 6-6" stroke="#334155" stroke-width="2" fill="none" stroke-linecap="round" />
                            </svg>
                        </div>
                    </div>

                    {{-- Body: danh sách phòng + các suất --}}
                    <div class="cinema-body" x-show="open" x-collapse>
                        @foreach($byRoom as $roomId => $stItems)
                            @php $room = $stItems->first()->room; @endphp
                            <div class="cinema-item">
                                <div class="slot-wrap">
                                    @foreach($stItems->sortBy(['show_time', 'show_date']) as $st)
                                        @php
                                            // disable nếu suất đã qua (cùng ngày và giờ nhỏ hơn hiện tại)
                                            $isPast = ($st->show_date === $today) && (\Illuminate\Support\Carbon::parse($st->show_time)->format('H:i:s') < $nowTime);
                                            $time = \Illuminate\Support\Carbon::parse($st->show_time)->format('H:i');
                                            $price = $st->price >= 1000
                                            ? number_format($st->price / ($st->price >= 1000000 ? 1000000 : 1000), 0) . ($st->price >= 1000000 ? 'M' : 'K')
                                            : $st->price;
                                        @endphp
                                        <a href="{{ $isPast ? 'javascript:void(0)' : route('tickets.show', $st->id) }}"
                                            class="slot {{ $isPast ? 'disabled' : '' }}">
                                            <div class="slot-time text-dark">{{ $time }}</div>
                                            <div class="slot-price">{{ $price }}</div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            @if(!$loop->last)
                                <hr class="my-3" style="border-color:#eef1f6">
                            @endif
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-5">Không có suất chiếu cho phim này.</div>
            @endforelse
        </div>

        {{-- AlpineJS (chỉ ~8KB) cho toggle mượt, nếu chưa có thì thêm CDN dưới) --}}
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </div>
    <script>
        window.history.replaceState({}, document.title, "{{ url()->current() }}");
    </script>
    <style>
        .movie-hero {
            min-height: 360px;
        }

        .movie-hero .hero-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            filter: blur(6px);
        }

        .movie-hero .hero-overlay {
            position: absolute;
            inset: 0;
            background: url(https://cdn.moveek.com/build/images/tix-banner.ed8b6071.png) no-repeat center center / cover;
        }

        .poster {
            width: 210px;
            height: 310px;
            background: #1f2937;
            border-radius: 12px;
        }

        @media (max-width: 576px) {
            .poster {
                width: 160px;
                height: 240px;
                margin-bottom: .5rem;
            }
        }
    </style>
@endsection