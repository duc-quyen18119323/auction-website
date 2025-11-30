<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sản Phẩm Đấu Giá Của Bạn</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('storage/products/logoweb.png') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-16">
        <!-- Page Header -->
        <div class="mb-8 animate-fade-in-up">
            <div class="flex items-center gap-4 mb-4">
                @if(request()->routeIs('products.featured'))
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 rounded-xl shadow-lg">
                        <i class="fas fa-clock text-white text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
                            Sản Phẩm Sắp Diễn Ra
                        </h2>
                        <p class="text-gray-600">Các sản phẩm đấu giá sắp bắt đầu - Hãy chuẩn bị sẵn sàng!</p>
                    </div>
                @elseif(request()->routeIs('products.active'))
                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-4 rounded-xl shadow-lg">
                        <i class="fas fa-fire text-white text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
                            Sản Phẩm Đang Đấu Giá
                        </h2>
                        <p class="text-gray-600">Tham gia ngay các phiên đấu giá đang diễn ra sôi động</p>
                    </div>
                @elseif(request()->routeIs('products.endingSoon'))
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-4 rounded-xl shadow-lg">
                        <i class="fas fa-hourglass-half text-white text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
                            Sản Phẩm Sắp Kết Thúc
                        </h2>
                        <p class="text-gray-600">Đừng bỏ lỡ những cơ hội cuối cùng - Đấu giá ngay!</p>
                    </div>
                @else
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 rounded-xl shadow-lg">
                        <i class="fas fa-gavel text-white text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
                            Danh Sách Sản Phẩm Đấu Giá Của Bạn
                        </h2>
                        <p class="text-gray-600">Khám phá và tham gia đấu giá các sản phẩm độc đáo</p>
                    </div>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif
        <!-- Search Form -->
        <div class="bg-white rounded-xl shadow-2xl p-6 mb-8 animate-scale-in hover-lift border border-gray-100">
            <form method="GET"
                  action="@if(request()->routeIs('products.featured')){{ route('products.featured') }}@elseif(request()->routeIs('products.active')){{ route('products.active') }}@elseif(request()->routeIs('products.endingSoon')){{ route('products.endingSoon') }}@else{{ route('products.index') }}@endif"
                  class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
                <!-- Search Input -->
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                    <input type="text"
                           name="q"
                           value="{{ request('q') }}"
                           placeholder="Tìm kiếm sản phẩm..."
                           class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-700 placeholder-gray-400">
                </div>

                <!-- Category Dropdown -->
                <div class="sm:w-56 relative">
                    <select name="category"
                            class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-700 appearance-none bg-white cursor-pointer">
                        <option value="">Tất cả danh mục</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" @if(request('category') == $cat) selected @endif>{{ $cat }}</option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>

                <!-- Search Button -->
                <button type="submit"
                        class="px-8 py-3.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center gap-2 whitespace-nowrap">
                    <i class="fas fa-search"></i>
                    <span>Tìm Kiếm</span>
                </button>
            </form>
        </div>

        <!-- Action Buttons -->
        <div class="mb-6 flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
            @auth
                <a href="{{ url('/products/create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class="fas fa-plus mr-2"></i>Thêm Sản Phẩm Mới
                </a>
            @endauth
            <div class="text-sm text-gray-600">
                Tìm thấy <strong>{{ $products->count() }}</strong> sản phẩm
            </div>
        </div>

        @php
            $favoriteIds = [];
            if(Auth::check()) {
                $favoriteIds = \App\Models\Favorite::where('user_id', Auth::id())->pluck('product_id')->toArray();
            }
        @endphp

        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $index => $product)
                    <div class="product-card card-hover bg-white rounded-xl shadow-md overflow-hidden fade-in-on-scroll" data-delay="{{ $index * 0.1 }}" style="opacity: 0;">
                        <!-- Product Image -->
                        <div class="relative h-48 overflow-hidden bg-gray-200 img-zoom">
                    @if($product->images && $product->images->count())
                                <img src="{{ asset('storage/' . $product->images->first()->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fas fa-image text-4xl"></i>
                                </div>
                            @endif

                            <!-- Favorite Button -->
                            @auth
                                <div class="absolute top-2 right-2">
                                    @if(in_array($product->id, $favoriteIds))
                                        <form action="{{ route('favorite.destroy') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="bg-white p-2 rounded-full shadow-lg hover:bg-red-50 transition-colors">
                                                <i class="fas fa-heart text-red-500"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('favorite.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="bg-white p-2 rounded-full shadow-lg hover:bg-red-50 transition-colors">
                                                <i class="far fa-heart text-gray-600"></i>
                                            </button>
                                        </form>
                    @endif
                                </div>
                            @endauth

                            <!-- Status Badge -->
                            <div class="absolute bottom-2 left-2">
                                @if($product->status == 'active' && now() >= $product->start_time && now() <= $product->end_time)
                                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-fire mr-1"></i>Đang đấu giá
                                    </span>
                        @elseif($product->status == 'active' && now() < $product->start_time)
                                    <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                        Sắp bắt đầu
                                    </span>
                                @elseif($product->status == 'pending')
                                    <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                        Chờ duyệt
                                    </span>
                        @elseif($product->status == 'sold')
                                    <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                        Đã bán
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 hover:text-blue-600 transition-colors">
                                {{ $product->name }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>

                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">Giá khởi điểm:</span>
                                    <span class="text-sm font-bold text-blue-600">{{ number_format($product->starting_price, 0, ',', '.') }} ₫</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">Bước giá:</span>
                                    <span class="text-sm font-semibold text-gray-700">{{ number_format($product->bid_step, 0, ',', '.') }} ₫</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">Kết thúc:</span>
                                    <span class="text-xs font-semibold text-gray-700">{{ date('d/m/Y H:i', strtotime($product->end_time)) }}</span>
                                </div>
                            </div>

                            <a href="{{ url('/products/' . $product->id) }}"
                               class="block w-full text-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                <i class="fas fa-eye mr-2"></i>Xem Chi Tiết
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
                        @else
            <div class="bg-white rounded-xl shadow-xl p-12 text-center">
                <div class="text-6xl mb-4">
                    @if(request()->routeIs('products.featured'))
                        ⏰
                    @elseif(request()->routeIs('products.active'))
                        🔥
                    @elseif(request()->routeIs('products.endingSoon'))
                        ⏳
                    @else
                        📦
                    @endif
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">
                    @if(request()->routeIs('products.featured'))
                        Chưa có sản phẩm sắp diễn ra
                    @elseif(request()->routeIs('products.active'))
                        Hiện không có sản phẩm đang đấu giá
                    @elseif(request()->routeIs('products.endingSoon'))
                        Không có sản phẩm sắp kết thúc
                    @else
                        Không tìm thấy sản phẩm nào
                    @endif
                </h3>
                <p class="text-gray-500 mb-6">
                    @if(request()->routeIs('products.featured'))
                        Các sản phẩm sắp diễn ra sẽ hiển thị ở đây
                    @elseif(request()->routeIs('products.active'))
                        Các sản phẩm đang đấu giá sẽ hiển thị ở đây
                    @elseif(request()->routeIs('products.endingSoon'))
                        Các sản phẩm sắp kết thúc sẽ hiển thị ở đây
                    @else
                        Hãy thử tìm kiếm với từ khóa khác hoặc danh mục khác
                    @endif
                </p>
                <div class="flex gap-4 justify-center">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-500 text-white font-semibold rounded-lg hover:bg-gray-600 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class="fas fa-list mr-2"></i>Xem Tất Cả
                    </a>
                    @auth
                        <a href="{{ url('/products/create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class="fas fa-plus mr-2"></i>Đăng Sản Phẩm
                        </a>
                    @endauth
                </div>
            </div>
                        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} Website Đấu Giá. Đã đăng ký bản quyền.</p>
                </div>
        </div>
    </footer>

    @auth
        @include('components.chat-widget')
    @endauth

    <script>
        // Fade in animation for product cards
        document.querySelectorAll('.fade-in-on-scroll').forEach(card => {
            const delay = parseFloat(card.getAttribute('data-delay')) || 0;
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.animation = 'fadeInUp 0.6s ease-out forwards';
            }, delay * 1000);
        });

        // Scroll Reveal Animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in-on-scroll').forEach(el => {
            observer.observe(el);
        });

        // Navbar scroll effect
        let lastScroll = 0;
        const navbar = document.querySelector('nav');

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;

            if (currentScroll > 100) {
                navbar.classList.add('navbar-scroll');
            } else {
                navbar.classList.remove('navbar-scroll');
            }

            lastScroll = currentScroll;
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
