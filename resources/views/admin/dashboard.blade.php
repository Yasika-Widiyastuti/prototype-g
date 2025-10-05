@extends('admin.layouts2.app2')

@section('title', 'Dashboard Admin - Sewa Barang Konser')
@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Card -->
<div class="mb-6 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-lg p-6 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h1>
            <p class="text-blue-100">Berikut adalah ringkasan sistem rental Anda hari ini</p>
        </div>
        <div class="hidden lg:block">
            <svg class="w-20 h-20 text-white opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
        </div>
    </div>
</div>

<!-- Main Stats Cards - Product Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Produk Tersedia -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-green-100 dark:bg-green-900/20 rounded-lg">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Tersedia</span>
        </div>
        <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $stock_summary['available'] }}</div>
        <p class="text-sm text-gray-600 dark:text-gray-400">Produk Siap Sewa</p>
    </div>

    <!-- Produk Habis -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-red-100 dark:bg-red-900/20 rounded-lg">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Habis</span>
        </div>
        <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $stock_summary['out_of_stock'] }}</div>
        <p class="text-sm text-gray-600 dark:text-gray-400">Produk dengan Stok Kosong</p>
    </div>
</div>

<!-- Top 5 Most Rented Products -->
@if(isset($top_rented_products) && $top_rented_products->count() > 0)
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <div class="p-3 bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-lg mr-3">
                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Top 5 Produk Paling Banyak Disewa</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Produk terpopuler bulan ini</p>
            </div>
        </div>
        <a href="{{ route('admin.products.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm font-medium">
            Lihat Semua
        </a>
    </div>
    
    <div class="space-y-3">
        @foreach($top_rented_products as $index => $item)
        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-indigo-50 dark:from-slate-700/30 dark:to-indigo-900/10 rounded-lg hover:shadow-md transition-all">
            <div class="flex items-center space-x-4 flex-1">
                <div class="flex items-center justify-center w-10 h-10 rounded-full {{ $index === 0 ? 'bg-gradient-to-r from-yellow-400 to-orange-400' : ($index === 1 ? 'bg-gradient-to-r from-gray-300 to-gray-400' : ($index === 2 ? 'bg-gradient-to-r from-orange-400 to-orange-500' : 'bg-gradient-to-r from-indigo-500 to-purple-500')) }} text-white font-bold text-sm">
                    #{{ $index + 1 }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                        {{ $item->product->name }}
                    </p>
                    <div class="flex items-center mt-1 space-x-4">
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            Stok: <span class="font-medium {{ $item->product->stock <= 5 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">{{ $item->product->stock }}</span>
                        </span>
                        <span class="text-xs text-gray-400">•</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            Harga: <span class="font-medium">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="text-right ml-4">
                <div class="flex items-center justify-end space-x-2">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $item->rental_count }}</p>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">kali disewa</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Low Stock Alert with Product List -->
@if(isset($low_stock_products) && $low_stock_products->count() > 0)
<div class="bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/10 dark:to-orange-900/10 rounded-xl shadow-sm border-2 border-yellow-300 dark:border-yellow-700 p-6 mb-6">
    <div class="flex items-start mb-4">
        <div class="flex-shrink-0">
            <div class="p-2 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg">
                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
        </div>
        <div class="ml-4 flex-1">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                ⚠️ {{ $stock_summary['low_stock'] }} Produk Stok Menipis
            </h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Produk berikut memiliki stok terbatas dan perlu segera diisi ulang
            </p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mt-4">
        @foreach($low_stock_products as $product)
        <div class="bg-white dark:bg-slate-800 rounded-lg p-4 border border-yellow-200 dark:border-yellow-800 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                        {{ $product->name }}
                    </p>
                    <div class="flex items-center mt-1">
                        <span class="text-xs text-gray-500 dark:text-gray-400">Stok:</span>
                        <span class="ml-1 text-sm font-bold {{ $product->stock <= 2 ? 'text-red-600 dark:text-red-400' : 'text-yellow-600 dark:text-yellow-400' }}">
                            {{ $product->stock }} unit
                        </span>
                    </div>
                </div>
                <a href="{{ route('admin.products.edit', $product->id) }}" class="ml-2 text-yellow-600 dark:text-yellow-400 hover:text-yellow-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </a>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-4 text-center">
        <a href="{{ route('admin.products.index') }}?filter=low_stock" class="inline-flex items-center text-sm font-medium text-yellow-700 dark:text-yellow-400 hover:underline">
            Lihat Semua Produk Stok Menipis
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
</div>
@endif

