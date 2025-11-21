@extends('admin.dashboard')
@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Thông tin cá nhân</h2>
    <div class="mb-6">
        <p><strong>Tên đăng nhập:</strong> {{ Auth::guard('admin')->user()->username ?? 'admin' }}</p>
        <p><strong>Email:</strong> {{ Auth::guard('admin')->user()->email ?? 'admin@email.com' }}</p>
    </div>
    <h3 class="text-lg font-semibold mb-2">Đổi mật khẩu</h3>
    <form method="POST" action="{{ route('admin.changePassword') }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-medium">Mật khẩu hiện tại</label>
            <input type="password" name="current_password" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">Mật khẩu mới</label>
            <input type="password" name="new_password" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">Xác nhận mật khẩu mới</label>
            <input type="password" name="new_password_confirmation" class="w-full border rounded px-3 py-2" required>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Đổi mật khẩu</button>
    </form>
    @if(session('success'))
        <div class="mt-4 text-green-600">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mt-4 text-red-600">{{ session('error') }}</div>
    @endif
</div>
@endsection