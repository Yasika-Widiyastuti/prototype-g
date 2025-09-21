@extends('admin.layouts2.app2')

@section('title', 'Laporan Produk - Admin Panel')
@section('page-title', 'Laporan Produk')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-lg font-semibold text-gray-800 mb-6">Laporan Produk</h3>

    <div class="mb-6">
        <p class="text-xl font-semibold text-gray-900">Total Produk Tersedia:</p>
        <p class="text-3xl font-bold text-blue-600">{{ $totalProducts }}</p>
    </div>

    <div class="mt-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Produk Terlaris Bulan Ini:</h4>
        <ul class="list-disc pl-6">
            @foreach($bestSellingProducts as $product)
                <li class="mb-2">
                    <span class="font-semibold">{{ $product->name }}</span> - 
                    Terjual {{ $product->total_sales }} unit
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
