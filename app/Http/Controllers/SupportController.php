<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use Illuminate\Support\Facades\Storage;

class SupportController extends Controller
{
    // Lấy tất cả tin nhắn của user
    public function messages()
    {
        $conversation = Conversation::firstOrCreate(
            ['user_id' => auth()->id()],
            ['admin_id' => 1]
        );

        $messages = $conversation->messages()
            ->orderBy('created_at')
            ->get()
            ->map(function ($msg) {
                return [
                    'message'    => $msg->message,
                    'is_admin'   => $msg->is_admin,
                    'created_at' => $msg->created_at->format('H:i d/m/Y'),
                    'image_url'  => $msg->image_path
                        ? Storage::url($msg->image_path)
                        : null,
                ];
            });

        // (tuỳ chọn) đánh dấu tin admin gửi cho user là đã đọc
        $conversation->messages()
            ->where('is_admin', 1)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return response()->json($messages);
    }

    // User gửi tin nhắn (text + ảnh)
    public function sendAjax(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string',
            'image'   => 'nullable|image|max:4096',
        ]);

        $conversation = Conversation::where('user_id', auth()->id())
            ->firstOrFail();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat', 'public');
        }

        $conversation->messages()->create([
            'sender_id'  => auth()->id(),
            'message'    => $request->message ?? '',
            'is_admin'   => false,
            'is_read'    => 0,
            'image_path' => $imagePath,
        ]);

        $conversation->touch();

        return response()->json(['success' => true]);
    }
}
