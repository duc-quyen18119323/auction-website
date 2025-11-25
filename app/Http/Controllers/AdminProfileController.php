<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Message;

class AdminProfileController extends Controller
{
    public function showProfile()
    {
        $admin = Auth::user();

        // Đảm bảo chỉ admin mới được vào
        if (!$admin || !$admin->is_admin) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        // Nếu cần truyền admin sang view
        return view('admin.profile', compact('admin'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ]);

        $admin = Auth::user();

        if (!$admin || !$admin->is_admin) {
            abort(403, 'Bạn không có quyền thực hiện thao tác này.');
        }

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->with('error', 'Mật khẩu hiện tại không đúng!');
        }

        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }

    public function showInbox()
    {
        $unreadMessagesCount = Message::where('is_read', false)->count();
        $usersWithUnreadMessages = Message::where('is_read', false)
            ->select('user_id', Message::raw('COUNT(*) as unread_count'))
            ->groupBy('user_id')
            ->get();

        return view('admin.inbox', compact('unreadMessagesCount', 'usersWithUnreadMessages'));
    }

    public static function getUnreadSupportCount() {
        return \App\Models\Conversation::whereHas('messages', function ($query) {
            $query->where('is_admin', 0)   // user gửi
                  ->where('is_read', 0);   // admin chưa đọc
        })
        ->count();
    }
}
