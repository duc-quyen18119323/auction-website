<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'starting_price',
        'bid_step',
        'start_time',
        'end_time',
        'warranty',
        'category',
        'image',
        'user_id',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bids()
    {
        return $this->hasMany(\App\Models\Bid::class, 'product_id');
    }

    public function images()
    {
        return $this->hasMany(\App\Models\ProductImage::class, 'product_id');
    }
}
