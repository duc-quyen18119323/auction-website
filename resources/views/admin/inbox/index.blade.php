@extends('admin.dashboard')
@section('content')
    <div class="flex h-full">
        <!-- Danh sách cuộc trò chuyện -->
        <div class="w-1/3 bg-gray-100 border-r overflow-y-auto">
            <h2 class="text-xl font-bold p-4">Hộp thư người dùng</h2>
            <ul>
                @foreach($conversations as $conv)
                    <li class="relative">
                        <a href="{{ route('admin.inbox.show', $conv->id) }}" class="block px-4 py-3 border-b hover:bg-blue-100
                              flex items-center justify-between">

                            <span class="font-semibold">
                                {{ $conv->user->username ?? 'Người dùng' }}
                            </span>

                            {{-- Badge số tin user -> admin chưa đọc --}}
                            @if($conv->unread_user_count > 0)
                                <span class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                    {{ $conv->unread_user_count }}
                                </span>
                            @endif

                            {{-- nút 3 chấm giữ nguyên --}}
                            <span class="ml-2 cursor-pointer menu-trigger" onclick="toggleMenu(event, {{ $conv->id }})">
                                ...
                            </span>
                        </a>

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
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('[data-menu-button]');
            const menus = document.querySelectorAll('[data-menu]');

            function hideAllMenus() {
                menus.forEach(m => m.classList.add('hidden'));
            }

            buttons.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();

                    const id = this.getAttribute('data-menu-button');
                    const menu = document.querySelector('[data-menu="' + id + '"]');

                    const isHidden = menu.classList.contains('hidden');
                    hideAllMenus();
                    if (isHidden) {
                        menu.classList.remove('hidden');
                    }
                });
            });

            document.addEventListener('click', function (e) {
                const inMenu = e.target.closest('[data-menu]');
                const inTrigger = e.target.closest('[data-menu-button]');
                if (!inMenu && !inTrigger) {
                    hideAllMenus();
                }
            });
        });
    </script>
@endsection