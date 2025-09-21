@extends('layouts.app')

@section('title', 'Keranjang & Checkout - Sewa Barang Konser')
@section('description', 'Review pesanan dan lanjutkan ke pembayaran.')

@section('breadcrumbs')
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <span class="text-gray-500">Checkout</span>
</li>
@endsection

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center">
                    <div class="flex items-center text-blue-600">
                        <div class="flex-shrink-0 w-8 h-8 border-2 border-blue-600 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-medium">
                            1
                        </div>
                        <span class="ml-4 text-sm font-medium">Review Pesanan</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-gray-200 mx-4"></div>
                    <div class="flex items-center text-gray-400">
                        <div class="flex-shrink-0 w-8 h-8 border-2 border-gray-300 rounded-full flex items-center justify-center text-sm font-medium">
                            2
                        </div>
                        <span class="ml-4 text-sm font-medium">Pembayaran</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-gray-200 mx-4"></div>
                    <div class="flex items-center text-gray-400">
                        <div class="flex-shrink-0 w-8 h-8 border-2 border-gray-300 rounded-full flex items-center justify-center text-sm font-medium">
                            3
                        </div>
                        <span class="ml-4 text-sm font-medium">Konfirmasi</span>
                    </div>
                </div>
            </div>

            <!-- Cart Items -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Detail Pesanan</h2>

                @if(empty($cartItems))
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.195.195-.195.512 0 .707L7 18h12M9 19a2 2 0 100 4 2 2 0 000-4zM20 19a2 2 0 100 4 2 2 0 000-4z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Keranjang kosong</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan produk ke keranjang.</p>
                    <div class="mt-6">
                        <a href="{{ route('shop') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Lihat Produk
                        </a>
                    </div>
                </div>
                @else
                <div class="space-y-4">
                    @foreach($cartItems as $item)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded">
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ $item['name'] }}</h3>
                                <p class="text-sm text-gray-500">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-gray-900">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Order Summary -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pembayaran</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Biaya Admin</span>
                        <span class="text-gray-900">Rp 5.000</span>
                    </div>
                    <div class="border-t border-gray-300 pt-2">
                        <div class="flex justify-between">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            <span class="text-lg font-bold text-blue-600">Rp {{ number_format($total + 5000, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between">
                <a href="{{ route('shop') }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-6 py-3 rounded-lg transition">
                    Lanjut Belanja
                </a>
                <a href="{{ route('payment') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg transition">
                    Lanjut ke Pembayaran
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
