@extends('admin.layouts2.app2')

@section('title', 'Detail Produk - Admin Panel')
@section('page-title', 'Detail Produk')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <h2 class="text-xl font-semibold mb-4">{{ $product->name }}</h2>

    <div class="mb-4">
        <img src="{{ asset('storage/' . $product->image_url) }}" 
             alt="{{ $product->name }}" 
             class="w-full h-auto rounded"
             onerror="this.src='{{ asset('images/placeholder.png') }}'">
    </div>

    <p><strong>Kategori:</strong> {{ $product->category }}</p>
    <p><strong>Harga Sewa:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
    <p><strong>Stok:</strong> {{ $product->stock }}</p>
    <p><strong>Deskripsi:</strong> {{ $product->description }}</p>

    @if($product->features)
        <p><strong>Fitur:</strong> {{ implode(', ', $product->features) }}</p>
    @endif

    <p><strong>Status:</strong> {{ $product->is_available ? 'Tersedia' : 'Tidak tersedia' }}</p>

    <a href="{{ route('admin.products.index') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Kembali</a>
</div>
@endsection