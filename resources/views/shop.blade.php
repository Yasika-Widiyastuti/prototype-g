@extends('layouts.app')

@section('title', 'Shop - Sewa Barang Konser Terlengkap')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Sewa Barang Konser Terlengkap</h1>
                <p class="text-xl text-blue-100">Temukan peralatan terbaik untuk konser dan acara Anda</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Filter Sidebar -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-4">
                    <h3 class="text-lg font-semibold mb-6 text-gray-800">Filter Produk</h3>
                    
                    <form method="GET" id="filterForm" class="space-y-6">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Produk</label>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Masukkan nama produk..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat['value'] }}" {{ request('category') == $cat['value'] ? 'selected' : '' }}>
                                        {{ $cat['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rentang Harga (per hari)</label>
                            <div class="grid grid-cols-2 gap-3">
                                <input type="number" 
                                       name="min_price" 
                                       value="{{ request('min_price') }}"
                                       placeholder="Min"
                                       class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <input type="number" 
                                       name="max_price" 
                                       value="{{ request('max_price') }}"
                                       placeholder="Max"
                                       class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                Range: Rp {{ number_format($priceRange['min'], 0, ',', '.') }} - Rp {{ number_format($priceRange['max'], 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Sort Options -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                            <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition duration-200 font-semibold">
                            Terapkan Filter
                        </button>
                        
                        @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'sort']))
                            <a href="{{ route('shop') }}" class="w-full mt-2 block text-center bg-gray-200 text-gray-700 py-3 rounded-lg hover:bg-gray-300 transition duration-200">
                                Reset Filter
                            </a>
                        @endif
                    </form>

                    <!-- Quick Category Links -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Kategori Populer</h4>
                        <div class="space-y-2">
                            <a href="{{ route('handphone.index') }}" class="block text-blue-600 hover:text-blue-800 text-sm">
                                📱 Handphone
                            </a>
                            <a href="{{ route('lightstick.index') }}" class="block text-blue-600 hover:text-blue-800 text-sm">
                                💡 Lightstick
                            </a>
                            <a href="{{ route('powerbank.index') }}" class="block text-blue-600 hover:text-blue-800 text-sm">
                                🔋 Powerbank
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:w-3/4">
                <!-- Results Header -->
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            @if(request('category'))
                                {{ ucfirst(request('category')) }}
                            @elseif(request('search'))
                                Hasil pencarian "{{ request('search') }}"
                            @else
                                Semua Produk
                            @endif
                        </h2>
                        <p class="text-gray-600 mt-1">
                            Menampilkan {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} 
                            dari {{ $products->total() }} produk
                        </p>
                    </div>
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($products as $product)
                            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden group">
                                <div class="relative overflow-hidden">
                                    <img src="{{ $product->image_url }}" 
                                         alt="{{ $product->name }}"
                                         class="w-full h-56 object-cover group-hover:scale-110 transition duration-500">
                                    
                                    <!-- Category Badge -->
                                    <div class="absolute top-4 left-4">
                                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $product->category_badge }}">
                                            {{ ucfirst($product->category) }}
                                        </span>
                                    </div>

                                    <!-- Stock Badge -->
                                    <div class="absolute top-4 right-4">
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $product->stock_status['class'] }}">
                                            {{ $product->stock }} unit
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="p-6">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2 line-clamp-2">
                                        {{ $product->name }}
                                    </h3>
                                    
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        {{ Str::limit($product->description, 100) }}
                                    </p>
                                    
                                    @if($product->features && count($product->features) > 0)
                                        <div class="flex flex-wrap gap-1 mb-4">
                                            @foreach(array_slice($product->features, 0, 2) as $feature)
                                                <span class="text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded-full">
                                                    {{ $feature }}
                                                </span>
                                            @endforeach
                                            @if(count($product->features) > 2)
                                                <span class="text-xs text-gray-500">+{{ count($product->features) - 2 }}</span>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="text-2xl font-bold text-green-600">
                                                {{ $product->price_formatted }}
                                            </span>
                                            <span class="text-sm text-gray-500">/hari</span>
                                        </div>
                                        
                                        <a href="{{ route($product->category . '.show', $product->id) }}" 
                                           class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200 font-semibold">
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12 flex justify-center">
                        {{ $products->appends(request()->query())->links() }}
                    </div>

                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <svg class="w-24 h-24 mx-auto text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8v-.5A1.5 1.5 0 0018.5 4h-3A1.5 1.5 0 0014 5.5V6m-4 0V5.5A1.5 1.5 0 008.5 4h-3A1.5 1.5 0 004 5.5V6m4 0V7a2 2 0 002 2h4a2 2 0 002-2V6"></path>
                        </svg>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-2">Tidak ada produk ditemukan</h3>
                        <p class="text-gray-600 mb-6">Coba ubah filter atau kata kunci pencarian Anda.</p>
                        <a href="{{ route('shop') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                            Lihat Semua Produk
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // Auto submit form when filter changes
    document.querySelectorAll('select[name="category"], select[name="sort"]').forEach(function(element) {
        element.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });

    // Search with enter key
    document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('filterForm').submit();
        }
    });
</script>
@endsection