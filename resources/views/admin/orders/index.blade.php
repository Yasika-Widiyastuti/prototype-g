@extends('admin.layouts2.app2')

@section('title', 'Daftar Pesanan')

@section('page-title', 'Daftar Pesanan')

@section('content')
    <div class="p-6 bg-white rounded-lg shadow">
        <h3 class="text-xl font-semibold text-gray-800 mb-6">Daftar Pesanan</h3>
        
        @if($orders->count() > 0)
            <table class="min-w-full table-auto mt-4 border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">ID Pesanan</th>
                        <th class="px-4 py-2 text-left">Nama Pengguna</th>
                        <th class="px-4 py-2 text-left">Tanggal Pesanan</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $order->order_number }}</td>
                            <td class="px-4 py-2">{{ $order->user->name }}</td>
                            <td class="px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $order->status_badge }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-500 hover:underline">Lihat Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500">Belum ada pesanan.</p>
        @endif
    </div>
@endsection
