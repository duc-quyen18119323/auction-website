<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sản Phẩm Đấu Giá</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('components.header-logo')
    <div class="max-w-4xl mx-auto mt-8 px-4">
        <h2 class="text-2xl font-bold mb-6">
            @if(request()->routeIs('products.featured'))
                Sản Phẩm Sắp Diễn Ra
            @elseif(request()->routeIs('products.active'))
                Sản Phẩm Đang Đấu Giá
            @elseif(request()->routeIs('products.endingSoon'))
                Sản Phẩm Sắp Kết Thúc
            @else
                Danh Sách Sản Phẩm Đấu Giá
            @endif
        </h2>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(request()->routeIs('products.index'))
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
        @endif
        <div class="mb-6">
            @auth
                <a href="{{ url('/products/create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Thêm sản phẩm mới</a>
            @endauth
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($products as $product)
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    @if($product->images && $product->images->count())
                        <img src="{{ asset('storage/' . $product->images->first()->image) }}" alt="Ảnh sản phẩm" class="w-full h-48 object-cover rounded mb-4">
                    @endif
                    <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
                    <p class="mb-1">{{ $product->description }}</p>
                    <p class="mb-1">Giá khởi điểm: <b>{{ number_format($product->starting_price, 0, ',', '.') }} VNĐ</b></p>
                    <p class="mb-1">Bước giá: {{ number_format($product->bid_step, 0, ',', '.') }} VNĐ</p>
                    <p class="mb-1">Kết thúc: {{ date('d/m/Y H:i', strtotime($product->end_time)) }}</p>
                    <p class="mb-1">
                        <strong>Trạng thái:</strong>
                        @if($product->status == 'pending')
                            <span class="text-yellow-600">Chờ duyệt</span>
                        @elseif($product->status == 'active' && now() < $product->start_time)
                            <span class="text-blue-600">Đang hiển thị</span>
                        @elseif($product->status == 'active' && now() >= $product->start_time && now() <= $product->end_time)
                            <span class="text-green-600">Đang đấu giá</span>
                        @elseif($product->status == 'sold')
                            <span class="text-gray-600">Đã bán</span>
                        @else
                            <span class="text-gray-600">Không xác định</span>
                        @endif
                    </p>
                    <a href="{{ url('/products/' . $product->id) }}" class="mt-2 inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Xem chi tiết</a>
                </div>
            @empty
                <p>Không có sản phẩm nào.</p>
            @endforelse
        </div>
    </div>
</body>
</html>
