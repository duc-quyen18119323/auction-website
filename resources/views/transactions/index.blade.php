<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giao Dịch</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-xl shadow-xl p-8">
            <h2 class="text-3xl font-bold mb-8 text-gray-900 flex items-center gap-3">
                <i class="fas fa-receipt text-green-600"></i>
                Lịch Sử Giao Dịch
            </h2>
            @if(count($transactions) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-100 to-gray-200">
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Sản phẩm</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Số tiền</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Trạng thái</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Thời gian</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($transactions as $index => $transaction)
                                <tr
                                    class="hover:bg-blue-50 transition-all duration-300 fade-in-row cursor-pointer"
                                    data-delay="{{ $index * 0.05 }}"
                                    style="opacity: 0;"
                                    onclick="window.location='{{ route('transactions.show', $transaction->id) }}'"
                                >
                                <td class="px-6 py-4 whitespace-nowrap">
    @if($transaction->product)
        <div class="flex items-center">
            <i class="fas fa-box text-gray-400 mr-2"></i>
            <span class="font-medium text-gray-900">
                {{ \Illuminate\Support\Str::limit($transaction->product->name, 30, '...') }}
            </span>
        </div>
    @else
        <span class="text-gray-400 italic">
            <i class="fas fa-trash mr-2"></i>[Sản phẩm đã xóa]
        </span>
    @endif
</td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-lg font-bold text-blue-600">
                                            {{ number_format($transaction->amount, 0, ',', '.') }} VNĐ
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($transaction->status === 'sold')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-2"></i>Thành công
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-2"></i>Chưa bán
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <i class="far fa-clock mr-2"></i>
                                        {{ date('d/m/Y H:i', strtotime($transaction->created_at)) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">💳</div>
                    <p class="text-xl text-gray-500 font-medium">Chưa có giao dịch nào.</p>
                    <p class="text-gray-400 mt-2">Các giao dịch của bạn sẽ hiển thị ở đây.</p>
                </div>
            @endif
        </div>
    </div>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <script>
        document.querySelectorAll('.fade-in-row').forEach(row => {
            const delay = parseFloat(row.getAttribute('data-delay')) || 0;
            row.style.animation = `fadeInUp 0.4s ease-out forwards`;
            row.style.animationDelay = delay + 's';
        });
    </script>
</body>
</html>