<!-- Order & Revenue Insights -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Pesanan Hari Ini -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-cyan-100 dark:bg-cyan-900/20 rounded-lg">
                <svg class="w-6 h-6 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Hari Ini</span>
        </div>
        <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $stats['today_orders'] ?? 0 }}</div>
        <p class="text-sm text-gray-600 dark:text-gray-400">Pesanan Hari Ini</p>
    </div>

    <!-- Pesanan Bulan Ini -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $stats['total_orders'] }}</div>
        <p class="text-sm text-gray-600 dark:text-gray-400">Total Pesanan Bulan Ini</p>
        @if(isset($stats['pending_orders']) && $stats['pending_orders'] > 0)
        <div class="mt-3 text-xs text-yellow-600 dark:text-yellow-400 font-medium">
            {{ $stats['pending_orders'] }} pending verifikasi
        </div>
        @endif
    </div>

    <!-- Pendapatan Bulan Ini -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-emerald-100 dark:bg-emerald-900/20 rounded-lg">
                <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Bulan Ini</span>
        </div>
        <div class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Rp {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}</div>
        <p class="text-sm text-gray-600 dark:text-gray-400">Pendapatan Bulan Ini</p>
    </div>

    <!-- Total Customer -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-purple-100 dark:bg-purple-900/20 rounded-lg">
                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <a href="{{ route('admin.users.index') }}" class="text-purple-600 dark:text-purple-400 hover:underline">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $stats['total_users'] }}</div>
        <p class="text-sm text-gray-600 dark:text-gray-400">Total Customer</p>
        @if(isset($stats['new_customers_today']) && $stats['new_customers_today'] > 0)
        <div class="mt-3 text-xs text-green-600 dark:text-green-400 font-medium">
            +{{ $stats['new_customers_today'] }} customer baru hari ini
        </div>
        @endif
    </div>
</div>

<!-- Recent Activity & Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Recent Orders -->
    <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pesanan Terbaru</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Lihat Semua</a>
            </div>
        </div>
        <div class="p-6">
            @if(isset($recent_orders) && $recent_orders->count() > 0)
            <div class="space-y-4">
                @foreach($recent_orders as $order)
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                            {{ substr($order->user->name ?? 'U', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $order->user->name ?? 'Unknown' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $order->product->name ?? 'N/A' }} • {{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</p>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
                                'confirmed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400',
                                'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                                'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400',
                            ];
                            $statusClass = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full {{ $statusClass }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="text-sm font-medium">Belum ada pesanan</p>
                <p class="text-xs mt-1">Pesanan akan muncul di sini</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
        </div>
        <div class="p-6 space-y-3">
            <a href="{{ route('admin.products.create') }}" class="flex items-center p-4 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg text-white hover:shadow-lg transition-all">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <div>
                    <p class="font-semibold">Tambah Produk</p>
                    <p class="text-xs text-green-100">Tambah produk baru</p>
                </div>
            </a>

            <a href="{{ route('admin.payments.index') }}" class="flex items-center p-4 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg text-white hover:shadow-lg transition-all">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="font-semibold">Verifikasi Pembayaran</p>
                    @if(isset($stats['pending_payments']) && $stats['pending_payments'] > 0)
                    <p class="text-xs text-blue-100">{{ $stats['pending_payments'] }} menunggu verifikasi</p>
                    @else
                    <p class="text-xs text-blue-100">Tidak ada pembayaran pending</p>
                    @endif
                </div>
            </a>

            <a href="{{ route('admin.audit.index') }}" class="flex items-center p-4 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg text-white hover:shadow-lg transition-all">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <div>
                    <p class="font-semibold">Audit Logs</p>
                    <p class="text-xs text-purple-100">Lihat aktivitas sistem</p>
                </div>
            </a>

            <a href="{{ route('admin.users.index') }}" class="flex items-center p-4 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-lg text-white hover:shadow-lg transition-all">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <div>
                    <p class="font-semibold">Kelola User</p>
                    <p class="text-xs text-cyan-100">Manage customers</p>
                </div>
            </a>
        </div>
    </div>
</div>

@endsection