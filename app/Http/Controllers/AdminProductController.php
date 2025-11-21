<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with('user')->get();
        return view('admin.products', compact('products'));
    }

    public function approve($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 'active';
        $product->save();
        return back()->with('success', 'Duyệt sản phẩm thành công!');
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return back()->with('success', 'Xóa sản phẩm thành công!');
    }
}
