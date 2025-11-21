<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        // Chỉ cho tài khoản có is_admin = 1 đăng nhập admin
        $credentials['is_admin'] = 1;

        // ❗ DÙNG GUARD admin, KHÔNG DÙNG Auth::attempt()
        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Tài khoản hoặc mật khẩu không đúng, hoặc bạn không có quyền truy cập.');
    }

    public function logout(Request $request)
    {
        // ❗ Đăng xuất guard admin, không đụng guard web
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.form');
    }
}
