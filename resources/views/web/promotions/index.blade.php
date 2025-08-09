@extends('web.layouts.app')
@section('title', 'Khuyến mãi tháng ' . now()->format('m/Y'))

@section('content')

    <div
        class="container-fluid mb-3 movie-banner d-flex flex-column justify-content-center align-items-center text-white text-center">
        <h5 class="fw-bold mb-3 text-white">Khuyến mãi {{ now()->format('m/Y') }}</h5>
        <p class="mb-0">
            Khuyến mãi dành cho khách hàng trong tháng 08/2025
        </p>
    </div>

    <div class="container my-4">
        <div class="row">
            @forelse ($promotions as $promo)
                <div class="col-6 col-md-4 col-lg-3 col-xxl-1-5 mb-4">
                    <div class="promo-card border rounded shadow-sm h-100 d-flex flex-column">
                        <!-- Ảnh -->
                        <div class="promo-thumb position-relative">
                            <img src="{{ $promo->image }}"
                                alt="{{ $promo->title }}" class="w-100 h-100" onerror="this.style.display='none'">
                            @php
                                $today = now();
                                $isActive = $today->between(\Carbon\Carbon::parse($promo->start_date), \Carbon\Carbon::parse($promo->end_date));
                                $isUpcoming = $today->lt(\Carbon\Carbon::parse($promo->start_date));
                            @endphp
                            @if ($isActive)
                                <span class="badge status-badge bg-danger text-white">Đang diễn ra</span>
                            @elseif ($isUpcoming)
                                <span class="badge status-badge bg-danger text-dark">Sắp diễn ra</span>
                            @else
                                <span class="badge status-badge bg-danger text-white">Đã kết thúc</span>
                            @endif
                        </div>

                        <!-- Nội dung -->
                        <div class="p-3 d-flex flex-column gap-2">
                            <div class="fw-semibold text-truncate" title="{{ $promo->title }}">
                                {{ $promo->title }}
                            </div>

                            <div class="text-muted small">
                                {{ \Carbon\Carbon::parse($promo->start_date)->format('d/m/Y') }}
                                – {{ \Carbon\Carbon::parse($promo->end_date)->format('d/m/Y') }}
                            </div>

                            @if(!empty($promo->value))
                                <div class="small fw-semibold text-danger">
                                    Ưu đãi: {{ $promo->value }}
                                </div>
                            @endif

                            @if(!empty($promo->description))
                                <div class="small text-muted line-2">
                                    {{ $promo->description }}
                                </div>
                            @endif

                            <div class="mt-auto">
                                <button
                                    class="btn btn-sm btn-danger w-100 btn-show-movies"
                                    data-target="#movies-list-{{ $promo->id }}">
                                    Xem phim áp dụng
                                    @php $moviesCount = $promo->movies_count ?? ($promo->movies->count() ?? 0); @endphp
                                    <span class="badge bg-light text-dark ms-2">{{ $moviesCount }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="movies-list-{{ $promo->id }}" class="d-none">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle table-striped table-hover promo-movies-table">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:150px">Poster</th>
                                    <th>Tên Phim</th>
                                    <th>Thể loại</th>
                                    <th>Khởi chiếu</th>
                                    <th>Thời lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse(($promo->movies ?? []) as $movie)
                                <tr>
                                    <td>
                                        <div class="poster-thumb">
                                            <a href="#">
                                            <img
                                                src="{{ $movie->image ?? $movie->poster ?? '' }}"
                                                alt="{{ $movie->title }}"
                                                onerror="this.style.display='none'">
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-truncate" title="{{ $movie->title }}">
                                        <a href="#" class="text-decoration-none text-dark"><span class="fw-bold">{{ $movie->title }}</span></a>
                                    </td>
                                    <td class="text-truncate" title="{{ $movie->genre ?? 'Không rõ' }}">
                                        {{ $movie->genre ?? '' }}
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $movie->release_date ?? 'Không rõ' }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $movie->duration . ' phút' ?? 'Không rõ' }}</span>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Chưa có phim nào áp dụng khuyến mãi này.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="py-5 text-center text-muted">Chưa có khuyến mãi trong tháng này.</div>
            @endforelse
        </div>
    </div>

    <!-- Modal dùng chung -->
    <div class="modal fade" id="moviesModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Phim áp dụng</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
          </div>
          <div class="modal-body" id="moviesModalBody">
          </div>
        </div>
      </div>
    </div>

    <style>
        /* 5 card / hàng ở màn rất lớn */
        @media (min-width: 1400px) {
            .col-xxl-1-5 { flex: 0 0 auto; width: 20%; }
        }
        .promo-card { background: #fff; }

        /* Khung ảnh 16:9, cover đẹp */
        .promo-thumb {
            aspect-ratio: 16 / 9;
            overflow: hidden;
            background: #f3f4f6;
            border-bottom: 1px solid #eee;
            position: relative;
        }
        .promo-thumb img { object-fit: cover; }

        .status-badge {
            position: absolute; top: 8px; left: 8px;
            border-radius: 4px; padding: 4px 8px; font-size: 12px;
        }

        /* Mô tả 2 dòng, cắt ... */
        .line-2 {
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }

        /* ratio 2x3 cho poster phim (gần 290x427) */
        .ratio.ratio-2x3 { --bs-aspect-ratio: calc(3 / 2 * 100%); }
        /* Bảng phim áp dụng */
        .promo-movies-table { font-size: 12px; }
        .promo-movies-table th, .promo-movies-table td { white-space: nowrap; }
        .promo-movies-table .text-truncate {
            max-width: 0; /* để truncate theo width cột thực tế */
            overflow: hidden; text-overflow: ellipsis;
        }
        .poster-thumb {
            width: 80px; height: 120px; overflow: hidden; border-radius: 4px; background: #f3f4f6;
        }
        .poster-thumb img {
            width: 100%; height: 100%; object-fit: cover; display: block;
        }

    </style>

    <script>
    (function() {
        const modalEl   = document.getElementById('moviesModal');
        const modalBody = document.getElementById('moviesModalBody');
        let bsModal;

        function ensureModal() {
            if (!bsModal) bsModal = new bootstrap.Modal(modalEl);
            return bsModal;
        }

        document.querySelectorAll('.btn-show-movies').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const targetSelector = this.getAttribute('data-target');
                const source = document.querySelector(targetSelector);
                modalBody.innerHTML = source ? source.innerHTML : '<p class="text-danger m-0">Không có dữ liệu.</p>';
                ensureModal().show();
            });
        });
    })();
    </script>

@endsection
