@extends('admin.dashboard')

@section('title', 'Quản lý sản phẩm đấu giá')
@section('page_title', 'Quản lý sản phẩm đấu giá')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/admin-products.css') }}">

    <div class="products-page">

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

                            <td>{{ $product->name }}</td>

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