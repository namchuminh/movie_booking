<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     if (Auth::user()->role !== 'admin') {
        //         abort(403, 'Bạn không có quyền truy cập chức năng này.');
        //     }
        //     return $next($request);
        // });
    }

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('username')) {
            $query->where('username', 'LIKE', '%' . $request->username . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'LIKE', '%' . $request->email . '%');
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('role', 'desc')->paginate(10)->appends($request->all());

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:customer,staff,admin',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'username.required' => 'Tên đăng nhập là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'role.required' => 'Vai trò là bắt buộc.',
            'avatar.image' => 'Ảnh đại diện phải là một tệp hình ảnh.',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg hoặc gif.',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'username.unique' => 'Tên đăng nhập đã tồn tại.',
            'email.unique' => 'Email đã tồn tại.',
            'role.in' => 'Vai trò không hợp lệ.',
        ]);

        $data = $request->only(['username', 'email', 'role']);
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('uploads/avatars', 'public');
            $data['avatar'] = 'storage/' . $path;
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Thêm người dùng thành công.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:admin,customer,staff',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],[
            'username.required' => 'Tên đăng nhập là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'role.required' => 'Vai trò là bắt buộc.',
            'avatar.image' => 'Ảnh đại diện phải là một tệp hình ảnh.',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg hoặc gif.',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'username.unique' => 'Tên đăng nhập đã tồn tại.',
            'email.unique' => 'Email đã tồn tại.',
            'role.in' => 'Vai trò không hợp lệ.',
        ]);

        $data = $request->only(['username', 'email', 'role']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('uploads/avatars', 'public');
            $data['avatar'] = 'storage/' . $path;
        }

        $user->update($data);

        return redirect()->route('admin.users.edit', $id)->with('success', 'Cập nhật người dùng thành công.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Xóa người dùng thành công.');
    }
}
