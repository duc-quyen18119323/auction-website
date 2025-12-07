<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'amount',
    ];

    // Quan hệ tới sản phẩm
    public function product()
    {
        // Nếu Product có SoftDeletes thì dùng withTrashed(), còn không thì bỏ ->withTrashed()
        return $this->belongsTo(Product::class); // hoặc ->withTrashed();
    }

    // Quan hệ tới user đặt giá
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
