@extends('admin.dashboard')
@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Hộp thư hỗ trợ</h2>
    <p class="mb-4">Tổng số tin nhắn chưa xem: <strong>{{ $unreadMessagesCount }}</strong></p>
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2">Tên người dùng</th>
                <th class="border border-gray-300 px-4 py-2">Số tin nhắn chưa xem</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usersWithUnreadMessages as $user)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">User ID: {{ $user->user_id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $user->unread_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection