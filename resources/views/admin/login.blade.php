<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Đăng nhập Quản trị</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100">
    @include('components.header-logo')
  <div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
      <h1 class="text-2xl font-bold text-center mb-8">Đăng nhập Quản trị</h1>

      {{-- Hiển thị lỗi --}}
      @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
          <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- Form đăng nhập admin --}}
      <form
        action="{{ route('admin.login.post') }}"
        {{-- nếu chưa đặt tên route thì dùng: action="{{ url('/admin/login') }}" --}}
        method="POST"
        autocomplete="off"
      >
        @csrf

        {{-- Input “mồi” để trình duyệt autofill vào đó thay vì input thật --}}
        <input type="text" name="fake_user" tabindex="-1" autocomplete="username"
               style="position:absolute;left:-9999px;top:-9999px;height:0;width:0;opacity:0;">
        <input type="password" name="fake_pass" tabindex="-1" autocomplete="current-password"
               style="position:absolute;left:-9999px;top:-9999px;height:0;width:0;opacity:0;">

        {{-- Username --}}
        <div class="mb-4">
          <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Tên đăng nhập</label>
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
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('username') border-red-500 @enderror"
          >
        </div>

        {{-- Mật khẩu --}}
        <div class="mb-6">
          <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu</label>
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
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror"
          >
        </div>

        <button
          type="submit"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
        >
          Đăng nhập
        </button>
      </form>
    </div>
  </div>
</body>
</html>
