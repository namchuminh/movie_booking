<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:6',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'username.required' => 'Tên đăng nhập là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã được sử dụng.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'password.min' => 'Mật khẩu ít nhất 6 ký tự.',
            'avatar.image' => 'Tệp phải là hình ảnh.',
            'avatar.mimes' => 'Ảnh chỉ hỗ trợ jpeg, png, jpg, gif.',
            'avatar.max' => 'Kích thước ảnh tối đa 2MB.'
        ]);

        $user->username = $request->username;
        $user->email    = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if ($user->avatar && Storage::disk('public')->exists(str_replace('storage/', '', $user->avatar))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $user->avatar));
            }

            $path = $request->file('avatar')->store('uploads/avatars', 'public');
            $user->avatar = 'storage/' . $path;
        }

        $user->save();

        return redirect()->route('admin.profiles.index')->with('success', 'Cập nhật thông tin thành công.');
    }
}
