<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        $userId = Auth::id();
        $productId = $request->product_id;
        $favorite = Favorite::firstOrCreate([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);
        return back()->with('success', 'Đã lưu sản phẩm vào yêu thích!');
    }

    public function list()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem sản phẩm yêu thích!');
        }
        
        $user = Auth::user();
        $favorites = \App\Models\Favorite::where('user_id', $user->id)->with('product')->get();
        return view('favorites.index', compact('favorites'));
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        $userId = Auth::id();
        $productId = $request->product_id;
        Favorite::where('user_id', $userId)->where('product_id', $productId)->delete();
        return back()->with('success', 'Đã bỏ lưu sản phẩm khỏi yêu thích!');
    }

    public function myProducts()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem sản phẩm của bạn!');
        }
        
        $user = Auth::user();
        // Tất cả sản phẩm do user đăng
        $myProducts = \App\Models\Product::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        // Sản phẩm đã tham gia đấu giá (không trùng lặp)
        $bidProductIds = \App\Models\Bid::where('user_id', $user->id)->pluck('product_id')->unique();
        $bidProducts = \App\Models\Product::whereIn('id', $bidProductIds)->get();
        // Sản phẩm yêu thích
        $favoriteProducts = \App\Models\Favorite::where('user_id', $user->id)->with('product')->get();
        return view('my-products', compact('myProducts', 'bidProducts', 'favoriteProducts'));
    }
}
