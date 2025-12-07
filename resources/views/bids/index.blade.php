<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đấu Giá Của Tôi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    @include('components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-xl shadow-xl p-8">
            <h2 class="text-3xl font-bold mb-8 text-gray-900 flex items-center gap-3">
                <i class="fas fa-gavel text-blue-600"></i>
                Lịch Sử Đấu Giá Của Bạn
            </h2>
            @if(count($bids) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-100 to-gray-200">
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Sản
                                    phẩm</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Số
                                    tiền đấu giá</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                    Thời gian</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($bids as $index => $bid)
                                <tr class="hover:bg-blue-50 transition-all duration-300 fade-in-row"
                                    data-delay="{{ $index * 0.05 }}" style="opacity: 0;">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($bid->product)
                                            <a href="{{ url('/products/' . $bid->product->id) }}"
                                                class="text-blue-600 hover:text-blue-800 font-semibold hover:underline transition-colors">
                                                <i class="fas fa-box mr-2"></i>
                                                {{ \Illuminate\Support\Str::limit($bid->product->name, 30, '...') }}
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">
                                                <i class="fas fa-trash mr-2"></i>[Đã xóa]
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-lg font-bold text-green-600">
                                            {{ number_format($bid->amount, 0, ',', '.') }} VNĐ
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <i class="far fa-clock mr-2"></i>{{ $bid->created_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">🎯</div>
                    <p class="text-xl text-gray-500 font-medium">Bạn chưa tham gia đấu giá sản phẩm nào.</p>
                    <p class="text-gray-400 mt-2">Hãy bắt đầu đấu giá ngay!</p>
                    <a href="{{ route('products.index') }}"
                        class="inline-block mt-6 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class="fas fa-search mr-2"></i>Xem Sản Phẩm
                    </a>
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