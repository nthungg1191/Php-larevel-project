<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    // Hiển thị thông tin tài khoản
    public function show()
    {
        $user = Auth::user();
        return view('user.information', compact('user'));
    }

    // Cập nhật thông tin tài khoản (chỉ cập nhật tên và email)
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
        ]);

        return redirect()->route('user.profile')->with('success', 'Thông tin đã được cập nhật.');
    }

    // Thay đổi mật khẩu
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        $user = Auth::user();

        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu cũ không chính xác']);
        }

        // Cập nhật mật khẩu mới
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('user.profile')->with('success', 'Mật khẩu đã được thay đổi.');
    }
}
