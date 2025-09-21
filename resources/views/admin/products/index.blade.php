@extends('admin.layouts2.app2')

@section('title', 'Manajemen Produk - Admin Panel')
@section('page-title', 'Manajemen Produk')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-800">Daftar Produk</h3>
        
        <!-- Add Product Button -->
        <a href="{{ route('admin.products.create') }}" 
           class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
            <i class="fas fa-plus mr-2"></i>Tambah Produk
        </a>
    </div>

    <!-- Filters -->
    <div class="mb-6">
        <form method="GET" class="flex flex-wrap gap-4">
            <!-- Category Filter -->
            <select name="category" class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                <option value="">Semua Kategori</option>
                @foreach($categories as $key => $label)
                    <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            <!-- Availability Filter -->
            <select name="availability" class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                <option value="">Semua Status</option>
                <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Tersedia</option>
                <option value="unavailable" {{ request('availability') == 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
                <option value="low_stock" {{ request('availability') == 'low_stock' ? 'selected' : '' }}>Stok Rendah</option>
                <option value="out_of_stock" {{ request('availability') == 'out_of_stock' ? 'selected' : '' }}>Habis</option>
            </select>

            <!-- Search -->
            <input type="text" name="search" placeholder="Cari produk..." 
                   value="{{ request('search') }}"
                   class="px-3 py-2 border border-gray-300 rounded-md text-sm">
            
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600">
                Filter
            </button>
            
            @if(request()->hasAny(['category', 'availability', 'search']))
                <a href="{{ route('admin.products.index') }}" 
                   class="px-4 py-2 bg-gray-500 text-white rounded-md text-sm hover:bg-gray-600">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg">
            <div class="text-2xl font-bold text-blue-600">{{ $products->total() }}</div>
            <div class="text-sm text-gray-600">Total Produk</div>
        </div>
        <div class="bg-green-50 p-4 rounded-lg">
            <div class="text-2xl font-bold text-green-600">
                {{ $products->where('is_available', true)->where('stock', '>', 0)->count() }}
            </div>
            <div class="text-sm text-gray-600">Tersedia</div>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg">
            <div class="text-2xl font-bold text-yellow-600">
                {{ $products->where('stock', '<=', 2)->where('is_available', true)->count() }}
            </div>
            <div class="text-sm text-gray-600">Stok Rendah</div>
        </div>
        <div class="bg-red-50 p-4 rounded-lg">
            <div class="text-2xl font-bold text-red-600">
                {{ $products->where('stock', 0)->count() }}
            </div>
            <div class="text-sm text-gray-600">Habis</div>
        </div>
    </div>

    <!-- Product Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12">
                                <img class="h-12 w-12 rounded-lg object-cover" 
                                     src="{{ $product->image_url }}" 
                                     alt="{{ $product->name }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($product->description, 50) }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $product->category_badge }}">
                            {{ ucfirst($product->category) }}
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $product->price_formatted }}</div>
                    </td>
                    <td class="px-4 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $product->stock }}</div>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $product->stock_status['class'] }}">
                            {{ $product->stock_status['label'] }}
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $product->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->is_available ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-4 py-4 text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.products.show', $product) }}" 
                               class="text-blue-600 hover:text-blue-900">Detail</a>
                            
                            <a href="{{ route('admin.products.edit', $product) }}" 
                               class="text-green-600 hover:text-green-900">Edit</a>
                            
                            <form method="POST" action="{{ route('admin.products.toggle-availability', $product) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                    {{ $product->is_available ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-12 text-center text-gray-500">
                        Tidak ada produk yang ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
@endsection