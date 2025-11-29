<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - Website Đấu Giá</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth-custom.css') }}">

</head>

<body class="auth-page">
    @include('components.header-logo')

    <div class="min-h-screen flex items-center justify-center">
        <div class="auth-card max-w-md w-full">
            <div class="auth-card-inner p-8">

                <h2 class="auth-title">Đăng Nhập</h2>
                <div class="auth-title-underline"></div>

                @if(session('success'))
                    <div class="auth-alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="auth-alert-error mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" autocomplete="off">
                    @csrf

                    <!-- Chống autofill -->
                    <input type="text" name="fake_user" tabindex="-1" autocomplete="username"
                           style="position:absolute; left:-9999px; opacity:0;">
                    <input type="password" name="fake_pass" tabindex="-1" autocomplete="current-password"
                           style="position:absolute; left:-9999px; opacity:0;">

                    <div class="auth-field">
                        <label class="auth-label" for="username">Tên tài khoản</label>
                        <div class="auth-input-wrapper">
                            <span class="auth-input-icon">@</span>
                            <input id="username" type="text" name="username" required
                                   class="auth-input has-icon"
                                   placeholder="Nhập tên đăng nhập">
                        </div>
                    </div>

                    <div class="auth-field">
                        <label class="auth-label" for="password">Mật khẩu</label>
                        <div class="auth-input-wrapper">
                            <span class="auth-input-icon">*</span>
                            <input id="password" type="password" name="password" required
                                   autocomplete="new-password"
                                   class="auth-input has-icon @error('password') auth-input-error @enderror"
                                   placeholder="Nhập mật khẩu">
                        </div>
                    </div>

                    <div class="auth-form-extra">
                        <label class="auth-remember">
                            <input type="checkbox" id="remember" name="remember">
                            <span>Ghi nhớ đăng nhập</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="auth-link">Quên mật khẩu?</a>
                    </div>

                    <button type="submit" class="auth-btn-primary">Đăng Nhập</button>

                    <p class="auth-bottom-text">
                        Chưa có tài khoản?
                        <a href="{{ route('register') }}" class="auth-link">Đăng ký ngay</a>
                    </p>

                </form>
            </div>
        </div>
    </div>
</body>
</html>
