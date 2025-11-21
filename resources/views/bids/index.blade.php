@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Lịch sử đấu giá của bạn</h2>
    @if(count($bids) > 0)
        <table class="min-w-full table-auto border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">Sản phẩm</th>
                    <th class="px-4 py-2 border">Số tiền đấu giá</th>
                    <th class="px-4 py-2 border">Thời gian</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bids as $bid)
                    <tr>
                        <td class="border px-4 py-2">
                            @if($bid->product)
                                <a href="{{ url('/products/' . $bid->product->id) }}" class="text-blue-500 hover:underline">{{ $bid->product->name }}</a>
                            @else
                                <span class="text-gray-500">[Đã xóa]</span>
                            @endif
                        </td>
                        <td class="border px-4 py-2">{{ number_format($bid->amount, 0, ',', '.') }} VNĐ</td>
                        <td class="border px-4 py-2">{{ $bid->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Bạn chưa tham gia đấu giá sản phẩm nào.</p>
    @endif
</div>
@endsection
