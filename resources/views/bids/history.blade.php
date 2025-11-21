<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử đặt giá</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('components.header-logo')
    <div class="max-w-4xl mx-auto mt-8 px-4">
        <h2 class="text-2xl font-bold mb-6">Lịch sử đặt giá của bạn</h2>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Sản phẩm</th>
                        <th class="py-2 px-4 border-b">Số tiền</th>
                        <th class="py-2 px-4 border-b">Thời gian</th>
                        <th class="py-2 px-4 border-b">Trạng thái phiên</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bids as $bid)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $bid->product->name }}</td>
                            <td class="py-2 px-4 border-b">{{ number_format($bid->amount, 0, ',', '.') }} VNĐ</td>
                            <td class="py-2 px-4 border-b">{{ date('d/m/Y H:i', strtotime($bid->created_at)) }}</td>
                            <td class="py-2 px-4 border-b">{{ now() < $bid->product->end_time ? 'Đang diễn ra' : 'Đã kết thúc' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-2 px-4 text-center">Bạn chưa tham gia đặt giá phiên nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>