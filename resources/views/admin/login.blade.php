<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Đăng nhập Quản trị</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/admin-login.css') }}">
</head>
<body class="admin-login-page">
    @include('components.header-logo')

  <div class="admin-login-wrapper min-h-screen flex items-center justify-center">
    <div class="admin-login-card max-w-md w-full">
      <div class="admin-login-card-inner p-8">
        <h1 class="admin-login-title">Đăng nhập Quản trị</h1>
        <p class="admin-login-subtitle">Vui lòng đăng nhập để vào trang quản lý.</p>
        <div class="admin-login-underline"></div>

        {{-- Hiển thị lỗi --}}
        @if ($errors->any())
          <div class="admin-alert-error">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        {{-- Form đăng nhập admin --}}
        <form
          action="{{ route('admin.login.post') }}"
          method="POST"
          autocomplete="off"
        >
          @csrf

          {{-- Input mồi --}}
          <input type="text" name="fake_user" tabindex="-1" autocomplete="username"
                 style="position:absolute;left:-9999px;top:-9999px;height:0;width:0;opacity:0;">
          <input type="password" name="fake_pass" tabindex="-1" autocomplete="current-password"
                 style="position:absolute;left:-9999px;top:-9999px;height:0;width:0;opacity:0;">

          {{-- Username --}}
          <div class="admin-field">
            <label for="username" class="admin-label">Tên đăng nhập</label>
            <input
              id="username"
              type="text"
              name="username"
              value="{{ old('username') }}"
              required
              autocomplete="off"
              autocapitalize="none"
              autocorrect="off"
              spellcheck="false"
              placeholder="Nhập tên đăng nhập"
              class="admin-input @error('username') admin-input-error @enderror"
            >
          </div>

          {{-- Mật khẩu --}}
          <div class="admin-field">
            <label for="password" class="admin-label">Mật khẩu</label>
            <input
              id="password"
              type="password"
              name="password"
              required
              autocomplete="new-password"
              autocapitalize="none"
              autocorrect="off"
              spellcheck="false"
              placeholder="Nhập mật khẩu"
              class="admin-input @error('password') admin-input-error @enderror"
            >
          </div>

          <button
            type="submit"
            class="admin-login-btn mt-2"
          >
            Đăng nhập
          </button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
