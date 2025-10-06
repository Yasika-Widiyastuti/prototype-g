@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('profile.orders') }}" 
               class="flex items-center text-blue-600 hover:text-blue-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Pesanan Saya
            </a>
        </div>

        <!-- Order Header -->
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800">{{ $order->order_number }}</h2>
                    <p class="text-gray-600">Tanggal: {{ $order->created_at->format('d M Y H:i') }}</p>
                </div>
                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $order->status_badge }}">
                    {{ $order->status_text }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Total Pembayaran</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $order->total_amount_formatted }}</p>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Tanggal Rental</h3>
                    <p class="text-lg text-gray-800">{{ $order->rental_date->format('d M Y') }}</p>
                    <p class="text-sm text-gray-600">{{ $order->rental_days }} hari</p>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-700 mb-2">Metode Pembayaran</h3>
                    <p class="text-lg text-gray-800">{{ $order->payment_method ?? 'Belum dipilih' }}</p>
                </div>
            </div>

            @if($order->notes)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <h3 class="font-semibold text-gray-700 mb-2">Catatan</h3>
                <p class="text-gray-600">{{ $order->notes }}</p>
            </div>
            @endif
        </div>

        <!-- Order Items -->
        @if($order->orderItems->count() > 0)
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Produk yang Dipesan</h3>
            
            <div class="space-y-4">
                @foreach($order->orderItems as $item)
                <div class="flex items-center space-x-4 py-4 border-b border-gray-200 last:border-b-0">
                    <img src="{{ $item->product->image_url ?? 'https://via.placeholder.com/64' }}" 
                         alt="{{ $item->product->name ?? 'Product' }}" 
                         class="w-16 h-16 rounded-lg object-cover">
                    
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-800">{{ $item->product->name ?? 'Product Name' }}</h4>
                        <p class="text-sm text-gray-600">{{ ucfirst($item->product->category ?? 'category') }}</p>
                        <p class="text-sm text-gray-600">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    
                    <div class="text-right">
                        <p class="font-semibold text-gray-800">Rp {{ number_format($item->total, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="border-t border-gray-200 pt-4 mt-4">
                <div class="flex justify-between items-center text-lg font-semibold">
                    <span>Total:</span>
                    <span>{{ $order->total_amount_formatted }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Actions -->
        @if($order->status == 'waiting_verification')
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Pesanan</h3>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-yellow-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-yellow-800 mb-1">Menunggu Verifikasi Admin</h4>
                            <p class="text-sm text-yellow-700">
                                Bukti pembayaran Anda sedang diverifikasi. Proses ini biasanya memakan waktu 1-2 jam kerja.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($order->status == 'confirmed')
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mt-6">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-green-800 mb-1">Pembayaran Dikonfirmasi</h4>
                            <p class="text-sm text-green-700">
                                Pembayaran Anda telah diverifikasi. Tim kami akan segera menghubungi Anda untuk pengambilan barang.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection