<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Bid;

class ProductController extends Controller
{
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'starting_price' => 'required|numeric',
            'bid_step' => 'required|numeric',
            'warranty' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validated['start_time'] = \Carbon\Carbon::parse($request->start_time, 'Asia/Ho_Chi_Minh')->setTimezone('UTC');
        $validated['end_time'] = \Carbon\Carbon::parse($request->end_time, 'Asia/Ho_Chi_Minh')->setTimezone('UTC');
        $validated['user_id'] = auth()->id();

        $validated['status'] = 'pending';
        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $count = 0;
            foreach ($images as $img) {
                if ($count >= 6)
                    break;
                $imagePath = $img->store('products', 'public');
                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imagePath,
                ]);
                $count++;
            }
        }

        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function show($id)
    {
        $product = Product::with(['user', 'images'])->findOrFail($id);
        $bids = $product->bids()->with('user')->orderBy('amount', 'desc')->get();

        // Tạo giao dịch cho người thắng nếu phiên đấu giá đã kết thúc và chưa có giao dịch
        if (now() > $product->end_time) {
            $winnerBid = $bids->first();
            if ($winnerBid && !\App\Models\Transaction::where('product_id', $product->id)->exists()) {
                \App\Models\Transaction::create([
                    'user_id' => $winnerBid->user_id,
                    'product_id' => $product->id,
                    'amount' => $winnerBid->amount,
                    'status' => 'pending',
                ]);
                $winnerBid->user->notify(new \App\Notifications\WinnerNotification($product, $winnerBid->amount));
            }
        }

        return view('products.show', compact('product', 'bids'));
    }

    public function bid(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if (now() > $product->end_time) {
            return redirect()->route('products.show', $product->id)->with('error', 'Phiên đấu giá đã kết thúc, không thể đặt giá mới.');
        }

        $latestBid = $product->bids()->orderBy('amount', 'desc')->first();
        $minBid = $latestBid ? $latestBid->amount + $product->bid_step : $product->starting_price;

        $request->validate([
            'amount' => 'required|numeric|min:' . $minBid,
        ], [
            'amount.min' => 'Số tiền đặt giá phải lớn hơn hoặc bằng ' . number_format($minBid, 0, ',', '.') . ' VNĐ',
        ]);

        Bid::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'amount' => $request->amount,
        ]);

        return redirect()->route('products.show', $product->id)->with('success', 'Đặt giá thành công!');
    }

    public function featured(Request $request)
    {
        $query = Product::with('images')->where('start_time', '>', now())->where('status', 'active');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->orderBy('start_time')->get();
        $categories = Product::distinct()->pluck('category')->filter()->values();
        return view('products.index', compact('products', 'categories'));
    }

    public function active(Request $request)
    {
        $query = Product::with('images')
            ->where('start_time', '<=', now())
            ->where('end_time', '>', now())
            ->where('status', 'active');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->orderBy('end_time')->get();
        $categories = Product::distinct()->pluck('category')->filter()->values();
        return view('products.index', compact('products', 'categories'));
    }

    public function endingSoon(Request $request)
    {
        $query = Product::with('images')
            ->where('end_time', '>', now())
            ->where('end_time', '<', now()->addDay())
            ->where('status', 'active');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->orderBy('end_time')->get();
        $categories = Product::distinct()->pluck('category')->filter()->values();
        return view('products.index', compact('products', 'categories'));
    }

    public function index(Request $request)
    {
        // Hiển thị tất cả sản phẩm đang active và chưa kết thúc đấu giá
        $query = Product::with('images')
            ->where('status', 'active')
            ->where('end_time', '>', now());

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->orderBy('end_time', 'desc')->get();
        $categories = Product::distinct()->pluck('category')->filter()->values();

        return view('products.index', compact('products', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if (auth()->id() !== $product->user_id) {
            abort(403, 'Bạn không có quyền chỉnh sửa sản phẩm này.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'starting_price' => 'required|numeric',
            'bid_step' => 'required|numeric',
            'description' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product->update($validated);

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $count = 0;
            foreach ($images as $img) {
                if ($count >= 6)
                    break;
                $imagePath = $img->store('products', 'public');
                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imagePath,
                ]);
                $count++;
            }
        }

        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        // Kiểm tra quyền chỉnh sửa (chỉ chủ sở hữu mới được sửa)
        if (auth()->id() !== $product->user_id) {
            abort(403, 'Bạn không có quyền chỉnh sửa sản phẩm này.');
        }

        return view('products.edit', compact('product'));
    }

    public function extend(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if (auth()->id() !== $product->user_id || $product->bids()->count() > 0 || now() <= $product->end_time) {
            abort(403, 'Bạn không có quyền gia hạn sản phẩm này.');
        }

        $request->validate([
            'new_end_time' => 'required|date|after:now',
        ]);

        $product->end_time = $request->new_end_time;
        $product->save();

        return redirect()->route('products.show', $product->id)->with('success', 'Gia hạn sản phẩm thành công!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (auth()->id() !== $product->user_id) {
            abort(403, 'Bạn không có quyền xóa sản phẩm này.');
        }

        // Xoá tất cả ảnh liên quan
        foreach ($product->images as $img) {
            \Storage::disk('public')->delete($img->image);
            $img->delete();
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
    }

    public function confirmSold($id)
    {
        $product = Product::findOrFail($id);

        if (auth()->id() !== $product->user_id) {
            abort(403, 'Bạn không có quyền xác nhận bán sản phẩm này.');
        }

        $winnerBid = $product->bids()->orderBy('amount', 'desc')->first();

        if (!$winnerBid || now() <= $product->end_time) {
            return back()->with('error', 'Chưa có người chiến thắng hoặc phiên đấu giá chưa kết thúc.');
        }

        $transaction = \App\Models\Transaction::where('product_id', $product->id)->first();
        if ($transaction) {
            $transaction->status = 'sold';
            $transaction->save();
        }
        // Đổi trạng thái sản phẩm thành đã bán
        $product->status = 'sold';
        $product->save();

        return back()->with('success', 'Đã xác nhận bán sản phẩm cho người chiến thắng!');
    }

    public function deleteImage($id)
    {
        $image = \App\Models\ProductImage::findOrFail($id);
        \Storage::disk('public')->delete($image->image);
        $image->delete();
        return back()->with('success', 'Đã xoá ảnh sản phẩm!');
    }
    public function myProducts(Request $request)
    {
        $query = \App\Models\Product::with('images')
            ->where('user_id', auth()->id());

        if ($search = $request->q) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($category = $request->category) {
            $query->where('category', $category);
        }

        $products = $query->latest()->get();
        $categories = \App\Models\Product::where('user_id', auth()->id())
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        return view('my-products', compact('products', 'categories'));
    }

}
