<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    // Hiển thị danh sách cuộc trò chuyện (inbox)
    public function index()
    {
        // Lấy tất cả các cuộc trò chuyện có user hoặc admin là mình
        $conversations = \App\Models\Conversation::with('user')
            ->orderByDesc('updated_at')
            ->get();
        return view('admin.inbox.index', compact('conversations'));
    }

    // Hiển thị tin nhắn của 1 cuộc trò chuyện
    public function show($id)
    {
        $conversation = \App\Models\Conversation::with(['messages.sender', 'user'])
            ->findOrFail($id);
        return view('admin.inbox.show', compact('conversation'));
    }

    // Gửi tin nhắn mới (admin gửi)
    public function send(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);
        $conversation = \App\Models\Conversation::findOrFail($id);
        $msg = $conversation->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->message,
            'is_admin' => true
        ]);
        $conversation->touch(); // cập nhật updated_at
        return redirect()->route('admin.inbox.show', $conversation->id);
    }

    // Ghim đoạn chat lên đầu (update updated_at)
    public function pin($id)
    {
        $conv = \App\Models\Conversation::findOrFail($id);
        $conv->updated_at = now();
        $conv->save();
        return back();
    }

    // Xoá đoạn chat
    public function delete($id)
    {
        $conv = \App\Models\Conversation::findOrFail($id);
        $conv->messages()->delete();
        $conv->delete();
        return redirect()->route('admin.inbox')->with('success', 'Đã xoá đoạn chat!');
    }
}

