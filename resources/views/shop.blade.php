@extends('layouts.app')

@section('title', 'Shop - Sewa Barang Konser Terlengkap')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#D5DEEF] to-[#B1C9EF]">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-[#395886] to-[#2d4a6b] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Sewa Barang Konser Terlengkap</h1>
                <p class="text-xl text-[#B1C9EF]">Temukan peralatan terbaik untuk konser dan acara Anda</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Filter Sidebar -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-4">
                    <h3 class="text-lg font-semibold mb-6 text-[#2d4a6b]">Filter Produk</h3>
                    
                    <form method="GET" id="filterForm" class="space-y-6">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-medium text-[#2d4a6b] mb-2">Cari Produk</label>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Masukkan nama produk..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#395886] focus:border-[#395886]">
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label class="block text-sm font-medium text-[#2d4a6b] mb-2">Kategori</label>
                            <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#395886] focus:border-[#395886]">
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
                            <label class="block text-sm font-medium text-[#2d4a6b] mb-2">Rentang Harga (per hari)</label>
                            <div class="grid grid-cols-2 gap-3">
                                <input type="number" 
                                       name="min_price" 
                                       value="{{ request('min_price') }}"
                                       placeholder="Min"
                                       class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#395886]">
                                <input type="number" 
                                       name="max_price" 
                                       value="{{ request('max_price') }}"
                                       placeholder="Max"
                                       class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#395886]">
                            </div>
                            <p class="text-xs text-[#395886] mt-2">
                                Range: Rp {{ number_format($priceRange['min'], 0, ',', '.') }} - Rp {{ number_format($priceRange['max'], 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Sort Options -->
                        <div>
                            <label class="block text-sm font-medium text-[#2d4a6b] mb-2">Urutkan</label>
                            <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#395886] focus:border-[#395886]">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-[#395886] text-white py-3 rounded-lg hover:bg-[#2d4a6b] transition duration-200 font-semibold">
                            Terapkan Filter
                        </button>
                        
                        @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'sort']))
                            <a href="{{ route('shop') }}" class="w-full mt-2 block text-center bg-[#D5DEEF] text-[#395886] py-3 rounded-lg hover:bg-[#B1C9EF] transition duration-200 font-medium">
                                Reset Filter
                            </a>
                        @endif
                    </form>

                    <!-- Quick Category Links -->
                    <div class="mt-8 pt-6 border-t border-[#9db8e0]">
                        <h4 class="text-sm font-semibold text-[#2d4a6b] mb-3">Kategori Populer</h4>
                        <div class="space-y-2">
                            <a href="{{ route('handphone.index') }}" class="block text-[#395886] hover:text-[#2d4a6b] text-sm font-medium transition">
                                📱 Handphone
                            </a>
                            <a href="{{ route('lightstick.index') }}" class="block text-[#395886] hover:text-[#2d4a6b] text-sm font-medium transition">
                                💡 Lightstick
                            </a>
                            <a href="{{ route('powerbank.index') }}" class="block text-[#395886] hover:text-[#2d4a6b] text-sm font-medium transition">
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
                        <h2 class="text-2xl font-bold text-[#2d4a6b]">
                            @if(request('category'))
                                {{ ucfirst(request('category')) }}
                            @elseif(request('search'))
                                Hasil pencarian "{{ request('search') }}"
                            @else
                                Semua Produk
                            @endif
                        </h2>
                        <p class="text-[#395886] mt-1">
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
                                    <h3 class="text-xl font-semibold text-[#2d4a6b] mb-2 line-clamp-2">
                                        {{ $product->name }}
                                    </h3>
                                    
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        {{ Str::limit($product->description, 100) }}
                                    </p>
                                    
                                    @if($product->features && count($product->features) > 0)
                                        <div class="flex flex-wrap gap-1 mb-4">
                                            @foreach(array_slice($product->features, 0, 2) as $feature)
                                                <span class="text-xs bg-[#D5DEEF] text-[#395886] px-2 py-1 rounded-full">
                                                    {{ $feature }}
                                                </span>
                                            @endforeach
                                            @if(count($product->features) > 2)
                                                <span class="text-xs text-[#395886]">+{{ count($product->features) - 2 }}</span>
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
                                           class="bg-[#395886] text-white px-6 py-2 rounded-lg hover:bg-[#2d4a6b] transition duration-200 font-semibold">
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
                    <div class="bg-white rounded-xl shadow-lg p-16 text-center">
                        <svg class="w-24 h-24 mx-auto text-[#9db8e0] mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8v-.5A1.5 1.5 0 0018.5 4h-3A1.5 1.5 0 0014 5.5V6m-4 0V5.5A1.5 1.5 0 008.5 4h-3A1.5 1.5 0 004 5.5V6m4 0V7a2 2 0 002 2h4a2 2 0 002-2V6"></path>
                        </svg>
                        <h3 class="text-2xl font-semibold text-[#2d4a6b] mb-2">Tidak ada produk ditemukan</h3>
                        <p class="text-[#395886] mb-6">Coba ubah filter atau kata kunci pencarian Anda.</p>
                        <a href="{{ route('shop') }}" class="inline-block bg-[#395886] text-white px-6 py-3 rounded-lg hover:bg-[#2d4a6b] transition duration-200 font-semibold">
                            Lihat Semua Produk
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom pagination styles */
    .pagination {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        align-items: center;
    }
    
    .pagination a,
    .pagination span {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        border: 1px solid #9db8e0;
        transition: all 0.2s;
    }
    
    .pagination a {
        background-color: white;
        color: #395886;
    }
    
    .pagination a:hover {
        background-color: #D5DEEF;
        border-color: #395886;
    }
    
    .pagination .active span {
        background-color: #395886;
        color: white;
        border-color: #395886;
    }
    
    .pagination .disabled span {
        background-color: #f3f4f6;
        color: #9ca3af;
        cursor: not-allowed;
    }
</style>

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