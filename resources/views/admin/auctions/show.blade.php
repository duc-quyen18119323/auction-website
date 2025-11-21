@extends('admin.dashboard')
@section('content')
<div class="bg-white rounded-lg shadow-lg p-8">
    <h2 class="text-3xl font-bold mb-4 text-blue-900">Chi tiết phiên đấu giá</h2>
    
    <!-- Thông tin sản phẩm -->
    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <div>
            <h3 class="text-xl font-bold mb-2">Thông tin sản phẩm</h3>
            <p><strong>Tên sản phẩm:</strong> {{ $product->name }}</p>
            <p><strong>Mô tả:</strong> {{ $product->description }}</p>
            <p><strong>Danh mục:</strong> {{ $product->category }}</p>
            <p><strong>Người bán:</strong> {{ $product->user->username ?? 'N/A' }}</p>
            <p><strong>Giá khởi điểm:</strong> {{ number_format($product->starting_price) }} VNĐ</p>
            <p><strong>Giá hiện tại:</strong> {{ number_format($winner ? $winner->amount : $product->starting_price) }} VNĐ</p>
            <p><strong>Bước giá:</strong> {{ number_format($product->bid_step ?: 0) }} VNĐ</p>
            <p><strong>Thời gian bắt đầu:</strong> {{ $product->start_time->format('d/m/Y H:i') }}</p>
            <p><strong>Thời gian kết thúc:</strong> {{ $product->end_time->format('d/m/Y H:i') }}</p>
            <p><strong>Trạng thái:</strong> 
                @if($product->end_time > now())
                    <span class="text-green-600 font-bold">Đang diễn ra</span>
                @else
                    <span class="text-red-600 font-bold">Đã kết thúc</span>
                @endif
            </p>
        </div>
        <div>
            <h3 class="text-xl font-bold mb-2">Hình ảnh sản phẩm</h3>
            @if($product->images && $product->images->count())
                <div class="relative w-full h-64">
                    <div id="product-image-slider" class="w-full h-64 overflow-hidden relative">
                        @foreach($product->images as $img)
                            <img src="{{ asset('storage/' . $img->image) }}" alt="Ảnh sản phẩm" class="product-slide absolute top-0 left-0 w-full h-64 object-cover rounded transition-opacity duration-300" style="opacity:0;">
                        @endforeach
                    </div>
                    <button id="prev-slide" class="absolute left-0 top-1/2 -translate-y-1/2 bg-gray-200 hover:bg-gray-300 rounded-full px-3 py-1 text-2xl z-10">&#8249;</button>
                    <button id="next-slide" class="absolute right-0 top-1/2 -translate-y-1/2 bg-gray-200 hover:bg-gray-300 rounded-full px-3 py-1 text-2xl z-10">&#8250;</button>
                </div>
            @else
                <img src="https://via.placeholder.com/300x200?text=No+Image" alt="No Image" class="w-full h-48 object-cover rounded">
            @endif
        </div>
    </div>

    <!-- Người thắng cuộc -->
    @if($winner)
        <div class="bg-green-100 p-4 rounded-lg mb-6">
            <h3 class="text-xl font-bold mb-2 text-green-900">🏆 Người thắng cuộc</h3>
            <p><strong>Tên:</strong> {{ $winner->user->username ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $winner->user->email ?? 'N/A' }}</p>
            <p><strong>Giá đấu:</strong> {{ number_format($winner->amount) }} VNĐ</p>
            <p><strong>Thời gian đấu:</strong> {{ $winner->created_at->format('d/m/Y H:i') }}</p>
        </div>
    @endif

    <!-- Lịch sử đấu giá -->
    <div>
        <h3 class="text-xl font-bold mb-2">Lịch sử đấu giá ({{ $bids->count() }} lượt)</h3>
        @if($bids->count() > 0)
            <table class="min-w-full bg-white border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-4 border">STT</th>
                        <th class="py-2 px-4 border">Người đấu giá</th>
                        <th class="py-2 px-4 border">Email</th>
                        <th class="py-2 px-4 border">Giá đấu</th>
                        <th class="py-2 px-4 border">Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bids as $index => $bid)
                        <tr class="{{ $index == 0 ? 'bg-green-50' : '' }}">
                            <td class="py-2 px-4 border">{{ $index + 1 }}</td>
                            <td class="py-2 px-4 border">{{ $bid->user->username ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border">{{ $bid->user->email ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border">{{ number_format($bid->amount) }} VNĐ</td>
                            <td class="py-2 px-4 border">{{ $bid->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500">Chưa có lượt đấu giá nào.</p>
        @endif
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.auctions') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Quay lại danh sách</a>
    </div>
</div>
<script>
    const slides = document.querySelectorAll('.product-slide');
    let current = 0;
    function showSlide(idx) {
        slides.forEach((img, i) => img.style.opacity = i === idx ? '1' : '0');
    }
    if(slides.length > 0) {
        showSlide(current);
        document.getElementById('prev-slide').onclick = function() {
            current = (current - 1 + slides.length) % slides.length;
            showSlide(current);
        };
        document.getElementById('next-slide').onclick = function() {
            current = (current + 1) % slides.length;
            showSlide(current);
        };
    }
</script>
@endsection
