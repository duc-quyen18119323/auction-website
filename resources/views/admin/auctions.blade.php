<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý phiên đấu giá</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('components.header-logo')
    <div class="max-w-6xl mx-auto mt-8 px-4">
        <h2 class="text-2xl font-bold mb-6">Quản lý phiên đấu giá</h2>
        <div class="mb-6">
            <form method="GET" action="">
                <label class="mr-2 font-semibold">Lọc theo trạng thái:</label>
                <select name="status" onchange="this.form.submit()" class="border rounded px-2 py-1">
                    <option value="">Tất cả</option>
                    <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>Đang diễn ra</option>
                    <option value="ended" {{ request('status')=='ended' ? 'selected' : '' }}>Đã kết thúc</option>
                </select>
            </form>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Tên sản phẩm</th>
                        <th class="py-2 px-4 border-b">Người tạo</th>
                        <th class="py-2 px-4 border-b">Giá khởi điểm</th>
                        <th class="py-2 px-4 border-b">Kết thúc</th>
                        <th class="py-2 px-4 border-b">Trạng thái</th>
                        <th class="py-2 px-4 border-b">Số lượt đặt giá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($auctions as $auction)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $auction->id }}</td>
                            <td class="py-2 px-4 border-b">{{ $auction->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $auction->user->name ?? '---' }}</td>
                            <td class="py-2 px-4 border-b">{{ number_format($auction->starting_price, 0, ',', '.') }} VNĐ</td>
                            <td class="py-2 px-4 border-b">{{ date('d/m/Y H:i', strtotime($auction->end_time)) }}</td>
                            <td class="py-2 px-4 border-b">
                                {{ now() < $auction->end_time ? 'Đang diễn ra' : 'Đã kết thúc' }}
                            </td>
                            <td class="py-2 px-4 border-b">{{ $auction->bids_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>