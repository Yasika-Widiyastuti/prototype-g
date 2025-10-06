@extends('layouts.app')

@section('title', $product['name'] . ' - Sewa Powerbank')
@section('description', 'Sewa ' . $product['name'] . ' untuk kebutuhan charging di konser.')

@section('breadcrumbs')
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <a href="{{ route('powerbank.index') }}" class="text-gray-500 hover:text-gray-700">Powerbank</a>
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
        <div class="bg-white p-8 rounded-xl shadow-lg mb-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div>
                    <img src="{{ asset('storage/' . $product['image']) }}" 
                            alt="{{ $product['name'] }}"
                            class="w-full h-auto rounded-lg shadow-md">
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product['name'] }}</h1>
                    <p class="text-gray-600 mb-6">{{ $product['description'] }}</p>
                    <p class="text-2xl font-bold text-blue-600 mb-6">Rp {{ number_format($product['price'], 0, ',', '.') }} / hari</p>
                    
                    @auth
                        <form action="{{ route('cart.add.powerbank', $product['id']) }}" method="POST" id="addToCartForm">
                            @csrf
                            {{-- *** PERBAIKAN: type diubah dari "submit" menjadi "button" *** --}}
                            <button type="button" 
                                    class="inline-block bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-blue-700 transition"
                                    id="addToCartBtn">
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
        </div>
        <!-- Customer Reviews -->
        <div class="bg-white p-8 rounded-xl shadow-lg mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Ulasan Pelanggan</h2>
            <div class="space-y-6">
                @foreach($reviews as $review)
                    <div class="bg-gray-50 p-6 rounded-lg shadow">
                        <div class="flex items-center mb-3">
                            <div class="flex">
                                {{-- Loop untuk bintang --}}
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->rating)
                                        <!-- Bintang penuh -->
                                        <svg class="w-5 h-5 text-yellow-500 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 
                                            00.95.69h3.462c.969 0 1.371 1.24.588 
                                            1.81l-2.8 2.034a1 1 0 
                                            00-.364 1.118l1.07 
                                            3.292c.3.921-.755 
                                            1.688-1.54 
                                            1.118l-2.8-2.034a1 
                                            1 0 00-1.175 
                                            0l-2.8 2.034c-.784.57-1.838-.197-1.539-
                                            1.118l1.07-3.292a1 
                                            1 0 00-.364-1.118L2.98 
                                            8.72c-.783-.57-.38-1.81.588-
                                            1.81h3.461a1 1 0 
                                            00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @else
                                        <!-- Bintang kosong -->
                                        <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 
                                            1.902 0l1.07 3.292a1 1 0 
                                            00.95.69h3.462c.969 0 
                                            1.371 1.24.588 
                                            1.81l-2.8 2.034a1 1 0 
                                            00-.364 1.118l1.07 
                                            3.292c.3.921-.755 
                                            1.688-1.54 
                                            1.118l-2.8-2.034a1 
                                            1 0 00-1.175 
                                            0l-2.8 2.034c-.784.57-1.838-.197-1.539-
                                            1.118l1.07-3.292a1 
                                            1 0 00-.364-1.118L2.98 
                                            8.72c-.783-.57-.38-1.81.588-
                                            1.81h3.461a1 1 0 
                                            00.951-.69l1.07-3.292z"/>
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
        </div>
        <div class="bg-white p-8 rounded-xl shadow-lg">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Spesifikasi Produk</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-800">Kondisi</h4>
                    <p class="text-gray-600">Mulus, terawat dengan baik</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-800">Kelengkapan</h4>
                    <p class="text-gray-600">Charger, kabel data</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-800">Baterai</h4>
                    <p class="text-gray-600">Kondisi prima, tahan lama</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-800">Garansi</h4>
                    <p class="text-gray-600">Garansi selama masa sewa</p>
                </div>
            </div>
        </div>
        
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
                    <p class="text-blue-600 font-bold">Rp {{ number_format($related['price']) }} / hari</p>
                    <a href="{{ route('powerbank.show', $related['id']) }}"
                       class="mt-2 inline-block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded transition">
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
// *** PERBAIKAN: Mendengarkan event 'click' pada tombol, BUKAN 'submit' pada form. ***
document.getElementById('addToCartBtn').addEventListener('click', function(e) {
    e.preventDefault();
    
    const btn = this; // Tombol yang diklik
    const form = document.getElementById('addToCartForm'); // Ambil form
    const originalText = btn.innerHTML;
    
    // Show loading state
    btn.innerHTML = 'Menambahkan...';
    btn.disabled = true;
    
    // Submit form via fetch
    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            btn.innerHTML = '✓ Ditambahkan!';
            btn.className = 'inline-block bg-green-600 text-white font-semibold px-6 py-3 rounded-lg cursor-not-allowed';
            
            // Update cart count in header if element exists
            const cartCount = document.querySelector('.cart-count');
            if (cartCount && data.cart_count) {
                cartCount.textContent = data.cart_count;
            }
            
            // Show success notification
            showNotification(data.message, 'success');
            
            // Reset button after 2 seconds
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                btn.className = 'inline-block bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-blue-700 transition';
            }, 2000);
        } else {
            throw new Error(data.message || 'Gagal menambahkan ke keranjang');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
        
        // Reset button
        btn.innerHTML = originalText;
        btn.disabled = false;
        btn.className = 'inline-block bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-blue-700 transition';
    });
});

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed bottom-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 max-w-sm ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    // Memperbaiki SVG yang belum memiliki stroke/fill yang benar di kode asli Anda.
    notification.innerHTML = `
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${type === 'success' 
                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' 
                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
                }
            </svg>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endpush
@endsection