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

@section('content')
<div class="py-12 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Semua Produk</h1>
            <p class="text-lg text-gray-600">Temukan peralatan konser terbaik untuk acara Anda</p>
        </div>

        <!-- Search Results or All Products -->
        @if($search)
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    Hasil Pencarian untuk "{{ $search }}" 
                    <span class="text-lg text-gray-600">({{ $products->count() }} produk)</span>
                </h2>
                <div class="mb-4">
                    <a href="{{ route('shop') }}" 
                       class="inline-flex items-center text-yellow-600 hover:text-yellow-700 font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Semua Produk
                    </a>
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($products as $product)
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-lift">
                                <img src="{{ $product->image_url }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-48 object-cover">
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-lg font-bold text-gray-900">{{ $product->name }}</h3>
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded">
                                            {{ ucfirst($product->category) }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 mb-4 line-clamp-2">{{ $product->description }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-2xl font-bold text-yellow-600">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                            <span class="text-sm text-gray-500">/hari</span>
                                        </span>
                                        @auth
                                            @if($product->category == 'handphone')
                                                <a href="{{ route('handphone.show', $product->id) }}" 
                                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition">
                                                    Detail
                                                </a>
                                            @elseif($product->category == 'lightstick')
                                                <a href="{{ route('lightstick.show', $product->id) }}" 
                                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition">
                                                    Detail
                                                </a>
                                            @elseif($product->category == 'powerbank')
                                                <a href="{{ route('powerbank.show', $product->id) }}" 
                                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition">
                                                    Detail
                                                </a>
                                            @endif
                                        @else
                                            <a href="{{ route('signIn') }}" 
                                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition">
                                                Detail
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow-md p-12 text-center">
                        <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Produk tidak ditemukan</h3>
                        <p class="text-gray-600 mb-6">Maaf, tidak ada produk yang cocok dengan pencarian "{{ $search }}"</p>
                        <a href="{{ route('shop') }}" 
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg font-medium transition inline-block">
                            Lihat Semua Produk
                        </a>
                    </div>
                @endif
            </div>
        @endif

        <!-- Categories (hanya tampil jika tidak ada search) -->
        @if(!$search)
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Kategori Produk</h2>
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
        @endif
    </div>
</div>
@endsection