@extends('admin.layouts2.app2')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <!-- Header dengan Filter -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Daftar User</h2>
                <p class="text-sm text-gray-600 mt-1">Kelola dan verifikasi akun user</p>
            </div>
            
            <form method="GET" class="flex flex-wrap gap-2">
                <!-- Filter Status -->
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                <!-- Filter Verifikasi -->
                <select name="verification" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Verifikasi</option>
                    <option value="pending" {{ request('verification') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="approved" {{ request('verification') == 'approved' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="rejected" {{ request('verification') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
                
                <!-- Search -->
                <input type="text" 
                       name="search" 
                       placeholder="Cari nama, email, HP..." 
                       value="{{ request('search') }}"
                       class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-64">
                
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                    Filter
                </button>

                @if(request()->hasAny(['status', 'verification', 'search']))
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kontak</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Verifikasi</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Orders</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-600 font-semibold text-sm">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500">Bergabung: {{ $user->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $user->email }}</div>
                        <div class="text-xs text-gray-500">{{ $user->phone ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $user->status_badge }}">
                            {{ $user->status_text }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $user->verification_badge }}">
                            {{ $user->verification_text }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="text-sm font-medium text-gray-900">{{ $user->orders_count }}</div>
                        <div class="text-xs text-gray-500">order</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.users.show', $user) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="text-gray-500">Tidak ada user yang ditemukan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $users->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection