@extends('admin.layouts2.app2')

@section('title', 'Daftar Pesanan')
@section('page-title', 'Daftar Pesanan')

@section('content')
<div class="p-6 bg-white rounded-lg shadow">
    <h3 class="text-xl font-semibold text-gray-800 mb-6">Daftar Pesanan</h3>

    @if($orders->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto mt-4 border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID Pesanan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Pengguna</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pesanan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <tr>
                        <td class="px-4 py-4 text-sm font-medium text-gray-900">{{ $order->order_number }}</td>
                        <td class="px-4 py-4 text-sm text-gray-700">{{ $order->user->name }}</td>
                        <td class="px-4 py-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-4">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $order->status_badge }}">
                                {{ $order->status_text }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-sm space-x-2">
                            <!-- Tombol Lihat Detail -->
                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                               class="inline-block text-blue-600 hover:text-blue-900">
                                Lihat Detail
                            </a>

                            <!-- Tombol untuk status 'confirmed' → 'rented' -->
                            @if($order->status === 'confirmed')
                                <form method="POST" action="{{ route('admin.orders.confirm-pickup', $order) }}" class="inline-block">
                                    @csrf
                                    <button type="submit" 
                                            class="text-purple-600 hover:text-purple-900 font-medium"
                                            onclick="return confirm('Konfirmasi barang sudah diambil customer?')">
                                        📦 Barang Diambil
                                    </button>
                                </form>
                            @endif

                            <!-- Tombol untuk status 'rented' → 'completed' -->
                            @if($order->status === 'rented')
                                <form method="POST" action="{{ route('admin.orders.confirm-return', $order) }}" class="inline-block">
                                    @csrf
                                    <button type="submit" 
                                            class="text-green-600 hover:text-green-900 font-medium"
                                            onclick="return confirm('Konfirmasi barang sudah dikembalikan?')">
                                        ✅ Barang Dikembalikan
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <p class="text-gray-500">Belum ada pesanan.</p>
    @endif
</div>
@endsection
