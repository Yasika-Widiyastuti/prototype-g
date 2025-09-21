@extends('admin.layouts2.app2')

@section('title', 'Edit Produk - Admin Panel')
@section('page-title', 'Edit Produk')

@section('content')
<div class="mb-6">
    <div class="flex items-center">
        <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <h2 class="text-xl font-semibold text-gray-800">Edit Produk: {{ $product->name }}</h2>
    </div>
</div>

<div class="max-w-2xl">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama Produk -->
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Produk <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                       placeholder="Masukkan nama produk">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select id="category" name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('category') border-red-500 @enderror">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category', $product->category) == $cat ? 'selected' : '' }}>
                            {{ ucfirst($cat) }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Harga -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                    Harga Sewa (per hari) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" min="0" step="1000"
                           class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-500 @enderror"
                           placeholder="50000">
                </div>
                @error('price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stok -->
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                    Stok <span class="text-red-500">*</span>
                </label>
                <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('stock') border-red-500 @enderror"
                       placeholder="1">
                @error('stock')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- URL Gambar -->
            <div>
                <label for="image_url" class="block text-sm font-medium text-gray-700 mb-2">
                    URL Gambar <span class="text-red-500">*</span>
                </label>
                <input type="url" id="image_url" name="image_url" value="{{ old('image_url', $product->image_url) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image_url') border-red-500 @enderror"
                       placeholder="https://example.com/gambar.jpg">
                @error('image_url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi <span class="text-red-500">*</span>
                </label>
                <textarea id="description" name="description" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                          placeholder="Masukkan deskripsi produk">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Features -->
            <div class="md:col-span-2">
                <label for="features" class="block text-sm font-medium text-gray-700 mb-2">
                    Fitur (pisahkan dengan koma)
                </label>
                <input type="text" id="features" name="features" value="{{ old('features', implode(', ', $product->features ?? [])) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Bluetooth, Wireless, Fast Charging">
                @error('features')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="md:col-span-2">
                <div class="flex items-center">
                    <input type="checkbox" id="is_available" name="is_available" value="1"
                           {{ old('is_available', $product->is_available) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_available" class="ml-2 block text-sm text-gray-900">
                        Produk tersedia untuk disewa
                    </label>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex items-center justify-end space-x-4">
            <a href="{{ route('admin.products.index') }}"
               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500">
                Batal
            </a>
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Update Produk
            </button>
        </div>
    </form>
</div>
@endsection
