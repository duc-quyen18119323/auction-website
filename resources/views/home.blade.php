<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Đấu Giá</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('storage/products/logoweb.png') }}">
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <div>
                        <a href="/" class="flex items-center py-4">
                            <img src="{{ asset('storage/products/logoweb.png') }}" alt="Logo" class="h-24 w-auto">
                        </a>
                    </div>
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="/products" class="py-4 px-2 text-gray-500 hover:text-blue-500">Sản Phẩm</a>
                        <a href="/bids" class="py-4 px-2 text-gray-500 hover:text-blue-500">Đấu Giá Của Tôi</a>
                        <a href="/transactions" class="py-4 px-2 text-gray-500 hover:text-blue-500">Giao Dịch</a>
                        <a href="/favorites" class="py-4 px-2 text-gray-500 hover:text-red-500">Sản phẩm yêu thích</a>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-3">
                    @if(Auth::check())
                        <a href="{{ route('profile.edit') }}" class="bg-gray-200 text-black font-bold py-2 px-4 rounded cursor-pointer">
                            {{ Auth::user()->username }}
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="py-2 px-4 bg-red-500 hover:bg-red-600 text-white rounded">Đăng xuất</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="py-2 px-4 text-gray-500 hover:text-blue-500">Đăng Nhập</a>
                        <a href="{{ route('register') }}" class="py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded">Đăng Ký</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto mt-8 px-4">
        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h1 class="text-3xl font-bold mb-4">Chào Mừng Đến Với Nền Tảng Đấu Giá</h1>
            <p class="text-gray-600">Khám phá những sản phẩm độc đáo và đặt giá theo thời gian thực.</p>
        </div>

        <form method="GET" action="{{ route('products.index') }}" class="mb-6 flex flex-col md:flex-row gap-4 items-center">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm theo tên sản phẩm..." class="border rounded px-3 py-2 w-full md:w-1/2">
            <select name="category" class="border rounded px-3 py-2 w-full md:w-1/4">
                <option value="">Tất cả danh mục</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" @if(request('category') == $cat) selected @endif>{{ $cat }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tìm kiếm</button>
        </form>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Sắp Diễn Ra</h2>
                <p class="text-gray-600">Xem các sản phẩm đấu giá sắp diễn ra</p>
                <a href="{{ route('products.featured', ['category' => request('category')]) }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">Xem ngay</a>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Đang Đấu Giá</h2>
                <p class="text-gray-600">Tham gia phiên đấu giá đang diễn ra</p>
                <a href="{{ route('products.active', ['category' => request('category')]) }}" class="mt-4 inline-block bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded">Xem ngay</a>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Sắp Kết Thúc</h2>
                <p class="text-gray-600">Đừng bỏ lỡ những cơ hội cuối cùng</p>
                <a href="{{ route('products.endingSoon', ['category' => request('category')]) }}" class="mt-4 inline-block bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded">Xem ngay</a>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto mt-8 px-4">
        <h2 class="text-2xl font-bold mb-6">Danh Sách Sản Phẩm Đấu Giá</h2>
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif
        <div class="mb-6">
            @auth
                <a href="{{ url('/products/create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Thêm sản phẩm mới</a>
            @endauth
        </div>
        @php
            $favoriteIds = [];
            if(Auth::check()) {
                $favoriteIds = \App\Models\Favorite::where('user_id', Auth::id())->pluck('product_id')->toArray();
            }
        @endphp
        <div class="grid md:grid-cols-2 gap-6">
            @forelse($products as $product)
                <div class="bg-white p-6 rounded-lg shadow-lg">
                @if($product->images->isNotEmpty())
    <img
      src="{{ Storage::url($product->images->first()->image) }}"
      alt="{{ $product->name }}"
      class="w-full h-48 object-cover rounded mb-4">
@else
    <div class="w-full h-48 bg-gray-100 rounded mb-4 grid place-items-center text-gray-400">
        Không có ảnh
    </div>
@endif

                    <h3 class="text-xl font-semibold mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 mb-2">{{ $product->description }}</p>
                    <p class="mb-2">Giá khởi điểm: <strong>{{ number_format($product->starting_price, 0, ',', '.') }} VNĐ</strong></p>
                    <p class="mb-2">Bước giá: <strong>{{ number_format($product->bid_step, 0, ',', '.') }} VNĐ</strong></p>
                    <p class="mb-2">Bắt đầu: <strong>{{ date('d/m/Y H:i', strtotime($product->start_time)) }}</strong></p>
                    <p class="mb-2">Kết thúc: <strong>{{ date('d/m/Y H:i', strtotime($product->end_time)) }}</strong></p>
                    <div class="flex items-center mb-2">
                        @auth
                            @if(in_array($product->id, $favoriteIds))
                                <form action="{{ route('favorite.destroy') }}" method="POST" class="mr-2">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24" stroke="red" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('favorite.store') }}" method="POST" class="mr-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="red" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                    <a href="{{ url('/products/' . $product->id) }}" class="mt-2 inline-block bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded">Xem chi tiết</a>
                </div>
            @empty
                <p>Chưa có sản phẩm đấu giá nào.</p>
            @endforelse
        </div>
    </div>

    <footer class="bg-white mt-12 py-6">
        <div class="max-w-6xl mx-auto px-4">
            <p class="text-center text-gray-500">&copy; 2023 Website Đấu Giá. Đã đăng ký bản quyền.</p>
        </div>
    </footer>
    @auth
        @include('components.chat-widget')
    @endauth
</body>
</html>