<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conversation;

class InboxController extends Controller
{
    // Hiển thị danh sách cuộc trò chuyện (inbox)
    public function index()
    {
        $conversations = Conversation::with('user')
            ->orderByDesc('updated_at')
            ->get();

        return view('admin.inbox.index', compact('conversations'));
    }

    // Hiển thị tin nhắn của 1 cuộc trò chuyện
    public function show($id)
    {
        $conversation = Conversation::with(['messages.sender', 'user'])
            ->findOrFail($id);

        // ⭐ KHI ADMIN MỞ ĐOẠN CHAT → ĐÁNH DẤU TIN NHẮN USER LÀ ĐÃ ĐỌC
        $conversation->messages()
            ->where('is_admin', 0)       // tin do user gửi
            ->where('is_read', 0)        // chưa đọc
            ->update(['is_read' => 1]);  // đánh dấu đã đọc

        return view('admin.inbox.show', compact('conversation'));
    }

    // Gửi tin nhắn mới (admin gửi)
    public function send(Request $request, $id)
    {
        $request->validate([
            'message' => 'nullable|string',
            'image'   => 'nullable|image|max:4096'
        ]);
    
        $conversation = \App\Models\Conversation::findOrFail($id);
    
        $imagePath = null;
    
        // Lưu ảnh nếu có
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat', 'public');
        }
    
        $conversation->messages()->create([
            'sender_id'     => auth()->id(),
            'message'       => $request->message ?? '',  // CHO PHÉP RỖNG
            'image_path'    => $imagePath,
            'is_admin'      => 1,
            'is_read'       => 0
        ]);
    
        $conversation->touch();
    
        return redirect()->route('admin.inbox.show', $conversation->id);
    }

    // Ghim đoạn chat lên đầu (update updated_at)
    public function pin($id)
    {
        $conv = Conversation::findOrFail($id);
        $conv->updated_at = now();
        $conv->save();

        return back();
    }

    // Xoá đoạn chat
    public function delete($id)
    {
        $conv = Conversation::findOrFail($id);
        $conv->messages()->delete();
        $conv->delete();

        return redirect()->route('admin.inbox')->with('success', 'Đã xoá đoạn chat!');
    }
}
