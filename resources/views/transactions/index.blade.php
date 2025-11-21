@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-8 px-4">
    <h2 class="text-2xl font-bold mb-6">Lịch sử giao dịch</h2>
    <table class="min-w-full table-auto border">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 border">Sản phẩm</th>
                <th class="px-4 py-2 border">Số tiền</th>
                <th class="px-4 py-2 border">Trạng thái</th>
                <th class="px-4 py-2 border">Thời gian</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
                <tr>
                    <td class="border px-4 py-2">
                        @if($transaction->product)
                            {{ $transaction->product->name }}
                        @else
                            [Sản phẩm đã xóa]
                        @endif
                    </td>
                    <td class="border px-4 py-2">{{ number_format($transaction->amount, 0, ',', '.') }} VNĐ</td>
                    <td class="border px-4 py-2">
                        @if($transaction->status === 'sold')
                            <span class="text-green-600 font-bold">Thành công</span>
                        @else
                            <span class="text-yellow-600 font-bold">Chưa bán</span>
                        @endif
                    </td>
                    <td class="border px-4 py-2">{{ date('d/m/Y H:i', strtotime($transaction->created_at)) }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center py-4">Chưa có giao dịch nào.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
