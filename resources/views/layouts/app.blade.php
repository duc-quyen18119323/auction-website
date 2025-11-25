<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
</head>
<body>
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <div class="flex items-center gap-8">
            <a href="/">
                <img src="{{ asset('storage/products/logoweb.png') }}" alt="Logo" class="h-24 w-auto">
            </a>
            <!-- ...menu... -->
        </div>
        <div class="flex items-center gap-2">
        {{-- NAVBAR CHO USER: CHỈ CHECK GUARD web --}}
    @if(Auth::guard('web')->check())
    <a href="{{ route('profile.edit') }}" class="bg-gray-200 text-black font-bold py-2 px-4 rounded cursor-pointer">
        {{ Auth::guard('web')->user()->username }}
    </a>
    <form action="{{ route('logout') }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="py-2 px-4 bg-red-500 hover:bg-red-600 text-white rounded">
            Đăng xuất
        </button>
    </form>
@else
    <a href="{{ route('login') }}" class="py-2 px-4 text-gray-500 hover:text-blue-500">Đăng Nhập</a>
    <a href="{{ route('register') }}" class="py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded">Đăng Ký</a>
@endif

        </div>
    </header>
    <main class="p-4">
        @yield('content')
    </main>
</body>
</html>