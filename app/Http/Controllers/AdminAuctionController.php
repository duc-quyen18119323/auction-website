<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminAuctionController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('user')->withCount('bids');
        if ($request->status === 'active') {
            $query->where('end_time', '>', now());
        } elseif ($request->status === 'ended') {
            $query->where('end_time', '<=', now());
        }
        $auctions = $query->orderBy('end_time', 'desc')->get();
        return view('admin.auctions', compact('auctions'));
    }
}
