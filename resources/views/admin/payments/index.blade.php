@extends('admin.layouts2.app2')

@section('title', 'Manajemen Pembayaran - Admin Panel')
@section('page-title', 'Manajemen Pembayaran')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-800">Daftar Pembayaran</h3>
        
        <div class="flex space-x-4">
            <form method="GET" class="flex space-x-2">
                <select name="status" class="px-3 py-1 border border-gray-300 rounded-md text-sm">
                    <option value="">Semua Status</option>
                    <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Menunggu</option>
                    <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Berhasil</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
                </select>
                
                <input type="text" name="search" placeholder="Cari user atau bank..." 
                       value="{{ request('search') }}"
                       class="px-3 py-1 border border-gray-300 rounded-md text-sm">
                
                <button type="submit" class="px-4 py-1 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600">Filter</button>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bank</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($payments as $payment)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-4 text-sm font-medium text-gray-900">#{{ $payment->id }}</td>
                    <td class="px-4 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $payment->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $payment->user->email }}</div>
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-900 uppercase font-medium">{{ $payment->bank }}</td>
                    <td class="px-4 py-4">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $payment->status_badge }}">
                            {{ $payment->status_text }}
                        </span>
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-500">{{ $payment->created_at->format('d M Y H:i') }}</td>
                    <td class="px-4 py-4 text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.payments.show', $payment) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                            
                            @if($payment->status == 'waiting')
                                <form method="POST" action="{{ route('admin.payments.update-status', $payment) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="success">
                                    <button type="submit" class="text-green-600 hover:text-green-900">Setuju</button>
                                </form>
                                
                                <form method="POST" action="{{ route('admin.payments.update-status', $payment) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="failed">
                                    <button type="submit" class="text-red-600 hover:text-red-900">Tolak</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-12 text-center text-gray-500">Tidak ada pembayaran yang ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $payments->appends(request()->query())->links() }}
    </div>
</div>
@endsection