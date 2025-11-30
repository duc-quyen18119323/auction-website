<nav class="bg-white shadow-md sticky top-0 z-50 transition-all duration-300 animate-fade-in-down">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" class="flex items-center">
                    <img src="{{ asset('storage/products/logoweb.png') }}" alt="Logo"
                        class="h-16 w-auto hover:opacity-80 transition-opacity">
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="/"
                    class="px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium hover-scale {{ request()->is('/') ? 'text-blue-600 bg-blue-50' : '' }}">
                    Trang Chủ
                </a>
                <a href="{{ route('my-products.index') }}"
                    class="px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium hover-scale {{ request()->is('my-products*') ? 'text-blue-600 bg-blue-50' : '' }}">
                    Sản Phẩm
                </a>
                @auth
                    <a href="{{ route('bids.index') }}"
                        class="px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium hover-scale {{ request()->is('bids*') ? 'text-blue-600 bg-blue-50' : '' }}">
                        Đấu Giá Của Tôi
                    </a>
                    <a href="{{ route('transactions.index') }}"
                        class="px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium hover-scale {{ request()->is('transactions*') ? 'text-blue-600 bg-blue-50' : '' }}">
                        Giao Dịch
                    </a>
                    <a href="{{ route('favorites.index') }}"
                        class="px-4 py-2 text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200 font-medium hover-scale {{ request()->is('favorites*') ? 'text-red-600 bg-red-50' : '' }}">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                            Yêu Thích
                        </span>
                    </a>
                @endauth
            </div>

            <!-- User Menu -->
            <div class="flex items-center space-x-3">
                @auth
                    <a href="{{ route('products.create') }}"
                        class="btn-ripple hidden md:inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg hover-lift">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Đăng Sản Phẩm
                    </a>

                    <!-- User Dropdown (click) -->
                    <div class="relative" id="user-menu-container">
                        <button id="user-menu-btn"
                            class="flex items-center space-x-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-all duration-200 font-medium hover-scale">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="hidden md:inline text-gray-700">{{ Auth::user()->username }}</span>
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>

                        <div id="user-menu"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg transition-all duration-200 z-50 border">
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        Hồ Sơ
                                    </span>
                                </a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                                </path>
                                            </svg>
                                            Đăng Xuất
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200">
                        Đăng Nhập
                    </a>
                    <a href="{{ route('register') }}"
                        class="btn-ripple px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg hover-lift">
                        Đăng Ký
                    </a>
                @endauth

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <div class="flex flex-col space-y-1">
                <a href="/"
                    class="px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-lg {{ request()->is('/') ? 'bg-blue-50 text-blue-600' : '' }}">
                    Trang Chủ
                </a>
                <a href="{{ route('products.index') }}"
                    class="px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-lg {{ request()->is('products*') && !request()->is('products/create*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    Sản Phẩm
                </a>
                @auth
                    <a href="{{ route('bids.index') }}" class="px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-lg">
                        Đấu Giá Của Tôi
                    </a>
                    <a href="{{ route('transactions.index') }}" class="px-4 py-2 text-gray-700 hover:bg-blue-50 rounded-lg">
                        Giao Dịch
                    </a>
                    <a href="{{ route('favorites.index') }}" class="px-4 py-2 text-gray-700 hover:bg-red-50 rounded-lg">
                        Yêu Thích
                    </a>
                    <a href="{{ route('products.create') }}"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg font-semibold">
                        Đăng Sản Phẩm
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    // Mobile menu
    document.getElementById('mobile-menu-button')?.addEventListener('click', function () {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });

    // User dropdown (click)
    document.addEventListener('DOMContentLoaded', function () {
        const userMenuBtn = document.getElementById('user-menu-btn');
        const userMenu = document.getElementById('user-menu');

        if (userMenuBtn && userMenu) {
            userMenuBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                userMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', function (e) {
                if (!e.target.closest('#user-menu-container')) {
                    userMenu.classList.add('hidden');
                }
            });
        }
    });
</script>