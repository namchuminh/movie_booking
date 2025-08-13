<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // Chống brute force theo IP + account
        $key = 'login:'.mb_strtolower((string)$request->input('account')).'|'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'ok'     => false,
                'errors' => ['account' => ["Bạn thử sai quá nhiều lần. Vui lòng thử lại sau {$seconds} giây."]],
            ], 429);
        }

        // Validate đầu vào
        $v = Validator::make($request->all(), [
            'account'  => ['required','string','max:255'],
            'password' => ['required','string','min:6'],
            'remember' => ['nullable','boolean'],
        ], [
            'account.required'  => 'Vui lòng nhập tài khoản hoặc email.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min'      => 'Mật khẩu phải có ít nhất :min ký tự.',
        ]);

        if ($v->fails()) {
            return response()->json(['ok' => false, 'errors' => $v->errors()], 422);
        }

        $account  = trim($request->input('account'));
        $password = $request->input('password');
        $remember = (bool) $request->boolean('remember');

        // Thử đăng nhập bằng email hoặc username
        $isEmail = filter_var($account, FILTER_VALIDATE_EMAIL) !== false;

        $attempts = $isEmail
            ? [ ['email' => $account], ['username' => $account] ] // nhìn giống email nhưng vẫn thử username phòng trường hợp đặt username kiểu email
            : [ ['username' => $account], ['email' => $account] ];

        foreach ($attempts as $base) {
            $credentials = $base + ['password' => $password];
            if (Auth::attempt($credentials, $remember) && Auth::user()->role === 'customer') {
                $request->session()->regenerate();
                RateLimiter::clear($key);

                return response()->json([
                    'ok'       => true,
                    'message'  => 'Đăng nhập thành công.',
                    // Frontend có thể chuyển hướng đến trang trước đó hoặc dashboard
                    'redirect' => url()->previous(),
                ]);
            }else{
                // Hủy việc đăng nhập
                Auth::logout();

                return response()->json([
                    'ok'     => false,
                    'errors' => [
                        'account'  => ['Tài khoản hoặc mật khẩu không đúng.'],
                    ],
                ], 403);
            }
        }

        // Sai thông tin → tăng đếm rate limit và trả lỗi 422
        RateLimiter::hit($key, 60); // sau 60 giây sẽ giảm 1 lần

        return response()->json([
            'ok'     => false,
            'errors' => [
                // gắn lỗi vào "account" để hiển thị dưới ô tài khoản; nếu muốn tách, thêm cả 'password'
                'account'  => ['Tài khoản hoặc mật khẩu không đúng.'],
                // 'password' => ['Tài khoản hoặc mật khẩu không đúng.'],
            ],
        ], 422);
    }

    public function user(){
        if(!Auth::check()){
            return redirect()->route('home');
        }
        return view('web.user.profile', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        if(!Auth::check()){
            return redirect()->route('home');
        }

        $messages = [
            'password.min'        => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed'  => 'Xác nhận mật khẩu không khớp.',
            'avatar.image'        => 'Ảnh đại diện phải là định dạng JPG hoặc PNG.',
            'avatar.max'          => 'Ảnh đại diện không được vượt quá :max KB.',
        ];

        $data = $request->validate([
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'avatar'   => ['nullable', 'image', 'max:2048'], // 2MB
        ], $messages);

        $user = auth()->user();

        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = '/storage/' . $path;
        }

        $user->save();

        return back()->with('status', 'Cập nhật thành công.');
    }

    public function logout(Request $request)
    {
        if(!Auth::check()){
            return redirect()->route('home');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'Đăng xuất thành công.');
    }

    public function register()
    {
        return view('web.user.register');
    }

    public function registerSubmit(Request $request)
    {
        $messages = [
            'email.required'    => 'Vui lòng nhập email.',
            'email.email'       => 'Email không hợp lệ.',
            'email.unique'      => 'Email đã được sử dụng.',
            'username.required' => 'Vui lòng nhập tên đăng nhập.',
            'username.unique'   => 'Tên đăng nhập đã tồn tại.',
            'username.regex'    => 'Tên đăng nhập chỉ gồm chữ, số, dấu gạch dưới, tối thiểu 3 ký tự.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min'      => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed'=> 'Xác minh mật khẩu không khớp.',
            // 'g-recaptcha-response.required' => 'Vui lòng xác minh mã bảo vệ.',
            // 'g-recaptcha-response.captcha'  => 'Xác minh mã bảo vệ không hợp lệ.',
        ];

        $data = $request->validate([
            'email'                 => ['required','email','max:255','unique:users,email'],
            'username'              => ['required','max:50','unique:users,username','regex:/^[A-Za-z0-9_]{3,}$/'],
            'password'              => ['required','string','min:6','confirmed'],
            // Nếu dùng reCAPTCHA v2:
            // 'g-recaptcha-response'  => ['required','captcha'],
        ], $messages);

        $user = User::create([
            'email'    => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'role'     => 'customer',
            'avatar'   => 'storage/avatars/no-avatar.png', // Dùng mặc định là avatar.png
        ]);

        auth()->login($user);

        return redirect()->route('home')->with('status', 'Tạo tài khoản thành công!');
    }

}
