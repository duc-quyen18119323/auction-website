<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm đấu giá</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('components.header-logo')
    <div class="max-w-5xl mx-auto mt-8 px-4">
        <h2 class="text-2xl font-bold mb-6">Quản lý sản phẩm đấu giá</h2>
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Tên</th>
                        <th class="py-2 px-4 border-b">Người tạo</th>
                        <th class="py-2 px-4 border-b">Giá khởi điểm</th>
                        <th class="py-2 px-4 border-b">Bước giá</th>
                        <th class="py-2 px-4 border-b">Kết thúc</th>
                        <th class="py-2 px-4 border-b">Trạng thái</th>
                        <th class="py-2 px-4 border-b">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $product->id }}</td>
                            <td class="py-2 px-4 border-b">{{ $product->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $product->user->name ?? '---' }}</td>
                            <td class="py-2 px-4 border-b">{{ number_format($product->starting_price, 0, ',', '.') }} VNĐ</td>
                            <td class="py-2 px-4 border-b">{{ number_format($product->bid_step, 0, ',', '.') }} VNĐ</td>
                            <td class="py-2 px-4 border-b">{{ date('d/m/Y H:i', strtotime($product->end_time)) }}</td>
                            <td class="py-2 px-4 border-b">
                                @if($product->status == 'pending')
                                    <span class="text-yellow-600">Chờ duyệt</span>
                                @elseif($product->status == 'active')
                                    <span class="text-green-600">Đang hiển thị</span>
                                @elseif($product->status == 'sold')
                                    <span class="text-gray-600">Đã bán</span>
                                @else
                                    <span class="text-gray-600">Không xác định</span>
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b">
                                <form action="{{ url('/admin/products/' . $product->id . '/approve') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded bg-green-500 hover:bg-green-700 text-white" {{ $product->is_approved ? 'disabled' : '' }}>
                                        Duyệt
                                    </button>
                                </form>
                                <form action="{{ url('/admin/products/' . $product->id . '/delete') }}" method="POST" class="inline ml-2" onsubmit="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?');">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded bg-red-500 hover:bg-red-700 text-white">
                                        Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>