<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    // Danh sách giao dịch của user hiện tại
    public function index()
    {
        $transactions = Transaction::where('user_id', auth()->id())
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('transactions.index', compact('transactions'));
    }

    // Xem chi tiết 1 giao dịch
    public function show(Transaction $transaction)
    {
        // Chỉ cho chủ giao dịch xem
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        // Chuyển sang trang chi tiết sản phẩm (nơi đã có đầy đủ info + liên hệ người bán)
        return redirect()->route('products.show', $transaction->product_id);
    }
}
