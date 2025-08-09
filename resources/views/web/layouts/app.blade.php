<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rạp Phim Việt')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="https://cdn.moveek.com/favicon.png">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-white py-2">
        <div class="container">
            <a class="navbar-brand d-lg-none" href="#">
                <img src="https://cdn.moveek.com/bundles/ornweb/img/logo.png" alt="Logo" height="30">
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="mainNavbar">
                <!-- Left Menu -->
                <ul class="navbar-nav align-items-lg-center gap-lg-3 mb-3 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-danger fw-semibold" href="{{ route('home') }}">Đặt vé phim chiếu rạp</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="{{ route('showtimes.index') }}">Lịch chiếu</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown">Phim</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('movies.now_showing') }}">Phim đang chiếu</a></li>
                            <li><a class="dropdown-item" href="{{ route('movies.coming_soon') }}">Phim sắp chiếu</a></li>
                            <li><a class="dropdown-item" href="{{ route('movies.this_month') }}">Phim tháng {{ date('m') }}/{{ date('Y') }}</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown" role="button" id="openCinemasModal">Rạp</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="{{ route('promotions.index') }}">Khuyến mãi</a>
                    </li>
                </ul>

                <!-- Center Logo (desktop only) -->
                <a class="navbar-brand d-none d-lg-block mx-auto mb-lg-1" href="{{ route('home') }}">
                    <img src="https://cdn.moveek.com/bundles/ornweb/img/logo.png" alt="Logo" height="30">
                </a>

                <!-- Right tools -->
                <div class="d-flex align-items-center gap-3 ms-auto">
                    <form class="d-none d-lg-block" style="width: 220px;">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                            <input class="form-control border-start-0 search-common" type="search" placeholder="Tìm phim, rạp...">
                        </div>
                    </form>

                    <a href="{{ route('contact') }}" class="text-secondary text-decoration-none d-flex align-items-center gap-1 small">
                        <i class="bi-question-circle"></i> <span class="d-none d-lg-inline">Hỗ trợ</span>
                    </a>
                    <a href="#" class="text-secondary text-decoration-none d-flex align-items-center gap-1 small">
                        <i class="bi bi-person"></i> <span class="d-none d-lg-inline">Tài khoản</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')
    <div class="modal fade" id="cinemaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    {{-- Thanh tìm kiếm + chọn tỉnh --}}
                    <div class="d-flex gap-2 mb-3">
                    <div class="flex-grow-1 position-relative">
                        <input id="cinemaSearchInput" type="text" class="form-control" placeholder="Tìm rạp tại">
                    </div>
                    <select id="cinemaProvinceSelect" class="form-select" style="max-width: 260px;">
                        <option value="">Tất cả tỉnh/thành</option>
                        @foreach(($provinces ?? []) as $province)
                            <option value="{{ $province }}">{{ $province }}</option>
                        @endforeach
                    </select>
                    </div>

                    {{-- Danh sách rạp --}}
                    <ul id="cinemaList" class="list-group list-group-flush">
                    @forelse(($cinemas ?? []) as $c)
                        <li class="list-group-item py-3 cinema-item d-flex align-items-center gap-3"
                            data-province="{{ $c->province }}"
                            data-name="{{ Str::lower($c->name) }}"
                            data-location="{{ Str::lower($c->location) }}">
                        {{-- logo / avatar rạp --}}
                        <div class="cinema-logo rounded-circle overflow-hidden d-flex align-items-center justify-content-center">
                            @if(!empty($c->image))
                            <img src="{{ asset($c->image) }}" alt="{{ $c->name }}" class="w-100 h-100">
                            @else
                            <span class="fw-bold">{{ Str::substr($c->name,0,2) }}</span>
                            @endif
                        </div>

                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('cinemas.show', $c->id) ?? '#' }}" class="link-dark text-decoration-none fw-semibold">
                                {{ $c->name }}
                            </a>
                            <span class="badge bg-primary-subtle text-primary border border-primary">{{ $c->type }}</span>
                            </div>
                            <div class="small text-muted">
                            {{ $c->location }}{{ $c->location ? ', ' : '' }}{{ $c->province }}
                            </div>
                        </div>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">Chưa có rạp.</li>
                    @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function(){
            const openBtn   = document.getElementById('openCinemasModal');
            const modalEl   = document.getElementById('cinemaModal');
            const searchInp = document.getElementById('cinemaSearchInput');
            const province  = document.getElementById('cinemaProvinceSelect');
            const listItems = () => Array.from(document.querySelectorAll('#cinemaList .cinema-item'));
            let modal;

            function ensureModal(){ if(!modal) modal = new bootstrap.Modal(modalEl); return modal; }

            function normalize(v){ return (v||'').toString().trim().toLowerCase(); }

            function applyFilter(){
                const q = normalize(searchInp.value);
                const p = province.value;
                listItems().forEach(li=>{
                const okProvince = !p || li.dataset.province === p;
                const hay = (li.dataset.name + ' ' + li.dataset.location);
                const okQuery   = !q || hay.includes(q);
                li.classList.toggle('d-none', !(okProvince && okQuery));
                });
            }

            openBtn?.addEventListener('click', (e)=>{ e.preventDefault(); ensureModal().show(); setTimeout(()=>searchInp.focus(),200); });
            searchInp?.addEventListener('input', applyFilter);
            province?.addEventListener('change', applyFilter);
        })();
    </script>
    <footer class="border-top py-4 mt-5">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="d-flex align-items-start mb-3 mb-md-0 col-md-6">
                <img src="https://cdn.moveek.com/bundles/ornweb/img/favicon-large.png" alt="Logo" width="50"
                    class="me-3">
                <div class="small text-muted" style="max-width: 500px;">
                    <div class="fw-bold text-dark">CÔNG TY TNHH MONET</div>
                    Số ĐKKD: 0315367026 · Nơi cấp: Sở kế hoạch và đầu tư Tp. Hồ Chí Minh · Đăng ký lần đầu ngày
                    01/11/2018<br>
                    Địa chỉ: 33 Nguyễn Trung Trực, P.5, Q. Bình Thạnh, Tp. Hồ Chí Minh<br>
                    <a href="#" class="text-decoration-none me-2">Về chúng tôi</a>
                    · <a href="#" class="text-decoration-none me-2">Chính sách bảo mật</a>
                    · <a href="#" class="text-decoration-none me-2">Hỗ trợ</a>
                    · <a href="#" class="text-decoration-none me-2">Liên hệ</a>
                    · v8.1
                </div>
            </div>
            <div class="d-flex flex-column mb-3 mb-md-0 col-md-4">
                <div class="fw-bold mb-2">ĐỐI TÁC</div>
                <div class="d-flex flex-wrap gap-2">
                    <img src="https://cdn.moveek.com/bundles/ornweb/partners/beta-cineplex-v2.jpg"
                        class="rounded-circle" height="40">
                    <img src="https://cdn.moveek.com/bundles/ornweb/partners/mega-gs-cinemas.png" class="rounded-circle"
                        height="40">
                    <img src="https://cdn.moveek.com/bundles/ornweb/partners/cinestar.png" class="rounded-circle"
                        height="40">
                    <img src="https://cdn.moveek.com/bundles/ornweb/partners/dcine.png" class="rounded-circle"
                        height="40">
                    <img src="https://cdn.moveek.com/bundles/ornweb/partners/cinemax.png" class="rounded-circle"
                        height="40">
                    <img src="https://cdn.moveek.com/bundles/ornweb/partners/starlight.png" class="rounded-circle"
                        height="40">
                    <img src="https://cdn.moveek.com/bundles/ornweb/partners/rio.png" class="rounded-circle"
                        height="40">
                    <img src="https://cdn.moveek.com/bundles/ornweb/partners/dong-da-cinemas.png" class="rounded-circle"
                        height="40">
                    <img src="https://cdn.moveek.com/bundles/ornweb/partners/touch-cinemas.png" class="rounded-circle"
                        height="40">
                    <img src="https://cdn.moveek.com/bundles/ornweb/partners/payoo.jpg" class="rounded-circle"
                        height="40">
                    <img src="https://cdn.moveek.com/bundles/ornweb/partners/momo.png" class="rounded-circle"
                        height="40">
                    <img src="https://cdn.moveek.com/bundles/ornweb/partners/zalopay-icon.png" class="rounded-circle"
                        height="40">
                </div>
            </div>
            <div>
                <div class="d-flex flex-wrap gap-2">
                    <img src="https://cdn.moveek.com/bundles/ornweb/img/20150827110756-dathongbao.png" height="40">
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>