<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm Đấu Giá</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/product-show.css') }}">

</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    @include('components.header-logo')

    <div class="max-w-5xl mx-auto mt-6 px-3 pb-10">
        <!-- Product Main Section -->
        <div class="flex flex-col lg:flex-row gap-6 items-start mb-6">
            @if($product->images && $product->images->count())
                <div class="image-slider relative w-full lg:w-80 flex-shrink-0">
                    <div id="product-image-slider"
                         class="image-container w-full lg:w-80 h-80 lg:h-96 overflow-hidden relative bg-white rounded-2xl shadow-md">
                        @foreach($product->images as $index => $img)
                            <img src="{{ asset('storage/' . $img->image) }}"
                                 alt="Ảnh sản phẩm {{ $index + 1 }}"
                                 class="product-slide absolute top-0 left-0 w-full h-full object-cover {{ $index === 0 ? 'active' : '' }}"
                                 loading="lazy">
                        @endforeach
                    </div>

                    @if($product->images->count() > 1)
                        <button id="prev-slide"
                                class="slider-btn absolute left-3 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white rounded-full w-9 h-9 flex items-center justify-center text-xl font-bold text-gray-700 shadow-md z-10 backdrop-blur-sm">
                            &#8249;
                        </button>
                        <button id="next-slide"
                                class="slider-btn absolute right-3 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white rounded-full w-9 h-9 flex items-center justify-center text-xl font-bold text-gray-700 shadow-md z-10 backdrop-blur-sm">
                            &#8250;
                        </button>
                        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5 z-10">
                            @foreach($product->images as $index => $img)
                                <div class="slide-indicator w-2 h-2 rounded-full bg-white/60 transition-all duration-300 {{ $index === 0 ? 'bg-white w-5' : '' }}"></div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            <div class="product-info bg-white p-6 md:p-7 rounded-2xl shadow-xl flex-1 w-full">
                <div class="mb-3">
                    @if(now() < $product->start_time)
                        <span class="inline-block px-3 py-1.5 bg-blue-100 text-blue-800 rounded-full text-xs md:text-sm font-semibold status-badge">
                            ⏰ Sắp bắt đầu
                        </span>
                    @elseif(now() >= $product->start_time && now() <= $product->end_time)
                        <span class="inline-block px-3 py-1.5 bg-green-100 text-green-800 rounded-full text-xs md:text-sm font-semibold status-badge">
                            🔥 Đang đấu giá
                        </span>
                    @else
                        <span class="inline-block px-3 py-1.5 bg-red-100 text-red-800 rounded-full text-xs md:text-sm font-semibold">
                            ❌ Đã kết thúc
                        </span>
                    @endif
                </div>

                <h2 class="text-2xl md:text-3xl font-extrabold mb-3 text-gray-900 leading-snug">
                    {{ $product->name }}
                </h2>

                <p class="mb-4 text-gray-600 text-sm md:text-base leading-relaxed">
                    {{ $product->description }}
                </p>

                <div class="space-y-3 mb-4">
                    <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg border-l-4 border-blue-500">
                        <span class="text-gray-700 font-medium text-sm md:text-base">Giá khởi điểm:</span>
                        <span class="font-bold text-xl md:text-2xl text-blue-700 price-highlight">
                            {{ number_format($product->starting_price, 0, ',', '.') }} VNĐ
                        </span>
                    </div>

                    <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg border-l-4 border-purple-500">
                        <span class="text-gray-700 font-medium text-sm md:text-base">Bước giá:</span>
                        <span class="font-bold text-lg md:text-xl text-purple-700">
                            {{ number_format($product->bid_step, 0, ',', '.') }} VNĐ
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-500 mb-1">Bắt đầu</p>
                            <p class="font-semibold text-gray-800 text-sm md:text-base">
                                {{ $product->start_time->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-500 mb-1">Kết thúc</p>
                            <p class="font-semibold text-gray-800 text-sm md:text-base">
                                {{ $product->end_time->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>

                    <div class="p-3 bg-gradient-to-r from-green-50 to-green-100 rounded-lg border-l-4 border-green-500">
                        <p class="text-xs text-gray-500 mb-1">Người tạo</p>
                        <p class="font-semibold text-green-700 text-base md:text-lg">
                            {{ $product->user->username }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-2.5 mt-3">
                    @if(Auth::check() && Auth::id() === $product->user_id)
                        <a href="{{ route('products.edit', $product->id) }}"
                           class="bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-semibold py-2.5 px-4 rounded-lg text-sm md:text-base text-center shadow-md">
                            ✏️ Chỉnh sửa sản phẩm
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');"
                              class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-2.5 px-4 rounded-lg text-sm md:text-base shadow-md">
                                🗑️ Xóa sản phẩm
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Bid History Section -->
        <div class="bid-history bg-white p-6 rounded-2xl shadow-xl mb-6">
            <h3 class="text-xl md:text-2xl font-bold mb-4 text-gray-900 flex items-center gap-2">
                <span class="text-2xl md:text-3xl">📊</span>
                Lịch Sử Đặt Giá
                <span class="ml-auto text-sm md:text-base font-normal text-gray-500">
                    ({{ $bids->count() }} lượt)
                </span>
            </h3>

            @php $winnerBid = $bids->first(); @endphp

            @if($winnerBid && now() > $product->end_time)
                <div class="mb-5 p-5 winner-badge text-white rounded-xl shadow-lg">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-3xl md:text-4xl">🏆</span>
                        <div>
                            <p class="text-base md:text-lg font-bold mb-1">Người chiến thắng</p>
                            <p class="text-xl md:text-2xl font-extrabold">
                                @if($winnerBid->user)
                                    {{ $winnerBid->user->username }}
                                @else
                                    [Tài khoản đã xóa]
                                @endif
                            </p>
                        </div>
                    </div>
                    <p class="text-lg md:text-xl font-semibold mt-2">
                        Số tiền:
                        <span class="text-2xl md:text-3xl">
                            {{ number_format($winnerBid->amount, 0, ',', '.') }} VNĐ
                        </span>
                    </p>
                </div>
            @endif

            @if($winnerBid && now() > $product->end_time && Auth::check() && Auth::id() === $winnerBid->user_id)
                <div class="mb-5 p-4 bg-gradient-to-r from-blue-50 to-blue-100 border-l-4 border-blue-500 rounded-xl shadow-md">
                    <h4 class="font-bold text-blue-900 mb-2 text-base md:text-lg flex items-center gap-2">
                        <span>📞</span>
                        Thông tin liên hệ người bán
                    </h4>
                    <div class="space-y-1.5 text-blue-800 text-sm md:text-base">
                        <p><strong>Email:</strong> {{ $product->user->email }}</p>
                        <p><strong>Số điện thoại:</strong> {{ $product->user->phone ?? 'Chưa cập nhật' }}</p>
                    </div>
                </div>
            @endif

            @if($bids->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto text-sm">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-100 to-gray-200">
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Người đặt</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Số tiền</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Thời gian</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($bids as $index => $bid)
                                <tr class="table-row bg-white hover:bg-blue-50 transition-all duration-300"
                                    style="opacity: 0;"
                                    data-index="{{ $index }}"
                                    data-delay="{{ $index * 0.05 }}">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold mr-3 text-sm">
                                                {{ strtoupper(substr($bid->user ? $bid->user->username : 'N/A', 0, 1)) }}
                                            </div>
                                            <div class="text-sm font-medium text-gray-900">
                                                @if($bid->user)
                                                    {{ $bid->user->username }}
                                                @else
                                                    <span class="text-gray-400 italic">[Tài khoản đã xóa]</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="font-bold text-green-600">
                                            {{ number_format($bid->amount, 0, ',', '.') }} VNĐ
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-xs md:text-sm text-gray-500">
                                        {{ date('d/m/Y H:i', strtotime($bid->created_at)) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-5xl mb-3">🔍</div>
                    <p class="text-lg text-gray-500 font-medium">Chưa có ai đặt giá cho sản phẩm này.</p>
                    <p class="text-sm text-gray-400 mt-1">Hãy là người đầu tiên đặt giá!</p>
                </div>
            @endif
        </div>

        <!-- Bid Form Section -->
        @if(now() > $product->end_time)
            <div class="bid-form bg-gradient-to-r from-red-100 to-red-200 border-l-4 border-red-500 text-red-800 px-5 py-3.5 rounded-xl shadow-md">
                <div class="flex items-center gap-2.5">
                    <span class="text-2xl md:text-3xl">⏰</span>
                    <p class="text-base md:text-lg font-semibold">Phiên đấu giá đã kết thúc.</p>
                </div>
            </div>
        @else
            @auth
                @if(now() >= $product->start_time && now() <= $product->end_time)
                    <div class="bid-form info-card bg-white p-6 rounded-2xl shadow-xl">
                        <h3 class="text-xl md:text-2xl font-bold mb-4 text-gray-900 flex items-center gap-2">
                            <span class="text-2xl md:text-3xl">💰</span>
                            Đặt Giá Mới
                        </h3>

                        @if(session('error'))
                            <div class="mb-4 p-3.5 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg shadow-sm">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg">⚠️</span>
                                    <p class="font-semibold text-sm md:text-base">{{ session('error') }}</p>
                                </div>
                            </div>
                        @endif

                        @error('amount')
                            <div class="mb-4 p-3.5 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg shadow-sm">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg">⚠️</span>
                                    <p class="font-semibold text-sm md:text-base">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror

                        <form action="{{ url('/products/' . $product->id . '/bid') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="amount">
                                    Số tiền đặt giá (VNĐ)
                                </label>
                                <div class="relative">
                                    <input class="input-field shadow-md appearance-none border-2 border-gray-300 rounded-xl w-full py-3 px-5 text-gray-700 text-base leading-tight focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300"
                                           id="amount"
                                           type="number"
                                           step="{{ $product->bid_step }}"
                                           name="amount"
                                           min="{{ ($bids->first() ? $bids->first()->amount : $product->starting_price) + $product->bid_step }}"
                                           placeholder="Nhập số tiền đặt giá..."
                                           required>
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold text-sm">
                                        VNĐ
                                    </div>
                                </div>
                                <p class="mt-1.5 text-xs md:text-sm text-gray-500">
                                    💡 Giá tối thiểu:
                                    <span class="font-bold text-blue-600">
                                        {{ number_format(($bids->first() ? $bids->first()->amount : $product->starting_price) + $product->bid_step, 0, ',', '.') }} VNĐ
                                    </span>
                                </p>
                            </div>

                            <button class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-5 rounded-xl text-base md:text-lg shadow-lg focus:outline-none focus:ring-4 focus:ring-green-300 transition-all duration-300"
                                    type="submit">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="text-xl md:text-2xl">🚀</span>
                                    <span>Đặt giá ngay</span>
                                </span>
                            </button>
                        </form>
                    </div>
                @elseif(now() < $product->start_time)
                    <div class="bid-form bg-gradient-to-r from-blue-100 to-blue-200 border-l-4 border-blue-500 text-blue-800 px-5 py-3.5 rounded-xl shadow-md">
                        <div class="flex items-center gap-2.5">
                            <span class="text-2xl md:text-3xl">⏳</span>
                            <p class="text-base md:text-lg font-semibold">Phiên đấu giá chưa bắt đầu. Vui lòng quay lại sau.</p>
                        </div>
                    </div>
                @endif
            @else
                <div class="bid-form bg-gradient-to-r from-yellow-100 to-yellow-200 border-l-4 border-yellow-500 text-yellow-800 px-5 py-3.5 rounded-xl shadow-md">
                    <div class="flex items-center gap-2.5">
                        <span class="text-2xl md:text-3xl">🔐</span>
                        <p class="text-base md:text-lg font-semibold">
                            Vui lòng
                            <a href="{{ route('login') }}" class="underline font-bold">đăng nhập</a>
                            để đặt giá.
                        </p>
                    </div>
                </div>
            @endauth
        @endif
    </div>

    <script>
        const slides = document.querySelectorAll('.product-slide');
        const indicators = document.querySelectorAll('.slide-indicator');
        let current = 0;
        let autoSlideInterval;

        function showSlide(idx) {
            slides.forEach((img, i) => {
                if (i === idx) {
                    img.classList.add('active');
                    img.style.opacity = '1';
                } else {
                    img.classList.remove('active');
                    img.style.opacity = '0';
                }
            });

            if (indicators.length > 0) {
                indicators.forEach((indicator, i) => {
                    if (i === idx) {
                        indicator.classList.add('bg-white', 'w-5');
                        indicator.classList.remove('bg-white/60', 'w-2');
                    } else {
                        indicator.classList.remove('bg-white', 'w-5');
                        indicator.classList.add('bg-white/60', 'w-2');
                    }
                });
            }
        }

        function nextSlide() {
            current = (current + 1) % slides.length;
            showSlide(current);
        }

        function prevSlide() {
            current = (current - 1 + slides.length) % slides.length;
            showSlide(current);
        }

        if (slides.length > 0) {
            showSlide(current);

            const prevBtn = document.getElementById('prev-slide');
            const nextBtn = document.getElementById('next-slide');

            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    prevSlide();
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    nextSlide();
                });
            }

            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') prevSlide();
                if (e.key === 'ArrowRight') nextSlide();
            });
        }

        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const delay = entry.target.getAttribute('data-delay') || 0;
                    entry.target.style.animationDelay = delay + 's';
                    entry.target.style.opacity = '1';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.table-row').forEach(row => {
            observer.observe(row);
        });

        const amountInput = document.getElementById('amount');
        if (amountInput) {
            amountInput.addEventListener('input', function(e) {
                const value = parseFloat(e.target.value);
                const minValue = parseFloat(e.target.min);
                if (value && value < minValue) {
                    e.target.setCustomValidity(`Giá tối thiểu là ${minValue.toLocaleString('vi-VN')} VNĐ`);
                } else {
                    e.target.setCustomValidity('');
                }
            });
        }
    </script>
</body>

</html>
