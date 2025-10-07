@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Keranjang Belanja</h1>
    
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if(empty($cartItems) || count($cartItems) === 0)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-8 text-center">
            <svg class="mx-auto h-16 w-16 text-yellow-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Keranjang Anda Masih Kosong</h3>
            <p class="text-gray-600 mb-6">Mulai berbelanja dan tambahkan produk ke keranjang Anda</p>
            <div class="flex gap-4 justify-center">
                <a href="{{ route('shop') }}" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Mulai Belanja
                </a>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Cart Items -->
            <div class="divide-y">
                @foreach($cartItems as $key => $item)
                    <div class="p-6 flex items-center gap-4 hover:bg-gray-50 transition">
                        <img src="{{ $item['image'] ?? '/images/default.jpg' }}" 
                             alt="{{ $item['name'] }}" 
                             class="w-24 h-24 object-cover rounded-lg border">
                        
                        <div class="flex-1">
                            <h3 class="font-semibold text-lg text-gray-800">{{ $item['name'] }}</h3>
                            <p class="text-gray-600 text-sm">{{ ucfirst($item['category'] ?? '') }}</p>
                            <p class="text-blue-600 font-medium mt-1">
                                Rp {{ number_format($item['price'], 0, ',', '.') }} / hari
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                Quantity: {{ $item['quantity'] }} | Durasi: {{ $item['duration'] }} hari
                            </p>
                        </div>
                        
                        <div class="text-right">
                            <p class="text-xl font-bold text-gray-800">
                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Total & Actions -->
            <div class="bg-gray-50 p-6 border-t">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-800">Total:</h3>
                    <p class="text-3xl font-bold text-blue-600">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </p>
                </div>
                
                <div class="flex gap-4">
                    <a href="{{ route('shop') }}" 
                       class="flex-1 bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition text-center font-medium">
                        Lanjut Belanja
                    </a>
                    <a href="{{ route('checkout.index') }}" 
                       class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition text-center font-medium">
                        Checkout
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection