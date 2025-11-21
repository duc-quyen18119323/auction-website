@extends('admin.dashboard')
@section('content')
<div class="bg-white rounded-lg shadow-lg p-8">
    <h2 class="text-3xl font-bold mb-4 text-blue-900">Quản lý phiên đấu giá</h2>
    
    <!-- Thống kê -->
    <div class="grid md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-100 p-4 rounded-lg shadow text-center">
            <div class="text-2xl font-bold text-blue-900">{{ $stats['total'] }}</div>
            <div class="text-gray-600">Tổng số phiên</div>
        </div>
        <div class="bg-purple-100 p-4 rounded-lg shadow text-center">
            <div class="text-2xl font-bold text-purple-900">{{ $stats['upcoming'] }}</div>
            <div class="text-gray-600">Sắp diễn ra</div>
        </div>
        <div class="bg-green-100 p-4 rounded-lg shadow text-center">
            <div class="text-2xl font-bold text-green-900">{{ $stats['active'] }}</div>
            <div class="text-gray-600">Đang diễn ra</div>
        </div>
        <div class="bg-orange-100 p-4 rounded-lg shadow text-center">
            <div class="text-2xl font-bold text-orange-900">{{ $stats['ending_soon'] }}</div>
            <div class="text-gray-600">Sắp kết thúc</div>
        </div>
    </div>

    <!-- Bộ lọc -->
    <div class="mb-4 flex gap-2">
        <a href="{{ route('admin.auctions') }}" class="px-4 py-2 rounded {{ $status == 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">Tất cả</a>
        <a href="{{ route('admin.auctions', ['status' => 'upcoming']) }}" class="px-4 py-2 rounded {{ $status == 'upcoming' ? 'bg-purple-600 text-white' : 'bg-gray-200' }}">Sắp diễn ra</a>
        <a href="{{ route('admin.auctions', ['status' => 'active']) }}" class="px-4 py-2 rounded {{ $status == 'active' ? 'bg-green-600 text-white' : 'bg-gray-200' }}">Đang diễn ra</a>
        <a href="{{ route('admin.auctions', ['status' => 'ending_soon']) }}" class="px-4 py-2 rounded {{ $status == 'ending_soon' ? 'bg-orange-600 text-white' : 'bg-gray-200' }}">Sắp kết thúc</a>
    </div>

    <!-- Danh sách phiên đấu giá -->
    <table class="min-w-full bg-white border">
        <thead>
            <tr class="bg-gray-200">
                <th class="py-2 px-4 border">ID</th>
                <th class="py-2 px-4 border">Sản phẩm</th>
                <th class="py-2 px-4 border">Người bán</th>
                <th class="py-2 px-4 border">Giá khởi điểm</th>
                <th class="py-2 px-4 border">Giá hiện tại</th>
                <th class="py-2 px-4 border">Số lượt đấu</th>
                <th class="py-2 px-4 border">Thời gian kết thúc</th>
                <th class="py-2 px-4 border">Trạng thái</th>
                <th class="py-2 px-4 border">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td class="py-2 px-4 border">{{ $product->id }}</td>
                    <td class="py-2 px-4 border">{{ $product->name }}</td>
                    <td class="py-2 px-4 border">{{ $product->user->username ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border">{{ number_format($product->starting_price) }} VNĐ</td>
                    <td class="py-2 px-4 border">{{ number_format($product->bids->max('amount') ?: $product->starting_price) }} VNĐ</td>
                    <td class="py-2 px-4 border">{{ $product->bids->count() }}</td>
                    <td class="py-2 px-4 border">{{ $product->end_time->format('d/m/Y H:i') }}</td>
                    <td class="py-2 px-4 border">
                        @if($product->end_time > now())
                            <span class="text-green-600 font-bold">Đang diễn ra</span>
                        @else
                            <span class="text-red-600 font-bold">Đã kết thúc</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 border">
                        <a href="{{ route('admin.auctions.show', $product->id) }}" class="text-blue-600 hover:underline">Xem chi tiết</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Phân trang -->
    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
