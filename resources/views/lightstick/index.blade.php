@extends('layouts.app')

@section('title', 'Sewa Lightstick - Sewa Barang Konser')
@section('description', 'Sewa lightstick official berbagai grup K-Pop untuk konser impian Anda. Kualitas terjamin, harga terjangkau.')

@section('breadcrumbs')
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <span class="text-gray-500">Lightstick</span>
</li>
@endsection

@section('content')
<!-- Hero Section -->
<section class="relative bg-gray-800 text-white h-64">
    <img src="https://i.pinimg.com/736x/25/75/0c/25750c5e579f700b2c013409855fc05d.jpg" 
         alt="Lightstick"
         class="absolute inset-0 w-full h-full object-cover opacity-40">
    <div class="relative container mx-auto text-center h-full flex flex-col justify-center items-center px-4">
        <h1 class="text-5xl font-extrabold mb-6">Sewa Lightstick</h1>
        <p class="max-w-xl mx-auto text-lg text-gray-200 mb-8">
            Pilih lightstick fandom Anda untuk konser yang tak terlupakan!
        </p>
    </div>
</section>

<!-- Product List -->
<div class="bg-white py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900 mb-6">Koleksi Lightstick</h2>
        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            @foreach($products as $product)
            <div class="group relative bg-gray-50 p-4 rounded-lg shadow hover:shadow-lg transition flex flex-col">
                <img src="{{ asset('storage/' . $product['image']) }}"
                    alt="{{ $product['name'] }}" 
                    class="aspect-square w-full rounded-md object-cover group-hover:opacity-90 lg:aspect-auto lg:h-80" />
                
                <div class="mt-4 flex-1 flex flex-col">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $product['name'] }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ $product['description'] }}</p>
                        </div>
                        <p class="text-md font-bold text-blue-600">Rp {{ number_format($product['price']) }} / hari</p>
                    </div>

                    {{-- Spacer biar tombol selalu di bawah --}}
                    <div class="flex-1"></div>

                    <a href="{{ route('lightstick.show', $product['id']) }}"
                    class="mt-4 inline-block w-full text-center bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition">
                    Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
