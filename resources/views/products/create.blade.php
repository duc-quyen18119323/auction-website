<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm Đấu Giá</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('components.header-logo')
    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
            <h2 class="text-2xl font-bold text-center mb-8">Thêm Sản Phẩm Đấu Giá</h2>
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Tên sản phẩm</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Ảnh sản phẩm (tối đa 6 ảnh)</label>
                    <input type="file" name="images[]" class="w-full border rounded px-3 py-2" multiple accept="image/*">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Video sản phẩm (tùy chọn)</label>
                    <input type="file" name="video" class="w-full border rounded px-3 py-2" accept="video/*">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="category">Loại sản phẩm</label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" name="category" required>
                        <option value="">-- Chọn loại sản phẩm --</option>
                        <option value="do-thu-cong">Đồ thủ công</option>
                        <option value="do-cong-nghe">Đồ công nghệ</option>
                        <option value="do-gia-dung">Đồ gia dụng</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Mô tả</label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" required>{{ old('description') }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="starting_price">Giá khởi điểm</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="starting_price" type="number" step="0.01" name="starting_price" value="{{ old('starting_price') }}" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="bid_step">Bước giá</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="bid_step" type="number" step="0.01" name="bid_step" value="{{ old('bid_step') }}" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="start_time">Thời gian bắt đầu</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="start_time" type="datetime-local" name="start_time" value="{{ old('start_time') }}" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Chế độ bảo hành</label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center">
                            <input type="radio" name="warranty" value="co" class="mr-2" required> Có
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="warranty" value="khong" class="mr-2"> Không
                        </label>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="end_time">Thời gian kết thúc</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="end_time" type="datetime-local" name="end_time" value="{{ old('end_time') }}" required>
                </div>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full" type="submit">Thêm sản phẩm</button>
            </form>
        </div>
    </div>
</body>
</html>