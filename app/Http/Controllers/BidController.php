<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BidController extends Controller
{
    public function history()
    {
        $bids = \App\Models\Bid::with('product')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('bids.history', compact('bids'));
    }

    public function index()
    {
        $bids = auth()->check()
            ? \App\Models\Bid::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get()
            : [];
        return view('bids.index', compact('bids'));
    }
}
