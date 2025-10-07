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
                    @if($item->product)
                        <img src="{{ asset('storage/' . $item->product->image_url) }}" 
                             alt="{{ $item->product->name }}" 
                             class="w-16 h-16 rounded-lg object-cover">
                    @else
                        <div class="w-16 h-16 rounded-lg bg-gray-200 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                    
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
        @if($order->status == 'completed')
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mt-6">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-green-800 mb-1">Pesanan Selesai</h4>
                            <p class="text-sm text-green-700">
                                Terima kasih telah menggunakan layanan kami! Bagaimana pengalaman Anda?
                            </p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('profile.orders.review', $order->id) }}" 
                   class="inline-flex items-center px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    Beri Ulasan Produk
                </a>
            </div>
        @elseif($order->status == 'waiting_verification')
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