@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Chỉnh sửa sản phẩm</h2>
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if($product->bids()->count() === 0 && now() > $product->end_time)
        <form action="{{ route('products.extend', $product->id) }}" method="POST" class="mb-6">
            @csrf
            <label for="new_end_time" class="block mb-2 font-bold">Gia hạn thời gian đấu giá đến:</label>
            <input type="datetime-local" name="new_end_time" required class="border rounded px-3 py-2 mb-2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Gia hạn</button>
        </form>
    @endif
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Tên sản phẩm</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Mô tả sản phẩm</label>
            <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Giá khởi điểm</label>
            <input type="number" name="starting_price" value="{{ old('starting_price', $product->starting_price) }}" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Bước giá</label>
            <input type="number" name="bid_step" value="{{ old('bid_step', $product->bid_step) }}" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Ảnh sản phẩm hiện tại</label>
            <div class="flex gap-2 mb-2">
                @foreach($product->images as $img)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $img->image) }}" alt="Ảnh sản phẩm" class="w-24 h-24 object-cover rounded">
                        <form action="{{ route('product-images.destroy', $img->id) }}" method="POST" class="absolute top-1 right-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-80 hover:opacity-100" title="Xoá ảnh">
                                &#10006;
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
            <input type="file" name="images[]" class="w-full border rounded px-3 py-2" multiple accept="image/*">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Cập nhật sản phẩm</button>
    </form>
</div>
@endsection