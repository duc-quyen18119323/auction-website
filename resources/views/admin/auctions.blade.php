@extends('admin.dashboard')

@section('title', 'Quản lý phiên đấu giá')
@section('page_title', 'Quản lý phiên đấu giá')

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
            </select>
        </form>
    </div>

    {{-- Bảng --}}
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Người tạo</th>
                    <th>Giá khởi điểm</th>
                    <th>Kết thúc</th>
                    <th>Trạng thái</th>
                    <th>Số lượt đặt giá</th>
                </tr>
            </thead>

            <tbody>
                @foreach($auctions as $auction)
                    <tr>
                        <td>{{ $auction->id }}</td>

                        <td>{{ $auction->name }}</td>

                        {{-- Username người tạo --}}
                        <td>{{ $auction->user->username ?? '---' }}</td>

                        <td>{{ number_format($auction->starting_price, 0, ',', '.') }} VNĐ</td>

                        <td>{{ date('d/m/Y H:i', strtotime($auction->end_time)) }}</td>

                        <td>
                            @if(now() < $auction->end_time)
                                <span class="status-badge status-running">Đang diễn ra</span>
                            @else
                                <span class="status-badge status-ended">Đã kết thúc</span>
                            @endif
                        </td>

                        <td>{{ $auction->bids_count }}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>

@endsection
