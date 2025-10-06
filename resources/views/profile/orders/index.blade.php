@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-4">
                <a href="{{ route('profile.orders') }}" class="text-blue-600 hover:text-blue-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Pesanan Saya</h1>
            </div>
        </div>

        <!-- Orders List -->
        @if($orders->count() > 0)
            <div class="space-y-4">
                @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $order->order_number }}</h3>
                            <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y H:i') }}</p>
                            <p class="text-sm text-gray-600">
                                Rental: {{ $order->rental_date->format('d M Y') }} 
                                ({{ $order->rental_days }} hari)
                            </p>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $order->status_badge }}">
                            {{ $order->status_text }}
                        </span>
                    </div>

                    <!-- Order Items Preview -->
                    @if($order->orderItems->count() > 0)
                    <div class="mb-4">
                        <div class="space-y-2">
                            @foreach($order->orderItems->take(2) as $item)
                            <div class="flex items-center space-x-3">
                                <img src="{{ $item->product->image_url ?? 'https://via.placeholder.com/40' }}" 
                                     alt="{{ $item->product->name ?? 'Product' }}" 
                                     class="w-10 h-10 rounded object-cover">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-800">{{ $item->product->name ?? 'Product Name' }}</p>
                                    <p class="text-xs text-gray-600">{{ $item->quantity }}x - Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @endforeach
                            
                            @if($order->orderItems->count() > 2)
                            <p class="text-xs text-gray-500">+{{ $order->orderItems->count() - 2 }} produk lainnya</p>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                        <div>
                            <p class="text-sm text-gray-600">Total Pembayaran</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $order->total_amount_formatted }}</p>
                        </div>
                        <div class="space-x-2">
                            <a href="{{ route('profile.orders.show', $order->id) }}" 
                               class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-800 mb-2">Belum Ada Pesanan</h3>
                <p class="text-gray-600 mb-4">Kamu belum pernah melakukan pemesanan.</p>
                <a href="{{ route('shop') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>
@endsection