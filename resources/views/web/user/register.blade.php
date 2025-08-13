@extends('web.layouts.app')
@section('title', 'Đăng Ký')

@section('content')
    <div
        class="container-fluid mb-3 movie-banner d-flex flex-column justify-content-center align-items-center text-white text-center">
        <h5 class="fw-bold mb-3 text-white">Đăng Ký</h5>
        <p class="mb-0">Tạo tài khoản mới để đặt vé xem phim nhanh chóng và dễ dàng hơn!</p>
    </div>

    <div class="container py-5">
        <div class="row align-items-center">
            {{-- FORM --}}
            <div class="col-lg-7">
                <form method="POST" action="{{ route('registerSubmit') }}" class="register-form">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Email:</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tên đăng nhập:</label>
                            <input type="text" name="username" value="{{ old('username') }}"
                                class="form-control @error('username') is-invalid @enderror" required>
                            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Mật khẩu:</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Xác minh:</label>
                            <input type="password" name="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror" required>
                            @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Mã bảo vệ / Captcha --}}
                        <div class="col-12">
                            <label class="form-label">Mã bảo vệ</label>

                            <div class="d-flex align-items-center gap-2 mb-2">
                                <canvas id="captchaCanvas" width="180" height="52" class="border rounded bg-light"></canvas>
                                <button type="button" id="captchaRefresh" class="btn btn-outline-secondary btn-sm">
                                    Mã khác
                                </button>
                            </div>

                            <input type="text" name="captcha_input" id="captchaInput" class="form-control"
                                placeholder="Nhập mã ở hình bên trên" autocomplete="off">
                            <div class="invalid-feedback" id="captchaError"></div>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-dark w-100 py-2">Tạo tài khoản</button>
                            <div class="text-center mt-3">
                                <small class="text-muted">Đã có tài khoản? <a href="#">Đăng
                                        nhập!</a></small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- ILLUSTRATION --}}
            <div class="col-lg-5 mt-4 mt-lg-0 text-center">
                <img src="https://cdn.moveek.com/bundles/ornweb/img/mascot.png" alt="register-illustration"
                    class="img-fluid" style="max-height: 360px;">
            </div>
        </div>
    </div>

    <style>
        .register-form .form-label {
            font-weight: 600
        }

        .register-form input:focus {
            border-color: #dee2e6;
            box-shadow: unset;
        }

        #captchaCanvas {
            user-select: none;
        }
    </style>

    {{-- Nếu dùng reCAPTCHA thì mở dòng dưới --}}
    {{--
    <script src="https://www.google.com/recaptcha/api.js" async defer></script> --}}
    <script>
        (function () {
            const canvas = document.getElementById('captchaCanvas');
            const refresh = document.getElementById('captchaRefresh');
            const input = document.getElementById('captchaInput');
            const errEl = document.getElementById('captchaError');
            const form = document.querySelector('form.register-form') || document.querySelector('form'); // form đăng ký

            let expected = '';

            function rand(min, max) { return Math.floor(Math.random() * (max - min + 1)) + min; }
            function pick(arr) { return arr[rand(0, arr.length - 1)]; }
            function noise(ctx, w, h) {
                // vài đường
                ctx.lineWidth = 1;
                for (let i = 0; i < 3; i++) {
                    ctx.strokeStyle = `rgba(${rand(0, 150)},${rand(0, 150)},${rand(0, 150)},0.7)`;
                    ctx.beginPath();
                    ctx.moveTo(rand(0, w), rand(0, h));
                    ctx.bezierCurveTo(rand(0, w), rand(0, h), rand(0, w), rand(0, h), rand(0, w), rand(0, h));
                    ctx.stroke();
                }
                // vài chấm
                for (let i = 0; i < 40; i++) {
                    ctx.fillStyle = `rgba(${rand(0, 160)},${rand(0, 160)},${rand(0, 160)},0.6)`;
                    ctx.fillRect(rand(0, w), rand(0, h), 1, 1);
                }
            }

            function generateCode(len = 5) {
                const chars = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789'; // bỏ O,0,I,1 để đỡ nhầm
                let out = '';
                for (let i = 0; i < len; i++) out += pick(chars);
                return out;
            }

            function drawCaptcha() {
                const ctx = canvas.getContext('2d');
                const w = canvas.width, h = canvas.height;
                ctx.clearRect(0, 0, w, h);

                // nền nhạt
                ctx.fillStyle = '#eef2ff';
                ctx.fillRect(0, 0, w, h);
                noise(ctx, w, h);

                expected = generateCode(5);
                const baseX = 18, gap = 28, baseY = Math.floor(h / 2) + 6;

                for (let i = 0; i < expected.length; i++) {
                    const ch = expected[i];
                    ctx.save();
                    ctx.translate(baseX + i * gap, baseY);
                    ctx.rotate((rand(-15, 15) * Math.PI) / 180);
                    ctx.font = `${rand(22, 28)}px ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto`;
                    ctx.fillStyle = `rgb(${rand(30, 90)},${rand(30, 90)},${rand(30, 90)})`;
                    ctx.shadowColor = 'rgba(0,0,0,0.15)';
                    ctx.shadowBlur = 2;
                    ctx.fillText(ch, -8, 8);
                    ctx.restore();
                }
                noise(ctx, w, h);
                // reset input & lỗi
                input.value = '';
                input.classList.remove('is-invalid');
                errEl.textContent = '';
            }

            function validateCaptcha() {
                const got = (input.value || '').trim().toUpperCase();
                if (!got) {
                    input.classList.add('is-invalid');
                    errEl.textContent = 'Vui lòng nhập mã bảo vệ.';
                    return false;
                }
                if (got !== expected) {
                    input.classList.add('is-invalid');
                    errEl.textContent = 'Mã bảo vệ không đúng. Vui lòng thử lại.';
                    drawCaptcha();
                    return false;
                }
                input.classList.remove('is-invalid');
                errEl.textContent = '';
                return true;
            }

            refresh.addEventListener('click', drawCaptcha);
            canvas.addEventListener('click', drawCaptcha);

            // Chặn submit nếu captcha sai
            form?.addEventListener('submit', function (e) {
                if (!validateCaptcha()) {
                    e.preventDefault();
                    input.focus();
                }
            });

            // khởi tạo
            drawCaptcha();
        })();
    </script>
@endsection