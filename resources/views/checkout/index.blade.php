@extends('layouts.app')

@section('title', 'Checkout - Sewa Barang Konser')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-6">
        <ol class="flex items-center space-x-2 text-gray-600">
            <li><a href="{{ route('home') }}" class="hover:text-blue-600">Home</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900 font-medium">Checkout</li>
        </ol>
    </nav>

    <!-- Page Title -->
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

    <!-- Progress Steps -->
    <div class="flex items-center justify-center mb-12">
        <div class="flex items-center space-x-4">
            <!-- Step 1 - Active -->
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-full font-semibold">
                    1
                </div>
                <span class="ml-3 text-blue-600 font-semibold">Review Pesanan</span>
            </div>
            
            <div class="w-16 h-1 bg-gray-300"></div>
            
            <!-- Step 2 -->
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 bg-gray-300 text-gray-600 rounded-full font-semibold">
                    2
                </div>
                <span class="ml-3 text-gray-500">Pembayaran</span>
            </div>
            
            <div class="w-16 h-1 bg-gray-300"></div>
            
            <!-- Step 3 -->
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 bg-gray-300 text-gray-600 rounded-full font-semibold">
                    3
                </div>
                <span class="ml-3 text-gray-500">Konfirmasi</span>
            </div>
        </div>
    </div>

    @if(isset($isEmpty) && $isEmpty)
        <!-- Empty Cart State -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                <div class="mb-6">
                    <svg class="w-32 h-32 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Keranjang kosong</h2>
                <p class="text-gray-600 mb-8">
                    Mulai dengan menambahkan produk ke keranjang.
                </p>
                
                <a href="{{ route('shop') }}" 
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-4 rounded-lg text-lg transition">
                    Lihat Produk
                </a>
            </div>
        </div>
    @else
        <!-- Cart Has Items -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Detail Pesanan</h2>

                    <!-- Rental Duration Section -->
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                        <h3 class="font-semibold text-gray-900 mb-3">Durasi Peminjaman</h3>
                        <form id="durationForm">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                                    <input type="date" 
                                           name="start_date" 
                                           id="start_date" 
                                           value="{{ $startDate }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           min="{{ date('Y-m-d') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kembali</label>
                                    <input type="date" 
                                           name="end_date" 
                                           id="end_date" 
                                           value="{{ $endDate }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           min="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg transition">
                                Update Durasi
                            </button>
                        </form>
                        <p class="text-sm text-gray-600 mt-2">
                            Durasi: <span class="font-semibold text-blue-600" id="duration-display">{{ $duration }} hari</span>
                        </p>
                    </div>

                    <!-- Cart Items List -->
                    <div class="space-y-4" id="cart-items-container">
                        @foreach($cartItems as $key => $item)
                        <div class="flex items-start space-x-4 p-4 border border-gray-200 rounded-lg cart-item" data-cart-key="{{ $key }}">
                            <img src="{{ asset('storage/' . ($item['image'] ?? 'default.jpg')) }}" 
                                 alt="{{ $item['name'] }}" 
                                 class="w-24 h-24 object-cover rounded-lg">
                            
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 mb-1">{{ $item['name'] }}</h3>
                                <p class="text-sm text-gray-600 mb-2">Kategori: {{ ucfirst($item['category']) }}</p>
                                <p class="text-lg font-bold text-blue-600">
                                    Rp {{ number_format($item['price'], 0, ',', '.') }} <span class="text-sm text-gray-500">/ hari</span>
                                </p>
                                
                                <!-- Quantity Controls -->
                                <div class="flex items-center space-x-3 mt-3">
                                    <button type="button" 
                                            class="quantity-btn decrease w-8 h-8 flex items-center justify-center bg-gray-200 hover:bg-gray-300 rounded transition"
                                            data-cart-key="{{ $key }}"
                                            data-action="decrease">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    
                                    <span class="quantity-value font-semibold text-gray-900 min-w-[2rem] text-center">{{ $item['quantity'] }}</span>
                                    
                                    <button type="button" 
                                            class="quantity-btn increase w-8 h-8 flex items-center justify-center bg-gray-200 hover:bg-gray-300 rounded transition"
                                            data-cart-key="{{ $key }}"
                                            data-action="increase">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <p class="text-sm text-gray-600 mb-1">Subtotal:</p>
                                <p class="text-lg font-bold text-gray-900 item-subtotal">
                                    Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                </p>
                                
                                <button type="button" 
                                        class="remove-item mt-3 text-red-600 hover:text-red-700 text-sm font-medium transition"
                                        data-cart-key="{{ $key }}">
                                    Hapus
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Ringkasan Pesanan</h2>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-semibold" id="subtotal-display">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Biaya Admin</span>
                            <span class="font-semibold">Rp 5.000</span>
                        </div>
                        <div class="border-t pt-3 flex justify-between text-lg font-bold text-gray-900">
                            <span>Total</span>
                            <span id="total-display">Rp {{ number_format($total + 5000, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <button type="button" 
                            id="proceed-btn"
                            onclick="window.location.href='{{ route('checkout.payment') }}'"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-lg transition transform hover:scale-105">
                        Lanjut ke Pembayaran
                    </button>
                    
                    <a href="{{ route('shop') }}" 
                       class="block text-center text-blue-600 hover:text-blue-700 font-medium mt-4 transition">
                        ← Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- JavaScript for AJAX operations -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Duration Update Form
    const durationForm = document.getElementById('durationForm');
    if (durationForm) {
        durationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            
            fetch('{{ route("checkout.update-all-duration") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    start_date: startDate,
                    end_date: endDate
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update duration display
                    document.getElementById('duration-display').textContent = data.duration + ' hari';
                    
                    // Update all item subtotals
                    Object.keys(data.items).forEach(key => {
                        const itemEl = document.querySelector(`[data-cart-key="${key}"]`);
                        if (itemEl) {
                            itemEl.querySelector('.item-subtotal').textContent = 
                                'Rp ' + data.items[key].formatted_subtotal;
                        }
                    });
                    
                    // Update total
                    document.getElementById('subtotal-display').textContent = 'Rp ' + data.formatted_total;
                    const totalWithAdmin = parseInt(data.new_total) + 5000;
                    document.getElementById('total-display').textContent = 
                        'Rp ' + totalWithAdmin.toLocaleString('id-ID');
                    
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat mengupdate durasi', 'error');
            });
        });
    }
    
    // Quantity buttons
    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const cartKey = this.dataset.cartKey;
            const action = this.dataset.action;
            
            fetch('{{ route("checkout.update-quantity") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    cart_key: cartKey,
                    action: action
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.cart_empty) {
                        // Reload page to show empty state
                        window.location.reload();
                    } else if (data.item_removed) {
                        // Remove item from DOM
                        document.querySelector(`[data-cart-key="${cartKey}"]`).remove();
                        updateTotals(data);
                        updateCartBadge(data.cart_count);
                    } else {
                        // Update quantity display
                        const itemEl = document.querySelector(`[data-cart-key="${cartKey}"]`);
                        itemEl.querySelector('.quantity-value').textContent = data.new_quantity;
                        itemEl.querySelector('.item-subtotal').textContent = 'Rp ' + data.formatted_item_subtotal;
                        updateTotals(data);
                        updateCartBadge(data.cart_count);
                    }
                    
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan', 'error');
            });
        });
    });
    
    // Remove item buttons
    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!confirm('Apakah Anda yakin ingin menghapus produk ini?')) return;
            
            const cartKey = this.dataset.cartKey;
            
            fetch('{{ route("checkout.remove-item") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    cart_key: cartKey
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.cart_empty) {
                        // Reload page to show empty state
                        window.location.reload();
                    } else {
                        document.querySelector(`[data-cart-key="${cartKey}"]`).remove();
                        updateTotals(data);
                        updateCartBadge(data.cart_count);
                    }
                    
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan', 'error');
            });
        });
    });
    
    function updateTotals(data) {
        document.getElementById('subtotal-display').textContent = 'Rp ' + data.formatted_total;
        const totalWithAdmin = parseInt(data.new_total) + 5000;
        document.getElementById('total-display').textContent = 
            'Rp ' + totalWithAdmin.toLocaleString('id-ID');
    }
    
    function updateCartBadge(count) {
        const badge = document.getElementById('cart-count');
        if (badge) {
            badge.textContent = count;
            if (count === 0) {
                badge.classList.add('hidden');
            } else {
                badge.classList.remove('hidden');
            }
        }
    }
    
    function showNotification(message, type) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed bottom-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white font-medium`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => notification.classList.add('translate-x-0'), 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.add('opacity-0', 'translate-x-full');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
});
</script>

<style>
    .cart-item {
        transition: all 0.3s ease;
    }
    
    .cart-item:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .quantity-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .quantity-btn:active:not(:disabled) {
        transform: scale(0.95);
    }
</style>
@endsection