<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminAuctionController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $now = now();
        // Query chính
        $auctionsQuery = Product::with(['user'])
        ->withCount('bids');   // <<--- THÊM DÒNG NÀY
        
    

        switch ($status) {
            case 'upcoming': // Sắp diễn ra
                $auctionsQuery
                    ->where('status', 'active')
                    ->where('start_time', '>', $now);
                break;

            case 'active':   // Đang diễn ra
                $auctionsQuery
                    ->where('status', 'active')
                    ->where('start_time', '<=', $now)
                    ->where('end_time', '>=', $now);
                break;

            case 'ending_soon': // Sắp kết thúc trong 24h
                $auctionsQuery
                    ->where('status', 'active')
                    ->where('start_time', '<=', $now)
                    ->whereBetween('end_time', [$now, (clone $now)->addDay()]);
                break;

            case 'all':
            default:
                // không lọc thêm
                break;
        }

        $auctions = $auctionsQuery
            ->orderBy('end_time', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Thống kê 4 box trên đầu
        $base = Product::query();

        $stats = [
            'total' => (clone $base)->count(),
            'upcoming' => (clone $base)
                ->where('status', 'active')
                ->where('start_time', '>', $now)
                ->count(),
            'active' => (clone $base)
                ->where('status', 'active')
                ->where('start_time', '<=', $now)
                ->where('end_time', '>=', $now)
                ->count(),
            'ending_soon' => (clone $base)
                ->where('status', 'active')
                ->where('start_time', '<=', $now)
                ->whereBetween('end_time', [$now, (clone $now)->addDay()])
                ->count(),
        ];

        return view('admin.auctions', compact('auctions', 'status', 'stats'));
    }

    public function show($id)
    {
        $product = Product::with(['user', 'images'])->findOrFail($id);
        $bids = $product->bids()->with('user')->orderByDesc('amount')->get();
        $winner = $bids->first(); // hoặc logic riêng

        return view('admin.auctions.show', compact('product', 'bids', 'winner'));
    }
}
