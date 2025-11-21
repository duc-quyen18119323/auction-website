@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Chỉnh sửa thông tin cá nhân</h2>
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif
    <form action="#" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Tên tài khoản</label>
            <input type="text" name="username" value="{{ $user->username }}" class="w-full border rounded px-3 py-2 bg-gray-100" disabled>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Họ tên</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Số điện thoại</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full border rounded px-3 py-2">
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Lưu thay đổi</button>
    </form>
</div>
@endsection
