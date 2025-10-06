@extends('layouts.app')

@section('title', $product['name'] . ' - Sewa Lightstick')
@section('description', 'Sewa ' . $product['name'] . ' untuk konser K-Pop impian Anda.')

@section('breadcrumbs')
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <a href="{{ route('lightstick.index') }}" class="text-gray-500 hover:text-gray-700">Lightstick</a>
</li>
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <span class="text-gray-500">{{ $product['name'] }}</span>
</li>
@endsection

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Product Details -->
        <div class="bg-white p-8 rounded-xl shadow-lg mb-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Product Image -->
                <div>
                    <img src="{{ asset('storage/' . $product['image']) }}" 
                             alt="{{ $product['name'] }}"
                             class="w-full h-auto rounded-lg shadow-md object-cover">
                </div>

                <!-- Product Info -->
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product['name'] }}</h1>
                    <p class="text-gray-600 mb-6 leading-relaxed">{{ $product['description'] }}</p>
                    <p class="text-2xl font-bold text-blue-600 mb-6">
                        Rp {{ number_format($product['price'], 0, ',', '.') }} 
                        <span class="text-sm text-gray-500 font-normal">/ hari</span>
                    </p>
                    
                    {{-- Informasi Stok dihapus untuk menghindari error "Undefined array key 'stock'" --}}
                    
                    @auth
                        <form action="{{ route('cart.add.lightstick', $product['id']) }}" 
                              method="POST" 
                              id="addToCartForm">
                            @csrf
                            <button type="button" 
                                    class="inline-block bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                    id="addToCartBtn">
                                {{-- Tombol selalu menampilkan 'Tambah ke Keranjang' --}}
                                Tambah ke Keranjang
                            </button>
                        </form>
                    @else
                        <a href="{{ route('signIn') }}" 
                           class="inline-block bg-gray-500 text-white font-semibold px-6 py-3 rounded-lg hover:bg-gray-600 transition">
                            Login untuk Menyewa
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Product Specifications -->
            <div class="mt-12 border-t border-gray-200 pt-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Spesifikasi Produk</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-800 mb-2">Kondisi</h4>
                        <p class="text-gray-600">Mulus, terawat dengan baik</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-800 mb-2">Kelengkapan</h4>
                        <p class="text-gray-600">Baterai, charger</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-800 mb-2">Baterai</h4>
                        <p class="text-gray-600">Kondisi prima, tahan lama</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-800 mb-2">Garansi</h4>
                        <p class="text-gray-600">Garansi selama masa sewa</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Reviews -->
        <div class="bg-white p-8 rounded-xl shadow-lg mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Ulasan Pelanggan</h2>
            
            @if($reviews->count() > 0)
                <div class="space-y-6">
                    @foreach($reviews as $review)
                        <div class="bg-gray-50 p-6 rounded-lg shadow">
                            <div class="flex items-center mb-3">
                                <div class="flex">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <svg class="w-5 h-5 text-yellow-500 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="ml-2 font-semibold text-gray-800">
                                    {{ $review->rating }}/5 - {{ $review->user_name }}
                                </span>
                            </div>
                            <p class="text-gray-600">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Belum ada ulasan untuk produk ini</p>
            @endif
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="bg-white p-8 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Produk Terkait</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedProducts as $related)
                <div class="bg-gray-50 p-4 rounded-lg shadow hover:shadow-lg transition hover-lift">
                    <img src="{{ asset('storage/' . $related['image']) }}" 
                            alt="{{ $related['name'] }}"
                            class="w-full h-48 object-cover rounded">
                    <h3 class="mt-4 font-semibold text-gray-900">{{ $related['name'] }}</h3>
                    <p class="text-blue-600 font-bold mt-2">
                        Rp {{ number_format($related['price'], 0, ',', '.') }} / hari
                    </p>
                    <a href="{{ route('lightstick.show', $related['id']) }}"
                       class="mt-3 inline-block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded transition">
                        Lihat Detail
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
(function() {
    'use strict';
    
    const btn = document.getElementById('addToCartBtn');
    const form = document.getElementById('addToCartForm');
    
    if (!btn || !form) {
        console.warn('Add to cart button or form not found');
        return;
    }
    
    // Logika pengecekan stok yang menonaktifkan tombol dihapus. Tombol selalu aktif.
    
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        
        const originalText = btn.innerHTML;
        const originalClass = btn.className;
        
        // Show loading state
        btn.innerHTML = '<svg class="animate-spin h-5 w-5 text-white inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Menambahkan...';
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error('CSRF token not found');
            if (typeof showNotification === 'function') {
                showNotification('Error: CSRF token tidak ditemukan', 'error');
            }
            btn.innerHTML = originalText;
            btn.disabled = false;
            btn.className = originalClass;
            return;
        }
        
        // Submit via fetch
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken.content
            },
            credentials: 'same-origin'
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Content-Type:', response.headers.get('content-type'));
            
            // Check content type
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Response bukan JSON. Kemungkinan terjadi redirect atau error server.');
            }
            
            // Parse JSON
            return response.json().then(data => {
                if (!response.ok) {
                    throw new Error(data.message || `HTTP ${response.status}: ${response.statusText}`);
                }
                return data;
            });
        })
        .then(data => {
            console.log('Success data:', data);
            
            if (data.success) {
                // Update cart counter menggunakan fungsi global
                if (typeof updateCartCounter === 'function') {
                    updateCartCounter(data.cart_count || 0);
                    console.log('Cart counter updated to:', data.cart_count);
                } else {
                    console.warn('updateCartCounter function not found');
                }
                
                // Show success message
                const qty = data.product_quantity || 1;
                btn.innerHTML = `<svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Ditambahkan! (Qty: ${qty})`;
                btn.className = 'inline-block bg-green-600 text-white font-semibold px-6 py-3 rounded-lg';
                
                // Show notification
                if (typeof showNotification === 'function') {
                    showNotification(data.message || 'Produk berhasil ditambahkan ke keranjang!', 'success');
                }
                
                // Reset button after 3 seconds
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    btn.className = originalClass;
                    btn.classList.remove('opacity-75', 'cursor-not-allowed');
                }, 3000);
            } else {
                throw new Error(data.message || 'Gagal menambahkan ke keranjang');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            
            // Show error notification
            if (typeof showNotification === 'function') {
                showNotification(error.message || 'Terjadi kesalahan. Silakan coba lagi.', 'error');
            } else {
                alert('Error: ' + (error.message || 'Terjadi kesalahan'));
            }
            
            // Reset button
            btn.innerHTML = originalText;
            btn.disabled = false;
            btn.className = originalClass;
            btn.classList.remove('opacity-75', 'cursor-not-allowed');
        });
    });
})();
</script>
@endpush
@endsection
