<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');      // lấy ?status=...
        $now    = now();

        // query gốc
        $query = Product::with('user');

        if ($status === 'pending') {
            // Chỉ sản phẩm chờ duyệt
            $query->where('status', 'pending');

        } elseif ($status === 'active') {
            // Sản phẩm đang hiển thị / đang diễn ra
            $query->where('status', 'active')
                  ->where('end_time', '>', $now);

        } elseif ($status === 'ended') {
            // Sản phẩm đã kết thúc: đã bán hoặc hết thời gian
            $query->where(function ($q) use ($now) {
                $q->where('status', 'sold')
                  ->orWhere(function ($q2) use ($now) {
                      $q2->where('status', 'active')
                         ->where('end_time', '<=', $now);
                  });
            });
        }
        // status rỗng => không thêm điều kiện (Tất cả)

        $products = $query->orderBy('end_time', 'desc')->get();
        // nếu muốn phân trang:
        // $products = $query->orderBy('end_time','desc')->paginate(15);

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
