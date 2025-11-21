@extends('admin.dashboard')
@section('content')
<div class="flex h-full">
    <!-- Danh sách cuộc trò chuyện -->
    <div class="w-1/3 bg-gray-100 border-r overflow-y-auto">
        <h2 class="text-xl font-bold p-4">Hộp thư người dùng</h2>
        <ul>
            @foreach($conversations as $conv)
                <li class="relative">
                    <div class="px-4 py-3 border-b hover:bg-blue-100 flex items-center justify-between">

                        <!-- Click vào tên để mở cuộc trò chuyện -->
                        <a href="{{ route('admin.inbox.show', $conv->id) }}" class="flex-1">
                            <span class="font-semibold">
                                {{ $conv->user->username ?? 'Người dùng' }}
                            </span>
                        </a>

                        <!-- Nút 3 chấm -->
                        <button type="button"
                                class="ml-2 cursor-pointer p-1 menu-trigger"
                                onclick="toggleMenu(event, {{ $conv->id }})">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5 text-gray-500 hover:text-gray-700"
                                 fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <circle cx="5" cy="12" r="2"/>
                                <circle cx="12" cy="12" r="2"/>
                                <circle cx="19" cy="12" r="2"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Menu Ghim / Xóa -->
                    <div id="menu-{{ $conv->id }}"
                         class="menu-dropdown hidden absolute right-0 mt-2 w-32 bg-white border rounded shadow z-10">
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

    <!-- Nội dung chat -->
    <div class="flex-1 flex items-center justify-center text-gray-400">
        <span>Chọn một cuộc trò chuyện để xem tin nhắn</span>
    </div>
</div>

<script>
    // Hàm mở/đóng menu – gắn lên window để chắc chắn gọi được từ onclick
    window.toggleMenu = function(event, id) {
        event.stopPropagation();

        const menu = document.getElementById('menu-' + id);

        // Ẩn tất cả menu khác
        document.querySelectorAll('.menu-dropdown').forEach(el => el.classList.add('hidden'));

        // Toggle menu hiện tại
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
        } else {
            menu.classList.add('hidden');
        }
    };

    // Click ra ngoài thì đóng menu
    document.addEventListener('click', function(e) {
        const isInMenu     = e.target.closest('.menu-dropdown');
        const isInTrigger  = e.target.closest('.menu-trigger');

        if (!isInMenu && !isInTrigger) {
            document.querySelectorAll('.menu-dropdown').forEach(el => el.classList.add('hidden'));
        }
    });
</script>
@endsection
