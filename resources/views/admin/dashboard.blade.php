@extends('admin.layouts2.app2')

@section('title', 'Dashboard Admin - Sewa Barang Konser')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stats Cards -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Total Customer</p>
                <p class="text-2xl font-semibold">{{ $stats['total_users'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-full">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Total Produk</p>
                <p class="text-2xl font-semibold">{{ $stats['total_products'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-full">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Total Pesanan</p>
                <p class="text-2xl font-semibold">{{ $stats['total_orders'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-full">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Pendapatan Bulan Ini</p>
                <p class="text-2xl font-semibold">Rp {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Pesanan Terbaru</h3>
        </div>
        <div class="p-6">
            @if($recent_orders->count() > 0)
                <div class="space-y-4">
                    @foreach($recent_orders as $order)
                        <div class="flex items-center justify-between p-4 border rounded-lg">
                            <div>
                                <p class="font-semibold">{{ $order->order_number }}</p>
                                <p class="text-sm text-gray-600">{{ $order->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $order->status_badge }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Belum ada pesanan</p>
            @endif
        </div>
    </div>

    <!-- Low Stock Products -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Stok Menipis</h3>
        </div>
        <div class="p-6">
            @if($low_stock_products->count() > 0)
                <div class="space-y-4">
                    @foreach($low_stock_products as $product)
                        <div class="flex items-center justify-between p-4 border rounded-lg border-red-200 bg-red-50">
                            <div>
                                <p class="font-semibold">{{ $product->name }}</p>
                                <p class="text-sm text-gray-600">{{ ucfirst($product->category) }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex px-3 py-1 text-sm font-semibold text-red-800 bg-red-200 rounded-full">
                                    {{ $product->stock }} tersisa
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Semua produk stoknya aman</p>
            @endif
        </div>
    </div>
</div>
@endsection
