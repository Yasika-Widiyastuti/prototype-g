@extends('layouts.app')

@section('title', 'Semua Produk - Sewa Barang Konser')
@section('description', 'Jelajahi semua produk sewa peralatan konser kami.')

@section('breadcrumbs')
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <span class="text-gray-500">Semua Produk</span>
</li>
@endsection

@auth
    @if(auth()->user()->isVerified())
        <a href="{{ route('checkout.index', $product) }}" class="btn-sewa">Sewa Sekarang</a>
    @endif
@else
    <a href="{{ route('signIn') }}" class="btn-sewa">Login untuk Sewa</a>
@endauth

@section('content')
<div class="py-12 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Semua Produk</h1>
            <p class="text-lg text-gray-600">Temukan peralatan konser terbaik untuk acara Anda</p>
        </div>

        <!-- Search & Filter -->
        <div class="mb-8 bg-white rounded-lg shadow-md p-6">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ $search }}"
                           placeholder="Cari produk..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>
                <button type="submit" 
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg font-medium transition">
                    Cari
                </button>
            </form>
        </div>

        <!-- Categories -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Lightstick Category -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center hover-lift">
                <img src="https://i.pinimg.com/736x/25/75/0c/25750c5e579f700b2c013409855fc05d.jpg" 
                     alt="Lightstick" 
                     class="w-full h-48 object-cover rounded-lg mb-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Lightstick</h3>
                <p class="text-gray-600 mb-6">Lightstick official berbagai grup K-Pop</p>
                <a href="{{ route('lightstick.index') }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg transition">
                    Lihat Produk
                </a>
            </div>

            <!-- Powerbank Category -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center hover-lift">
                <img src="https://i.pinimg.com/736x/5f/cc/fa/5fccfa0ce0b93cda5c9d6de528264b6d.jpg" 
                     alt="Powerbank" 
                     class="w-full h-48 object-cover rounded-lg mb-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Powerbank</h3>
                <p class="text-gray-600 mb-6">Powerbank berkualitas kapasitas besar</p>
                <a href="{{ route('powerbank.index') }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg transition">
                    Lihat Produk
                </a>
            </div>

            <!-- Handphone Category -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center hover-lift">
                <img src="https://i.pinimg.com/1200x/f1/c0/49/f1c04910d57fb58252c9c857c4433366.jpg" 
                     alt="Handphone" 
                     class="w-full h-48 object-cover rounded-lg mb-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Handphone</h3>
                <p class="text-gray-600 mb-6">Smartphone dengan kamera berkualitas</p>
                <a href="{{ route('handphone.index') }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg transition">
                    Lihat Produk
                </a>
            </div>
        </div>
    </div>
</div>
@endsection