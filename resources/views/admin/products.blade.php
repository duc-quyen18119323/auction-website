@extends('admin.dashboard')

@section('title', 'Quản lý sản phẩm đấu giá')
@section('page_title', 'Quản lý sản phẩm đấu giá')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/admin-products.css') }}">

    <div class="products-page">
        {{-- Bộ lọc --}}
    <div class="admin-filter-row mb-4">
        <form method="GET" action="" class="admin-filter-bar">
            <span class="admin-filter-label">Lọc theo trạng thái:</span>

            <select name="status" onchange="this.form.submit()" class="admin-filter-select">
                <option value="">Tất cả</option>
                <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>Đang diễn ra</option>
                <option value="ended"  {{ request('status')=='ended'  ? 'selected' : '' }}>Đã kết thúc</option>
                <option value="pending"  {{ request('status')=='pending'  ? 'selected' : '' }}>Chờ duyệt</option>
            </select>
        </form>
    </div>


        @if(session('success'))
            <div class="products-alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="products-card">

            <table class="products-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Người tạo</th>
                        <th>Giá khởi điểm</th>
                        <th>Bước giá</th>
                        <th>Kết thúc</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>

                            <td>
                                <a href="{{ route('admin.auctions.show', $product->id) }}"
                                    class="text-blue-600 hover:underline">
                                    {{ $product->name }}
                                </a>
                            </td>


                            <td>{{ $product->user->username ?? '---' }}</td>

                            <td>{{ number_format($product->starting_price, 0, ',', '.') }} VNĐ</td>

                            <td>{{ number_format($product->bid_step, 0, ',', '.') }} VNĐ</td>

                            <td>{{ date('d/m/Y H:i', strtotime($product->end_time)) }}</td>

                            <td>
                                @if($product->status == 'pending')
                                    <span class="status-badge status-pending">Chờ duyệt</span>
                                @elseif($product->status == 'active')
                                    <span class="status-badge status-active">Đang hiển thị</span>
                                @elseif($product->status == 'sold')
                                    <span class="status-badge status-sold">Đã bán</span>
                                @else
                                    <span class="status-badge status-sold">Không xác định</span>
                                @endif
                            </td>

                            <td>
                                <form action="{{ url('/admin/products/' . $product->id . '/approve') }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @if($product->status == 'pending')
                                        {{-- Nút duyệt khi còn chờ duyệt --}}
                                        <button type="submit" class="btn-action btn-approve">
                                            Duyệt
                                        </button>
                                    @else
                                        {{-- Đã duyệt / đang hiển thị / đã bán --}}
                                        <span class="approved-text">Đã duyệt</span>
                                    @endif

                                </form>

                                <form action="{{ url('/admin/products/' . $product->id . '/delete') }}" method="POST"
                                    class="inline ml-2" onsubmit="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?');">
                                    @csrf
                                    <button type="submit" class="btn-action btn-delete">
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

@endsection