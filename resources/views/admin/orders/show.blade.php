@extends('admin.layouts2.app2')

@section('title', 'Detail Pesanan')

@section('page-title', 'Detail Pesanan')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-xl font-semibold text-gray-800 mb-6">Detail Pesanan #{{ $order->order_number }}</h3>

        <div class="mb-4">
            <h4 class="text-lg font-semibold text-gray-700">Informasi Pengguna</h4>
            <p class="text-gray-600">Nama: {{ $order->user->name }}</p>
            <p class="text-gray-600">Email: {{ $order->user->email }}</p>
            <p class="text-gray-600">Telepon: {{ $order->user->phone_number }}</p>
        </div>

        <div class="mb-4">
            <h4 class="text-lg font-semibold text-gray-700">Informasi Pesanan</h4>
            <p class="text-gray-600">Tanggal Pesanan: {{ $order->created_at->format('d M Y H:i') }}</p>
            <p class="text-gray-600">Status Pesanan: <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></p>
            <p class="text-gray-600">Total Pembayaran: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
        </div>

        <div class="mb-4">
            <h4 class="text-lg font-semibold text-gray-700">Barang yang Dipesan</h4>
            <table class="min-w-full table-auto mt-4">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Nama Produk</th>
                        <th class="px-4 py-2 text-left">Jumlah</th>
                        <th class="px-4 py-2 text-left">Harga Satuan</th>
                        <th class="px-4 py-2 text-left">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $item->product->name }}</td>
                            <td class="px-4 py-2">{{ $item->quantity }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($item->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Actions -->
        <div class="mt-6">
            @if($order->status == 'pending')
                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="completed">
                    <button type="submit" class="bg-green-500 text-white p-2 rounded hover:bg-green-600">Tandai Sebagai Selesai</button>
                </form>
            @elseif($order->status == 'completed')
                <form action="{{ route('admin.orders.verify-payment', $order->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Verifikasi Pembayaran</button>
                </form>
            @endif
        </div>
    </div>
@endsection
