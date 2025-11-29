<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký - Website Đấu Giá</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth-custom.css') }}">

</head>

<body class="auth-page">
    @include('components.header-logo')

    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="auth-card max-w-md w-full">
            <div class="auth-card-inner p-8">

                <h2 class="auth-title">Đăng Ký Tài Khoản</h2>
                <p class="auth-subtitle">Tạo tài khoản để tham gia đấu giá các sản phẩm yêu thích.</p>
                <div class="auth-title-underline"></div>

                @if ($errors->any())
                    <div class="auth-alert-error mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="auth-field">
                        <label class="auth-label" for="username">Tên tài khoản</label>
                        <div class="auth-input-wrapper">
                            <span class="auth-input-icon">@</span>
                            <input id="username" type="text" name="username"
                                   value="{{ old('username') }}" required
                                   class="auth-input has-icon"
                                   placeholder="Nhập tên đăng nhập">
                        </div>
                    </div>

                    <div class="auth-field">
                        <label class="auth-label" for="email">Email</label>
                        <div class="auth-input-wrapper">
                            <span class="auth-input-icon">&#9993;</span>
                            <input id="email" type="email" name="email"
                                   value="{{ old('email') }}" required
                                   class="auth-input has-icon @error('email') auth-input-error @enderror"
                                   placeholder="Nhập email">
                        </div>
                    </div>

                    <div class="auth-field">
                        <label class="auth-label" for="phone">Số điện thoại</label>
                        <div class="auth-input-wrapper">
                            <span class="auth-input-icon">&#9742;</span>
                            <input id="phone" type="tel" name="phone"
                                   value="{{ old('phone') }}" required
                                   class="auth-input has-icon @error('phone') auth-input-error @enderror"
                                   placeholder="Nhập số điện thoại">
                        </div>
                    </div>

                    <div class="auth-field">
                        <label class="auth-label" for="password">Mật khẩu</label>
                        <div class="auth-input-wrapper">
                            <span class="auth-input-icon">*</span>
                            <input id="password" type="password" name="password" required
                                   class="auth-input has-icon @error('password') auth-input-error @enderror"
                                   placeholder="Tối thiểu 8 ký tự">
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-field">
                        <label class="auth-label" for="password_confirmation">Xác nhận mật khẩu</label>
                        <div class="auth-input-wrapper">
                            <span class="auth-input-icon">*</span>
                            <input id="password_confirmation" type="password"
                                   name="password_confirmation" required
                                   class="auth-input has-icon"
                                   placeholder="Nhập lại mật khẩu">
                        </div>
                    </div>

                    <button type="submit" class="auth-btn-primary mt-2">
                        Đăng Ký
                    </button>

                    <p class="auth-bottom-text">
                        Đã có tài khoản?
                        <a href="{{ route('login') }}" class="auth-link">Đăng nhập</a>
                    </p>

                </form>
            </div>
        </div>
    </div>
</body>
</html>
