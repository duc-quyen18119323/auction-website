<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (auth()->check()) {
            return redirect('/'); // hoặc route('dashboard')
        }
        return view('auth.login');
    }

    public function showRegister()
    {
        if (auth()->check()) {
            return redirect('/'); // hoặc route('dashboard')
        }
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'Thông tin đăng nhập không chính xác.',
        ])->withInput($request->only('username'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'username.required' => 'Vui lòng nhập tên tài khoản',
            'username.unique' => 'Tên tài khoản đã được sử dụng',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã được sử dụng',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.exists' => 'Email không tồn tại trong hệ thống',
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        try {
            Mail::send('emails.reset-password', ['token' => $token, 'email' => $request->email], function($message) use($request) {
                $message->to($request->email);
                $message->subject('Đặt lại mật khẩu - Auction Website');
            });

            return back()->with('success', 'Link đặt lại mật khẩu đã được gửi đến email của bạn!');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Không thể gửi email. Vui lòng thử lại sau.']);
        }
    }

    public function showResetPassword($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.exists' => 'Email không tồn tại trong hệ thống',
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetRecord) {
            return back()->withErrors(['email' => 'Token không hợp lệ hoặc đã hết hạn']);
        }

        if (Carbon::parse($resetRecord->created_at)->addHours(24)->isPast()) {
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();
            return back()->withErrors(['email' => 'Token đã hết hạn. Vui lòng yêu cầu link mới']);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('login')->with('success', 'Mật khẩu đã được đặt lại thành công. Vui lòng đăng nhập!');
    }
}
