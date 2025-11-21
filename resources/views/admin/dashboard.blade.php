<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng Điều Khiển Quản Trị</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-900 text-white flex flex-col py-8 px-4">
            <div class="mb-6 flex justify-center">
                <a href="/admin">
                    <img src="{{ asset('storage/products/logoweb.png') }}" alt="Logo" class="h-16 w-auto hover:opacity-80 transition-opacity">
                </a>
            </div>
            <div class="mb-10">
                <h1 class="text-2xl font-bold text-center">Quản Trị Đấu Giá</h1>
            </div>
            <nav class="flex-1">
                <ul class="space-y-4">
                    <li>
                        <a href="/admin/products" class="block py-2 px-4 rounded hover:bg-blue-700 transition">Quản lý sản phẩm</a>
                    </li>
                    <li>
                        <a href="/admin/auctions" class="block py-2 px-4 rounded hover:bg-blue-700 transition">Quản lý phiên đấu giá</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.inbox') }}" class="block py-2 px-4 rounded hover:bg-blue-700 transition">
                            Hộp thư hỗ trợ
                            <span class="ml-2 inline-block bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                {{ \App\Http\Controllers\AdminProfileController::getUnreadSupportCount() }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/profile" class="block py-2 px-4 rounded hover:bg-blue-700 transition">Thông tin cá nhân</a>
                    </li>
                </ul>
            </nav>
            <form action="{{ route('admin.logout') }}" method="POST" class="mt-10">
                @csrf
                <button type="submit" class="w-full py-2 px-4 bg-red-500 hover:bg-red-600 rounded text-white font-bold">Đăng xuất</button>
            </form>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 p-10">
            @yield('content')
        </main>
    </div>
</body>
</html>