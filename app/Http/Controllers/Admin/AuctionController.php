<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    // Danh sách phiên đấu giá + thống kê
    public function index(\Illuminate\Http\Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = \App\Models\Product::with(['user', 'bids']);
        
        if ($status == 'upcoming') {
            $query->where('status', 'active')->where('start_time', '>', now());
        } elseif ($status == 'active') {
            $query->where('status', 'active')->where('start_time', '<=', now())->where('end_time', '>', now());
        } elseif ($status == 'ending_soon') {
            $query->where('status', 'active')->where('end_time', '>', now())->where('end_time', '<=', now()->addHours(24));
        }
        
        $products = $query->orderByDesc('created_at')->paginate(20);
        
        // Thống kê
        $stats = [
            'total' => \App\Models\Product::where('status', 'active')->count(),
            'upcoming' => \App\Models\Product::where('status', 'active')->where('start_time', '>', now())->count(),
            'active' => \App\Models\Product::where('status', 'active')->where('start_time', '<=', now())->where('end_time', '>', now())->count(),
            'ending_soon' => \App\Models\Product::where('status', 'active')->where('end_time', '>', now())->where('end_time', '<=', now()->addHours(24))->count(),
        ];
        
        return view('admin.auctions.index', compact('products', 'stats', 'status'));
    }
    
    // Chi tiết phiên đấu giá
    public function show($id)
    {
        $product = \App\Models\Product::with(['user', 'bids.user', 'images'])->findOrFail($id);
        
        // Lịch sử đấu giá (bid history)
        $bids = $product->bids()->with('user')->orderByDesc('amount')->get();
        
        // Người thắng cuộc (highest bidder)
        $winner = $bids->first();
        
        return view('admin.auctions.show', compact('product', 'bids', 'winner'));
    }

    //
}
