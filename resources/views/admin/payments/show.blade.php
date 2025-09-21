@extends('admin.layouts2.app2')

@section('title', 'Detail Pembayaran - Admin Panel')
@section('page-title', 'Detail Pembayaran #' . $payment->id)

@section('content')
<div class="space-y-6">
    <!-- Payment Details Card -->
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h3 class="text-xl font-semibold text-gray-800">Pembayaran #{{ $payment->id }}</h3>
                <p class="text-gray-600 mt-1">{{ $payment->created_at->format('d M Y H:i') }}</p>
            </div>
            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $payment->status_badge }}">
                {{ $payment->status_text }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Payment Info -->
            <div>
                <h4 class="text-sm font-medium text-gray-500 uppercase mb-3">Info Pembayaran</h4>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm text-gray-600">Bank Transfer</label>
                        <p class="font-medium uppercase">{{ $payment->bank }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Bukti Transfer</label>
                        @if($payment->bukti_transfer)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $payment->bukti_transfer) }}" 
                                     alt="Bukti Transfer" 
                                     class="max-w-md rounded-lg shadow-md cursor-pointer"
                                     onclick="window.open(this.src, '_blank')">
                            </div>
                        @else
                            <p class="text-gray-400">Tidak ada bukti transfer</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- User Info -->
            <div>
                <h4 class="text-sm font-medium text-gray-500 uppercase mb-3">Info User</h4>
                <div class="space-y-2">
                    <div>
                        <label class="text-sm text-gray-600">Nama</label>
                        <p class="font-medium">{{ $payment->user->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Email</label>
                        <p class="font-medium">{{ $payment->user->email }}</p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.users.show', $payment->user) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                            Lihat detail user →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Orders -->
    @if($relatedOrders->count() > 0)
    <div class="bg-white p-6 rounded-lg shadow">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Orders Terkait (Status Pending)</h4>
        
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($relatedOrders as $order)
                    <tr>
                        <td class="px-4 py-4 text-sm font-medium text-gray-900">{{ $order->order_number }}</td>
                        <td class="px-4 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-4">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-900 text-sm">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Verification Actions -->
    @if($payment->status == 'waiting')
    <div class="bg-white p-6 rounded-lg shadow">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Verifikasi Pembayaran</h4>
        
        <form method="POST" action="{{ route('admin.payments.update-status', $payment) }}" class="space-y-4">
            @csrf
            @method('PATCH')
            
            @if($relatedOrders->count() > 0)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Order yang Dibayar (Opsional)</label>
                <select name="order_id" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">-- Pilih Order --</option>
                    @foreach($relatedOrders as $order)
                    <option value="{{ $order->id }}">{{ $order->order_number }} - Rp {{ number_format($order->total_amount, 0, ',', '.') }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin (Opsional)</label>
                <textarea name="admin_notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
            </div>
            
            <div class="flex space-x-4">
                <button type="submit" name="status" value="success" class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                    Setujui Pembayaran
                </button>
                <button type="submit" name="status" value="failed" class="px-6 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                    Tolak Pembayaran
                </button>
            </div>
        </form>
    </div>
    @endif
</div>

<div class="mt-6">
    <a href="{{ route('admin.payments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
        ← Kembali ke Daftar Pembayaran
    </a>
</div>
@endsection