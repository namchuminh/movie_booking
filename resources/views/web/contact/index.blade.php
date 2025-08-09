@extends('web.layouts.app')
@section('title', 'Trung tâm hỗ trợ')

@section('content')
<div class="container support-page">

    <h1 class="mt-4 mb-4 text-center" style="font-size: 1.5rem;">
        Trung tâm hỗ trợ
    </h1>

    <div class="alert alert-light text-dark" style="background: #edf2f9;">
        Trung tâm hỗ trợ khách hàng của <strong>Moveek</strong> sẽ hỗ trợ
        các vấn đề liên quan đến <strong>mua vé trực tuyến và thanh toán</strong> tại website
        moveek.com.
        <br>Các vấn đề khác chúng tôi sẽ không tiếp nhận,
        vui lòng xem thông tin trên website hoặc liên hệ trực tiếp với rạp
        để được giải quyết.
    </div>

    <div class="row">
        {{-- ZALO --}}
        <div class="col-12 col-lg-6 col-xl mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-9 pr-0">
                            <h6 class="card-title text-uppercase text-muted mb-2">ZALO</h6>
                            <a href="https://zalo.me/moveek" target="_blank" class="h2 mb-2 text-dark d-block">
                                zalo.me/moveek
                            </a>
                            <span class="text-muted small">
                                <i class="fe fe-clock"></i> 09:00 - 23:00
                            </span>
                        </div>
                        <div class="col-3 p-0 text-right">
                            <img src="https://cdn.moveek.com/bundles/ornweb/support/moveek-zalo-qr.jpg" class="moveek-zalo-qr" alt="moveek-zalo-qr" style="max-width:100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Hotline --}}
        <div class="col-12 col-lg-6 col-xl mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title text-uppercase text-muted mb-2">Hotline</h6>
                    <a href="tel://02473088890" class="h2 mb-2 text-dark d-block">
                        024 7308 8890
                    </a>
                    <span class="text-muted small">
                        <i class="fe fe-clock"></i> 09:00 - 23:00 - Tất cả các ngày
                    </span>
                </div>
            </div>
        </div>
        {{-- Email --}}
        <div class="col-12 col-lg-6 col-xl mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title text-uppercase text-muted mb-2">Email</h6>
                    <a href="mailto://hotro@moveek.vn" class="h2 mb-2 text-dark d-block">
                        hotro@moveek.vn
                    </a>
                    <span class="text-muted small">
                        Phản hồi nhanh nhất có thể
                    </span>
                </div>
            </div>
        </div>
        {{-- Hướng dẫn sử dụng --}}
        <div class="col-12 col-lg-6 col-xl mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title text-uppercase text-muted mb-2">Hướng dẫn sử dụng</h6>
                    <a href="https://kb.moveek.com/" class="h2 mb-2 text-dark d-block">
                        kb.moveek.com
                    </a>
                    <span class="text-muted small">
                        <a style="font-size: 14px;" href="https://kb.moveek.com/kb-category/huong-dan-mua-ve/">Cách mua vé</a>,
                        <a style="font-size: 14px;" href="https://kb.moveek.com/kb-category/huong-dan-thanh-toan/">thanh toán</a>...
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- FAQ + Hướng dẫn --}}
    <div class="row">
        <div class="col-sm-9">
            <h2 class="mb-4 text-center" style="font-size: 1.3rem;">Câu hỏi thường gặp</h2>

            <div class="card mb-3">
                <div class="card-body">
                    <p class="fw-bold">Rạp Moveek nằm ở đâu?</p>
                    <p>Moveek không phải là rạp phim. Moveek là website thông tin điện ảnh
                        cung cấp các thông tin như: Lịch chiếu - Đặt vé phim, Tin tức điện ảnh,
                        Review / Đánh giá phim, dữ liệu phim ảnh...</p>
                    <p>Kể từ tháng 11/2018, Moveek triển khai bán vé trực tuyến cho các cụm rạp trong cả nước.</p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <p class="fw-bold">Tôi có thể mua vé các cụm rạp nào tại Moveek?</p>
                    <p>Hiện tại bạn đã có thể mua vé các hệ thống rạp:</p>
                    <ul class="list-contact">
                        <li><a href="https://moveek.com/he-thong-rap/beta-cineplex/">Beta Cinemas</a></li>
                        <li><a href="https://moveek.com/he-thong-rap/mega-gs-cinemas/">Mega GS Cinemas</a></li>
                        <li><a href="https://moveek.com/he-thong-rap/cinestar/">CineStar</a></li>
                        <li><a href="https://moveek.com/he-thong-rap/dcine/">Dcine</a></li>
                        <li><a href="https://moveek.com/he-thong-rap/cinemax/">Cinemax</a></li>
                        <li><a href="https://moveek.com/he-thong-rap/starlight/">Starlight</a></li>
                        <li><a href="https://moveek.com/he-thong-rap/rio-cinemas/">Rio Cinemas</a></li>
                        <li><a href="https://moveek.com/he-thong-rap/touch-cinema/">Touch Cinema</a></li>
                    </ul>
                    <p>Các hệ thống khác, Moveek sẽ kết nối trong thời gian sắp tới.</p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <p class="fw-bold">Tôi đặt vé trước có được không?</p>
                    <p>Moveek không hỗ trợ đặt vé, bạn cần thanh toán để nhận vé.</p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <p class="fw-bold">Thanh toán xong thì sao nữa?</p>
                    <p>Sau khi thanh toán thành công bạn sẽ nhận được mã vé qua email và tin nhắn đã chọn.
                        Bạn mang mã vé đến quầy để đổi vé giấy. Nếu không nhận được
                        email / tin nhắn, hãy liên hệ với Moveek để được hỗ trợ ngay nhé.</p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <p class="fw-bold">Tôi mua nhầm vé, có đổi / trả được không?</p>
                    <p>Vé đã mua không thể đổi hoặc hoàn tiền.</p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <p class="fw-bold">Tôi đã bị trừ tiền nhưng không nhận được mã vé?</p>
                    <p>Nếu bạn mua vé ở các cụm rạp Moveek hỗ trợ mua trực tuyến, hãy liên hệ
                        ngay thông qua số hotline, chúng tôi sẽ xử lý trong tối đa 15 phút.</p>
                    <p>Đối với các cụm rạp khác, hãy sang website của rạp hoặc gọi số hotline của rạp để được hỗ trợ.</p>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <h2 class="mb-4 text-center" style="font-size: 1.3rem;">Hướng dẫn</h2>
            <div class="card">
                <div class="card-body body-contact">
                    <a href="https://kb.moveek.com/kb/huong-dan-cac-buoc-mua-ve/">Hướng dẫn các bước mua vé</a>
                    <hr>
                    <a href="https://kb.moveek.com/kb/thanh-toan-bang-the-tai-khoan-ngan-hang-noi-dia/">Thanh toán bằng Thẻ / tài khoản ngân hàng nội địa</a>
                    <hr>
                    <a href="https://kb.moveek.com/kb/thanh-toan-bang-the-tin-dung-ghi-no-quoc-te/">Thanh toán bằng Thẻ tín dụng / ghi nợ quốc tế</a>
                    <hr>
                    <a href="https://kb.moveek.com/kb/thanh-toan-tai-cua-hang-gan-nha/">Thanh toán tại Cửa hàng gần nhà</a>
                    <hr>
                    <a href="https://kb.moveek.com/kb/thanh-toan-bang-vi-dien-tu-momo/">Thanh toán bằng Ví điện tử MoMo</a>
                    <hr>
                    <a href="https://kb.moveek.com/" class="btn btn-outline-primary w-100">Xem thêm</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
