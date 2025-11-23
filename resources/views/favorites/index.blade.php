<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yêu Thích</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <i class="fas fa-heart text-red-600"></i>
                Sản Phẩm Yêu Thích
            </h2>
            <p class="text-gray-600 mt-2">Danh sách các sản phẩm bạn đã lưu</p>
        </div>

        @if(count($favorites) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($favorites as $index => $favorite)
                    @if($favorite->product)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 fade-in-card" data-delay="{{ $index * 0.1 }}" style="opacity: 0;">
                        <!-- Product Image -->
                        <div class="relative h-48 overflow-hidden bg-gray-200">
                            @if($favorite->product->images && $favorite->product->images->count() > 0)
                                <img src="{{ asset('storage/' . $favorite->product->images->first()->image) }}"
                                     alt="{{ $favorite->product->name }}"
                                     class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fas fa-image text-4xl"></i>
                                </div>
                            @endif
                            <div class="absolute top-2 right-2">
                                <form action="{{ route('favorite.destroy') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="product_id" value="{{ $favorite->product->id }}">
                                    <button type="submit" class="bg-white p-2 rounded-full shadow-lg hover:bg-red-50 transition-colors">
                                        <i class="fas fa-heart text-red-500"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 hover:text-blue-600 transition-colors">
                                {{ $favorite->product->name }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($favorite->product->description, 80) }}</p>

                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">Giá khởi điểm:</span>
                                    <span class="text-sm font-bold text-blue-600">{{ number_format($favorite->product->starting_price, 0, ',', '.') }} ₫</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">Bước giá:</span>
                                    <span class="text-sm font-semibold text-gray-700">{{ number_format($favorite->product->bid_step, 0, ',', '.') }} ₫</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">Kết thúc:</span>
                                    <span class="text-xs font-semibold text-gray-700">{{ date('d/m/Y H:i', strtotime($favorite->product->end_time)) }}</span>
                                </div>
                            </div>

                            <a href="{{ url('/products/' . $favorite->product->id) }}"
                               class="block w-full text-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                <i class="fas fa-eye mr-2"></i>Xem Chi Tiết
                            </a>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow-xl p-12 text-center">
                <div class="text-6xl mb-4">❤️</div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Bạn chưa lưu sản phẩm nào</h3>
                <p class="text-gray-500 mb-6">Hãy khám phá và lưu những sản phẩm bạn yêu thích!</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class="fas fa-search mr-2"></i>Xem Sản Phẩm
                </a>
            </div>
        @endif
    </div>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <script>
        document.querySelectorAll('.fade-in-card').forEach(card => {
            const delay = parseFloat(card.getAttribute('data-delay')) || 0;
            card.style.animation = `fadeInUp 0.4s ease-out forwards`;
            card.style.animationDelay = delay + 's';
        });
    </script>
</body>
</html>
