@extends('admin.layouts2.app2')

@section('title', 'Manajemen User - Admin Panel')
@section('page-title', 'Manajemen User')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-800">Daftar User</h3>
        
        <div class="flex space-x-4">
            <form method="GET" class="flex space-x-2">
                <select name="status" class="px-3 py-1 border border-gray-300 rounded-md text-sm">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                
                <input type="text" name="search" placeholder="Cari user..." 
                       value="{{ request('search') }}"
                       class="px-3 py-1 border border-gray-300 rounded-md text-sm">
                
                <button type="submit" class="px-4 py-1 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600">
                    Filter
                </button>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Telepon</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Orders</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bergabung</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                    </td>
                    <td class="px-4 py-4">
                        <div class="text-sm text-gray-900">{{ $user->email }}</div>
                    </td>
                    <td class="px-4 py-4">
                        <div class="text-sm text-gray-900">{{ $user->phone ?? '-' }}</div>
                    </td>
                    <td class="px-4 py-4">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $user->status_badge }}">
                            {{ $user->status_text }}
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $user->orders_count }}</div>
                        <div class="text-sm text-gray-500">{{ $user->formatted_total_spent }}</div>
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-500">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td class="px-4 py-4 text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.users.show', $user) }}" 
                               class="text-blue-600 hover:text-blue-900">Detail</a>
                            
                            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-12 text-center text-gray-500">
                        Tidak ada user yang ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->appends(request()->query())->links() }}
    </div>
</div>
@endsection
