<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sản Phẩm Của Bạn</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('storage/products/logoweb.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product-card.css') }}">
    <style>
        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .img-zoom img {
            transition: transform .4s ease;
        }

        .img-zoom:hover img {
            transform: scale(1.08);
        }
    </style>
</head>

<body class="bg-gray-50">
    @include('components.navbar')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-16">
        {{-- Header --}}
        <section class="mb-8">
            <div class="flex items-center space-x-4 mb-3">
                <div
                    class="h-14 w-14 rounded-2xl bg-blue-500 flex items-center justify-center text-white text-2xl shadow-md">
                    <i class="fas fa-gavel"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Danh Sách Sản Phẩm Đấu Giá Của Bạn
                    </h1>
                    <p class="text-gray-500 mt-1">
                        Khám phá và tham gia đấu giá các sản phẩm độc đáo do bạn đăng tải
                    </p>
                </div>
            </div>
        </section>

        {{-- Thanh tìm kiếm --}}
        <section class="mb-6">
            <div class="bg-white rounded-xl shadow-md p-4 sm:p-5">
                <form method="GET" action="{{ route('my-products.index') }}"
                    class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
                    {{-- Search --}}
                    <div class="flex-1 relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="Tìm kiếm sản phẩm của bạn..."
                            class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700">
                    </div>

                    {{-- Category --}}
                    <div class="sm:w-56 relative">
                        <select name="category"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700 appearance-none bg-white">
                            <option value="">Tất cả danh mục</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                        <i
                            class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    </div>

                    {{-- Button --}}
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 flex items-center justify-center gap-2 shadow-md">
                        <i class="fas fa-search"></i> Tìm Kiếm
                    </button>
                </form>
            </div>
        </section>

        {{-- Thanh "Thêm sản phẩm" + thống kê --}}
        <section class="mb-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <a href="{{ route('products.create') }}"
                class="inline-flex items-center px-5 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i> Thêm Sản Phẩm Mới
            </a>

            <p class="text-sm text-gray-500">
                Tìm thấy
                <span class="font-semibold text-blue-600">
                    {{ $products->count() }}
                </span>
                sản phẩm của bạn
            </p>
        </section>

        {{-- Danh sách sản phẩm --}}
        @php
            // Bảo hiểm: nếu controller chưa lọc thì view vẫn chỉ lấy của user hiện tại
            $userId = auth()->id();
            $myProducts = $products->where('user_id', $userId);
        @endphp

        @if($myProducts->count() > 0)
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($myProducts as $product)
                    <div class="product-card bg-white rounded-xl shadow-sm overflow-hidden">
                        {{-- Hình ảnh --}}
                        <div class="relative h-48 bg-gray-100 img-zoom">
                            @if($product->images && $product->images->isNotEmpty())
                                <img src="{{ Storage::url($product->images->first()->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fas fa-image text-4xl"></i>
                                </div>
                            @endif>

                            {{-- Trạng thái --}}
                            <div class="absolute bottom-3 left-3">
                                @if($product->status == 'active' && now()->between($product->start_time, $product->end_time))
                                    <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">
                                        <i class="fas fa-fire mr-1"></i>Đang đấu giá
                                    </span>
                                @elseif($product->status == 'active' && now()->lt($product->start_time))
                                    <span class="px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-full">
                                        Sắp bắt đầu
                                    </span>
                                @elseif($product->status == 'pending')
                                    <span class="px-3 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-full">
                                        Chờ duyệt
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-gray-400 text-white text-xs font-semibold rounded-full">
                                        Không hoạt động
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Thông tin sản phẩm --}}
                        <div class="p-4 flex flex-col h-full">

                            {{-- Tên sản phẩm: chỉ hiển thị 2 dòng --}}
                            <h3 class="text-base font-semibold text-gray-900 mb-1 product-title line-clamp-2">
                                {{ $product->name }}
                            </h3>

                            {{-- Mô tả: rút gọn 2 dòng --}}
                            <p class="text-xs text-gray-500 mb-3 line-clamp-2">
                                {{ \Illuminate\Support\Str::limit($product->description, 80) }}
                            </p>

                            {{-- Thông tin sản phẩm --}}
                            <div class="space-y-1 text-sm mb-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 text-xs">Giá khởi điểm</span>
                                    <span class="font-semibold text-blue-600">
                                        {{ number_format($product->starting_price, 0, ',', '.') }} ₫
                                    </span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 text-xs">Bước giá</span>
                                    <span class="font-semibold text-gray-700">
                                        {{ number_format($product->bid_step, 0, ',', '.') }} ₫
                                    </span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 text-xs">Kết thúc</span>
                                    <span class="font-semibold text-gray-700 text-xs">
                                        {{ $product->end_time ? $product->end_time->format('d/m/Y H:i') : '—' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Nút xem chi tiết luôn dưới cùng --}}
                            <a href="{{ url('/products/' . $product->id) }}"
                               class="block w-full text-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                <i class="fas fa-eye mr-2"></i>Xem Chi Tiết
                            </a>

                        </div>

                    </div>
                @endforeach
            </section>
        @else
            <section class="bg-white rounded-xl shadow-md p-10 text-center mt-6">
                <i class="fas fa-box-open text-5xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Bạn chưa có sản phẩm nào</h3>
                <p class="text-gray-500 mb-5">
                    Hãy đăng sản phẩm đầu tiên để bắt đầu đấu giá nhé!
                </p>
                <a href="{{ route('products.create') }}"
                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i> Đăng Sản Phẩm Ngay
                </a>
            </section>
        @endif
    </main>
</body>

</html>