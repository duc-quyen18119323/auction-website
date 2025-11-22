<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Đấu Giá - Trang Chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('storage/products/logoweb.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <style>
        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .gradient-overlay {
            background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.7) 100%);
        }
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-size: 200% 200%;
            animation: gradientShift 5s ease infinite;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <!-- Hero Section -->
    <section class="hero-gradient text-white py-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center animate-fade-in-up">
                <h1 class="text-4xl md:text-5xl font-bold mb-4 animate-fade-in-down">
                    <span class="inline-block animate-float">🎯</span> Chào Mừng Đến Với Nền Tảng Đấu Giá
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100 animate-fade-in-up animate-delay-200">Khám phá những sản phẩm độc đáo và đặt giá theo thời gian thực</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up animate-delay-300">
                    <a href="{{ route('products.index') }}" class="btn-ripple px-8 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition-all duration-200 shadow-lg hover:shadow-xl hover-lift">
                        <i class="fas fa-gavel mr-2"></i>Xem Sản Phẩm
                    </a>
                    @auth
                    <a href="{{ route('products.create') }}" class="btn-ripple px-8 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-400 transition-all duration-200 shadow-lg hover:shadow-xl border-2 border-white hover-lift">
                        <i class="fas fa-plus mr-2"></i>Đăng Sản Phẩm
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8">
        <div class="bg-white rounded-xl shadow-lg p-6 animate-scale-in hover-lift">
            <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm sản phẩm..."
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
                <div class="md:w-64">
                    <select name="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tất cả danh mục</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" @if(request('category') == $cat) selected @endif>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class="fas fa-search mr-2"></i>Tìm Kiếm
                </button>
            </form>
        </div>
    </section>

    <!-- Quick Links -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
        <div class="grid md:grid-cols-3 gap-6">
            <a href="{{ route('products.featured', ['category' => request('category')]) }}" class="card-hover bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500 fade-in-on-scroll">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <i class="fas fa-clock text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold ml-4">Sắp Diễn Ra</h3>
                </div>
                <p class="text-gray-600 mb-4">Xem các sản phẩm đấu giá sắp diễn ra</p>
                <span class="text-blue-600 font-semibold hover:underline">Xem ngay <i class="fas fa-arrow-right ml-1"></i></span>
            </a>

            <a href="{{ route('products.active', ['category' => request('category')]) }}" class="card-hover bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500 fade-in-on-scroll animate-delay-200">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 p-3 rounded-lg">
                        <i class="fas fa-fire text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold ml-4">Đang Đấu Giá</h3>
                </div>
                <p class="text-gray-600 mb-4">Tham gia phiên đấu giá đang diễn ra</p>
                <span class="text-green-600 font-semibold hover:underline">Xem ngay <i class="fas fa-arrow-right ml-1"></i></span>
            </a>

            <a href="{{ route('products.endingSoon', ['category' => request('category')]) }}" class="card-hover bg-white p-6 rounded-xl shadow-md border-l-4 border-yellow-500 fade-in-on-scroll animate-delay-400">
                <div class="flex items-center mb-4">
                    <div class="bg-yellow-100 p-3 rounded-lg">
                        <i class="fas fa-hourglass-half text-yellow-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold ml-4">Sắp Kết Thúc</h3>
                </div>
                <p class="text-gray-600 mb-4">Đừng bỏ lỡ những cơ hội cuối cùng</p>
                <span class="text-yellow-600 font-semibold hover:underline">Xem ngay <i class="fas fa-arrow-right ml-1"></i></span>
            </a>
        </div>
    </section>

    <!-- Products Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 mb-16">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-gavel mr-2 text-blue-600"></i>Danh Sách Sản Phẩm Đấu Giá
            </h2>
            @auth
                <a href="{{ url('/products/create') }}" class="hidden md:inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class="fas fa-plus mr-2"></i>Thêm Sản Phẩm
                </a>
            @endauth
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @php
            $favoriteIds = [];
            if(Auth::check()) {
                $favoriteIds = \App\Models\Favorite::where('user_id', Auth::id())->pluck('product_id')->toArray();
            }
        @endphp

        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $index => $product)
                    <div class="product-card card-hover bg-white rounded-xl shadow-md overflow-hidden fade-in-on-scroll" style="animation-delay: {{ $index * 0.1 }}s">
                        <!-- Product Image -->
                        <div class="relative h-48 overflow-hidden bg-gray-200 img-zoom">
                            @if($product->images->isNotEmpty())
                                <img src="{{ Storage::url($product->images->first()->image) }}"
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
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Chưa có sản phẩm đấu giá nào</h3>
                <p class="text-gray-500 mb-6">Hãy là người đầu tiên đăng sản phẩm!</p>
                @auth
                    <a href="{{ url('/products/create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class="fas fa-plus mr-2"></i>Đăng Sản Phẩm Ngay
                    </a>
                @endauth
            </div>
        @endif
    </section>

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

        // Add loading animation to buttons
        document.querySelectorAll('.btn-ripple').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                ripple.classList.add('ripple-effect');
                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    </script>
</body>
</html>
