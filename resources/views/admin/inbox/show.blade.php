@extends('admin.dashboard')

@section('title', 'Hộp thư hỗ trợ')
@section('page_title', 'Hộp thư người dùng')

@section('content')
{{-- Cả khối hộp thư cao gần bằng màn hình, cuộn bên trong --}}
<div class="flex" style="height: calc(100vh - 180px);">
    {{-- CỘT TRÁI: DANH SÁCH CUỘC TRÒ CHUYỆN --}}
    <div class="w-1/3 bg-gray-100 border-r overflow-y-auto">
        <h2 class="text-xl font-bold p-4">Hộp thư người dùng</h2>
        <ul>
            @foreach(\App\Models\Conversation::with('user')->orderByDesc('updated_at')->get() as $conv)
                @php
                    $unreadUser = $conv->messages()
                        ->where('is_admin', 0)
                        ->where('is_read', 0)
                        ->count();
                @endphp

                <li class="relative">
                    <a href="{{ route('admin.inbox.show', $conv->id) }}"
                       class="block px-4 py-3 border-b hover:bg-blue-100
                              {{ $conv->id == $conversation->id ? 'bg-blue-50 font-bold' : '' }}
                              flex items-center justify-between">

                        <span class="font-semibold">
                            {{ $conv->user->username ?? 'Người dùng' }}
                        </span>

                        @if($unreadUser > 0)
                            <span class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                {{ $unreadUser }}
                            </span>
                        @endif

                        {{-- Nút 3 chấm --}}
                        <span class="ml-2 cursor-pointer menu-trigger"
                              onclick="toggleMenu(event, {{ $conv->id }})">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5 text-gray-500 hover:text-gray-700"
                                 fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <circle cx="5" cy="12" r="2"/>
                                <circle cx="12" cy="12" r="2"/>
                                <circle cx="19" cy="12" r="2"/>
                            </svg>
                        </span>
                    </a>

                    {{-- Menu dropdown --}}
                    <div id="menu-{{ $conv->id }}"
                         class="hidden absolute right-0 mt-2 w-32 bg-white border rounded shadow z-10 menu-dropdown">
                        <form action="{{ route('admin.inbox.pin', $conv->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                                Ghim lên đầu
                            </button>
                        </form>
                        <form action="{{ route('admin.inbox.delete', $conv->id) }}" method="POST"
                              onsubmit="return confirm('Bạn chắc chắn muốn xoá đoạn chat này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600">
                                Xoá đoạn chat
                            </button>
                        </form>
                    </div>

                    <div class="text-xs text-gray-500 px-4 pb-2">
                        {{ $conv->updated_at->diffForHumans() }}
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- CỘT PHẢI: KHUNG CHAT --}}
    <div class="flex-1 flex flex-col h-full">
        {{-- Vùng tin nhắn có scroll riêng --}}
        <div id="chatMessages"
             class="flex-1 overflow-y-auto p-6 bg-white"
             style="max-height: 100%;">
            <h3 class="text-lg font-bold mb-4">
                Chat với:
                <span class="text-blue-700">{{ $conversation->user->username ?? 'Người dùng' }}</span>
            </h3>

            <div class="space-y-4">
                @foreach($conversation->messages as $msg)
                    <div class="flex {{ $msg->is_admin ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs px-4 py-2 rounded-lg
                                    {{ $msg->is_admin ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-900' }}">

                            {{-- TEXT --}}
                            @if($msg->message)
                                <div class="text-sm break-words">{{ $msg->message }}</div>
                            @endif

                            {{-- IMAGE --}}
                            @if($msg->image_path)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($msg->image_path) }}"
                                         class="rounded-lg max-w-full max-h-80 object-contain">
                                </div>
                            @endif

                            {{-- THỜI GIAN --}}
                            <div class="text-xs text-right opacity-70 mt-1">
                                {{ $msg->created_at->format('H:i d/m/Y') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- FORM GỬI TIN NHẮN --}}
        <form action="{{ route('admin.inbox.send', $conversation->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="flex p-4 bg-gray-50 border-t items-center gap-3">
            @csrf

            <input type="file" name="image" class="text-xs" accept="image/*">

            <input type="text"
                   name="message"
                   class="flex-1 border rounded px-3 py-2 text-sm"
                   placeholder="Nhập tin nhắn..."
                   autocomplete="off">

            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded text-sm font-semibold">
                Gửi
            </button>
        </form>
    </div>
</div>

<script>
    function toggleMenu(event, id) {
        event.preventDefault();
        event.stopPropagation();

        document.querySelectorAll('.menu-dropdown')
            .forEach(el => el.classList.add('hidden'));

        document.getElementById('menu-' + id)
            .classList.toggle('hidden');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('li.relative')) {
            document.querySelectorAll('.menu-dropdown')
                .forEach(el => el.classList.add('hidden'));
        }
    });

    // ===== AUTO SCROLL KHUNG CHAT XUỐNG CUỐI =====
    function scrollChatToBottom() {
        const box = document.getElementById('chatMessages');
        if (!box) return;
        box.scrollTop = box.scrollHeight;
    }

    // Đợi toàn bộ trang (kể cả ảnh) load xong rồi mới cuộn
    window.addEventListener('load', function () {
        scrollChatToBottom();
        // Gọi lại 1 lần nữa sau 200ms phòng trường hợp ảnh lớn load chậm
        setTimeout(scrollChatToBottom, 200);
    });
</script>
@endsection
