<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'message',
        'is_admin',
        'is_read',     // thêm vào fillable
        'image_path',   // thêm
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'is_read'  => 'boolean',      // tự động convert 0/1 thành true/false
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Scope: Tin nhắn user chưa đọc bởi admin
     */
    public function scopeUnreadForAdmin($query)
    {
        return $query->where('is_admin', 0)->where('is_read', 0);
    }
}
