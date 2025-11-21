@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-8 px-4">
    <h2 class="text-2xl font-bold mb-6">Sản phẩm đã lưu (Yêu thích)</h2>
    <div class="grid md:grid-cols-2 gap-6">
        @forelse($favorites as $favorite)
            @if($favorite->product)
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <img src="{{ asset('storage/' . $favorite->product->image) }}" alt="{{ $favorite->product->name }}" class="w-full h-48 object-cover rounded mb-4">
                <h3 class="text-xl font-semibold mb-2">{{ $favorite->product->name }}</h3>
                <p class="text-gray-600 mb-2">{{ $favorite->product->description }}</p>
                <p class="mb-2">Giá khởi điểm: <strong>{{ number_format($favorite->product->starting_price, 0, ',', '.') }} VNĐ</strong></p>
                <p class="mb-2">Bước giá: <strong>{{ number_format($favorite->product->bid_step, 0, ',', '.') }} VNĐ</strong></p>
                <p class="mb-2">Bắt đầu: <strong>{{ date('d/m/Y H:i', strtotime($favorite->product->start_time)) }}</strong></p>
                <p class="mb-2">Kết thúc: <strong>{{ date('d/m/Y H:i', strtotime($favorite->product->end_time)) }}</strong></p>
                <a href="{{ url('/products/' . $favorite->product->id) }}" class="mt-2 inline-block bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded">Xem chi tiết</a>
            </div>
            @endif
        @empty
            <p>Bạn chưa lưu sản phẩm nào.</p>
        @endforelse
    </div>
</div>
@endsection
