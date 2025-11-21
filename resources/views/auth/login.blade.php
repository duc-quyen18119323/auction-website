<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - Website Đấu Giá</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('components.header-logo')
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
            <h2 class="text-2xl font-bold text-center mb-8">Đăng Nhập</h2>
            
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
            @endif
            
            @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST" autocomplete="off">
                @csrf

                <!-- input mồi để trình duyệt autofill vào đây -->
                <input type="text" name="fake_user" tabindex="-1" autocomplete="username" 
                       style="position:absolute; left:-9999px; top:-9999px; height:0; width:0; opacity:0;">
                <input type="password" name="fake_pass" tabindex="-1" autocomplete="current-password" 
                       style="position:absolute; left:-9999px; top:-9999px; height:0; width:0; opacity:0;">

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Tên tài khoản</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" name="username" required>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Mật khẩu
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight 
                                 focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" 
                           id="password" type="password" name="password" required
                           autocomplete="new-password" autocapitalize="none" autocorrect="off" spellcheck="false"
                           placeholder="Nhập mật khẩu">
                </div>

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="mr-2">
                        <label for="remember" class="text-sm text-gray-600">Ghi nhớ đăng nhập</label>
                    </div>
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('password.request') }}">
                        Quên mật khẩu?
                    </a>
                </div>

                <div class="flex flex-col gap-4">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded 
                                   focus:outline-none focus:shadow-outline w-full" 
                            type="submit">
                        Đăng Nhập
                    </button>
                    <p class="text-center text-gray-600">
                        Chưa có tài khoản? 
                        <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-800">Đăng ký ngay</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
