<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('components.header-logo')
    <div class="max-w-5xl mx-auto mt-8 px-4">
        <h2 class="text-2xl font-bold mb-6">Quản lý người dùng</h2>
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Tên</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Số điện thoại</th>
                        <th class="py-2 px-4 border-b">Quyền</th>
                        <th class="py-2 px-4 border-b">Trạng thái</th>
                        <th class="py-2 px-4 border-b">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $user->id }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->phone }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->is_admin ? 'Admin' : 'User' }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->is_active ? 'Hoạt động' : 'Đã khóa' }}</td>
                            <td class="py-2 px-4 border-b">
                                @if(!$user->is_admin)
                                    <form action="{{ url('/admin/users/' . $user->id . '/toggle') }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 rounded {{ $user->is_active ? 'bg-red-500 hover:bg-red-700' : 'bg-green-500 hover:bg-green-700' }} text-white">
                                            {{ $user->is_active ? 'Khóa' : 'Mở khóa' }}
                                        </button>
                                    </form>
                                    <form action="{{ url('/admin/users/' . $user->id . '/toggle-admin') }}" method="POST" class="inline ml-2">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 rounded bg-blue-500 hover:bg-blue-700 text-white">
                                            {{ $user->is_admin ? 'Bỏ quyền Admin' : 'Cấp quyền Admin' }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400">---</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>