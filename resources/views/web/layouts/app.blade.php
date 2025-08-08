<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rạp Phim Việt')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #ffffffff;
            font-family: 'Inter', sans-serif;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
            padding: 40px 0 20px;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .navbar .nav-link {
            font-size: 14px;
            padding: 0.5rem 0.75rem;
        }

        .navbar .dropdown-menu {
            font-size: 14px;
        }

        @media (max-width: 991px) {
            .navbar .input-group {
                width: 100%;
                margin-top: 1rem;
            }
        }

        .border-bottom {
            border-bottom: 2px solid #e3ebf6 !important;
        }

        .movie-banner {
            height: 200px;
            background-image: url('https://cdn.moveek.com/build/images/tix-banner.ed8b6071.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            z-index: 1;
            background-color: #000;
            /* fallback */
        }

        .movie-banner::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .movie-banner h2,
        .movie-banner p {
            z-index: 1;
            position: relative;
        }
        /* Tạo lớp col để chia 5 phim 1 hàng */
        @media (min-width: 1200px) {
            .col-xxl-1-5 {
                flex: 0 0 auto;
                width: 20%;
            }
        }

        .poster-wrapper {
            aspect-ratio: 290 / 427;
            overflow: hidden;
            position: relative;
            border-radius: 4px 4px 0 0;
            background-color: #f0f0f0;
        }

        .poster-wrapper img {
            width: 100%;
            height: 150px;
        }

        .movie-card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            overflow: hidden;
            background-color: #fff;
            transition: box-shadow 0.2s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .movie-card:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .badge-custom {
            position: absolute;
            top: 8px;
            /* dịch xuống từ top */
            left: 0px;
            /* cách lề trái */
            padding: 4px 8px;
            font-size: 12px;
            font-weight: 500;
            border-radius: 0;
            /* bỏ bo góc */
            z-index: 1;
        }

        .dropdown-menu {
            font-size: 14px;
            border-radius: 8px;
        }

        .dropdown-item {
            color: #6c757d;
        }

        .dropdown-item:hover,
        .dropdown-item.active {
            background-color: #f8f9fa;
            color: #000;
        }

        .title-movie {
            font-size: 13px; 
            white-space: nowrap; 
            overflow: hidden; 
            text-overflow: ellipsis;
        }
        .showtimes-title{
            padding-bottom: 10px;
            border-bottom: 1px solid #edf2f9;
        }
        .time-showtimes:active {
            border:unset;
        }
        .search-common:focus{
            outline: 0;
            box-shadow: unset;
            border-color: #dee2e6;
        }
        .bg-active{
            background: #edf2f9;
        }
    </style>
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
                        <a class="nav-link dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown">Rạp</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="#">Khuyến mãi</a>
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

                    <a href="#" class="text-secondary text-decoration-none d-flex align-items-center gap-1 small">
                        <i class="bi bi-geo-alt"></i> <span class="d-none d-lg-inline">Hỗ trợ</span>
                    </a>
                    <a href="#" class="text-secondary text-decoration-none d-flex align-items-center gap-1 small">
                        <i class="bi bi-person"></i> <span class="d-none d-lg-inline">Tài khoản</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="bg-light border-top py-4 mt-5">
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