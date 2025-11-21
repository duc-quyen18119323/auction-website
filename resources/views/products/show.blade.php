<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm Đấu Giá</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('components.header-logo')
    <div class="max-w-5xl mx-auto mt-10 px-4">
        <div class="flex gap-8 items-stretch mb-8">
            @if($product->images && $product->images->count())
            <div class="relative w-64 flex-shrink-0">
                <div id="product-image-slider" class="w-64 h-full overflow-hidden relative">
                    @foreach($product->images as $img)
                        <img src="{{ asset('storage/' . $img->image) }}" alt="Ảnh sản phẩm" class="product-slide absolute top-0 left-0 w-64 h-full object-cover rounded transition-opacity duration-300" style="opacity:0;">
                    @endforeach
                </div>
                <button id="prev-slide" class="absolute left-0 top-1/2 -translate-y-1/2 bg-gray-200 rounded-full px-2 py-1 text-xl z-10">&#8249;</button>
                <button id="next-slide" class="absolute right-0 top-1/2 -translate-y-1/2 bg-gray-200 rounded-full px-2 py-1 text-xl z-10">&#8250;</button>
            </div>
            @endif
            <div class="bg-white p-8 rounded-lg shadow-lg flex-1">
                <h2 class="text-3xl font-extrabold mb-4 text-gray-900">{{ $product->name }}</h2>
                <p class="mb-3 text-gray-700">{{ $product->description }}</p>
                <div class="space-y-2 mb-4">
                    <p>Giá khởi điểm: <span class="font-bold text-lg text-blue-700">{{ number_format($product->starting_price, 0, ',', '.') }} VNĐ</span></p>
                    <p>Bước giá: <span class="font-bold text-lg text-blue-700">{{ number_format($product->bid_step, 0, ',', '.') }} VNĐ</span></p>
                    <p>Bắt đầu: <span class="font-semibold">{{ $product->start_time->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}</span></p>
                    <p>Kết thúc: <span class="font-semibold">{{ $product->end_time->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}</span></p>
                    <p>Người tạo: <span class="font-semibold text-green-700">{{ $product->user->username }}</span></p>
                </div>
                <div class="flex flex-col md:flex-row gap-3 mt-4">
                    @if(Auth::check() && Auth::id() === $product->user_id)
                        <a href="{{ route('products.edit', $product->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded mb-2 md:mb-0 md:mr-2 text-center">Chỉnh sửa sản phẩm</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Xóa sản phẩm</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-lg mb-10">
            <h3 class="text-xl font-semibold mb-4">Lịch Sử Đặt Giá</h3>
            @php $winnerBid = $bids->first(); @endphp
            @if($winnerBid && now() > $product->end_time)
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    <strong>Người chiến thắng:</strong>
                    @if($winnerBid->user)
                        {{ $winnerBid->user->username }}
                    @else
                        [Tài khoản đã xóa]
                    @endif
                    với số tiền {{ number_format($winnerBid->amount, 0, ',', '.') }} VNĐ
                </div>
            @endif
            @if($winnerBid && now() > $product->end_time && Auth::check() && Auth::id() === $winnerBid->user_id)
                <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
                    <strong>Thông tin liên hệ người bán:</strong><br>
                    Email: {{ $product->user->email }}<br>
                    Số điện thoại: {{ $product->user->phone }}
                </div>
            @endif
            @if($bids->count() > 0)
                <table class="min-w-full table-auto border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border">Người đặt</th>
                            <th class="px-4 py-2 border">Số tiền</th>
                            <th class="px-4 py-2 border">Thời gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bids as $bid)
                            <tr>
                                <td class="border px-4 py-2">
                                    @if($bid->user)
                                        {{ $bid->user->username }}
                                    @else
                                        [Tài khoản đã xóa]
                                    @endif
                                </td>
                                <td class="border px-4 py-2">{{ number_format($bid->amount, 0, ',', '.') }} VNĐ</td>
                                <td class="border px-4 py-2">{{ date('d/m/Y H:i', strtotime($bid->created_at)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Chưa có ai đặt giá cho sản phẩm này.</p>
            @endif
        </div>
        @if(now() > $product->end_time)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                Phiên đấu giá đã kết thúc.
            </div>
        @else
            @auth
                @if(now() >= $product->start_time && now() <= $product->end_time)
                    <div class="bg-white p-6 rounded-xl shadow-lg">
                        <h3 class="text-xl font-semibold mb-4">Đặt Giá Mới</h3>
                        @if(session('error'))
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ url('/products/' . $product->id . '/bid') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="amount">Số tiền đặt giá</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="amount" type="number" step="0.01" name="amount" required>
                            </div>
                            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full" type="submit">Đặt giá</button>
                        </form>
                    </div>
                @endif
            @endauth
        @endif
    </div>
    <script>
        const slides = document.querySelectorAll('.product-slide');
        let current = 0;
        function showSlide(idx) {
            slides.forEach((img, i) => img.style.opacity = i === idx ? '1' : '0');
        }
        showSlide(current);
        document.getElementById('prev-slide').onclick = function() {
            current = (current - 1 + slides.length) % slides.length;
            showSlide(current);
        };
        document.getElementById('next-slide').onclick = function() {
            current = (current + 1) % slides.length;
            showSlide(current);
        };
    </script>
</body>
</html>
