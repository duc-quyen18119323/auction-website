<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bảng Điều Khiển Quản Trị')</title>

    {{-- Tailwind --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    {{-- CSS giao diện admin --}}
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
</head>
<body class="admin-dashboard">

<div class="admin-layout">
    {{-- SIDEBAR --}}
    <aside class="admin-sidebar">
        <div class="admin-sidebar-header">
            <div class="mb-4 flex justify-center">
                <a href="{{ url('/admin') }}">
                    <img src="{{ asset('storage/products/logoweb.png') }}"
                         alt="Logo"
                         class="h-16 w-auto hover:opacity-80 transition-opacity">
                </a>
            </div>

            <h1 class="admin-sidebar-title text-center">
                Quản Trị Đấu Giá
            </h1>
        </div>

        <nav class="admin-nav">
            <a href="{{ url('/admin/products') }}"
               class="admin-nav-item {{ request()->is('admin/products*') ? 'is-active' : '' }}">
                Quản lý sản phẩm
            </a>

            <a href="{{ url('/admin/auctions') }}"
               class="admin-nav-item {{ request()->is('admin/auctions*') ? 'is-active' : '' }}">
                Quản lý phiên đấu giá
            </a>

            <a href="{{ route('admin.inbox') }}"
               class="admin-nav-item {{ request()->routeIs('admin.inbox*') ? 'is-active' : '' }}">
                Hộp thư hỗ trợ
                <span class="admin-nav-badge">
                    {{ \App\Http\Controllers\AdminProfileController::getUnreadSupportCount() }}
                </span>
            </a>

            <a href="{{ url('/admin/profile') }}"
               class="admin-nav-item {{ request()->is('admin/profile') ? 'is-active' : '' }}">
                Thông tin cá nhân
            </a>
        </nav>

        <form action="{{ route('admin.logout') }}" method="POST" class="mt-6">
            @csrf
            <button type="submit"
                    class="w-full py-2 px-4 bg-red-500 hover:bg-red-600 rounded text-white font-bold text-sm">
                Đăng xuất
            </button>
        </form>

        <div class="admin-sidebar-footer">
            © {{ date('Y') }} QBidzone
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="admin-main">
        <div class="admin-main-card">
            @hasSection('page_title')
                <h1 class="admin-page-title">@yield('page_title')</h1>
            @endif

            @yield('content')
        </div>
    </main>
</div>

</body>
</html>
