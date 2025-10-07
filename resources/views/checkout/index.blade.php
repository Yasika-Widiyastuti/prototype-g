@extends('layouts.app')

@section('title', 'Keranjang & Checkout - Sewa Barang Konser')
@section('description', 'Review pesanan dan lanjutkan ke pembayaran.')

@section('breadcrumbs')
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <span class="text-gray-500">Checkout</span>
</li>
@endsection

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

            {{-- Alert Verifikasi Akun --}}
            @if(isset($showVerificationWarning) && $showVerificationWarning)
                <div class="mb-6 p-4 rounded-lg 
                    @if(str_contains($verificationMessage, 'menunggu')) bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 
                    @elseif(str_contains($verificationMessage, 'ditolak')) bg-red-100 border-l-4 border-red-500 text-red-800 
                    @else bg-gray-100 border-l-4 border-gray-500 text-gray-800 
                    @endif">
                    {{ $verificationMessage }}
                </div>
            @endif

            {{-- Progress Steps --}}
            <div class="mb-8">
                <div class="flex items-center">
                    <div class="flex items-center text-blue-600">
                        <div class="flex-shrink-0 w-8 h-8 border-2 border-blue-600 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-medium">
                            1
                        </div>
                        <span class="ml-4 text-sm font-medium">Review Pesanan</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-gray-200 mx-4"></div>
                    <div class="flex items-center {{ auth()->user()->hasVerifiedEmail() ? 'text-gray-400' : 'text-gray-300' }}">
                        <div class="flex-shrink-0 w-8 h-8 border-2 border-gray-300 rounded-full flex items-center justify-center text-sm font-medium">
                            2
                        </div>
                        <span class="ml-4 text-sm font-medium">Pembayaran</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-gray-200 mx-4"></div>
                    <div class="flex items-center text-gray-300">
                        <div class="flex-shrink-0 w-8 h-8 border-2 border-gray-300 rounded-full flex items-center justify-center text-sm font-medium">
                            3
                        </div>
                        <span class="ml-4 text-sm font-medium">Konfirmasi</span>
                    </div>
                </div>
            </div>

            {{-- Cart Items --}}
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Detail Pesanan</h2>

                @if(empty($cartItems))
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.195.195-.195.512 0 .707L7 18h12M9 19a2 2 0 100 4 2 2 0 000-4zM20 19a2 2 0 100 4 2 2 0 000-4z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Keranjang kosong</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan produk ke keranjang.</p>
                    <div class="mt-6">
                        <a href="{{ route('shop') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Lihat Produk
                        </a>
                    </div>
                </div>
                @else
                <div class="space-y-4" id="cart-items-container">
                    @foreach($cartItems as $cartKey => $item)
                    @php
                        $duration = $item['duration'] ?? 1;
                        $itemSubtotal = $item['price'] * $item['quantity'] * $duration;
                    @endphp
                    <div class="cart-item border border-gray-200 rounded-lg bg-white shadow-sm p-6" data-cart-key="{{ $cartKey }}">
                        <div class="flex items-start gap-6">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                            
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-gray-900">{{ $item['name'] }}</h3>
                                <p class="text-sm text-gray-500 mb-2">{{ $item['category'] ?? 'Kategori Tidak Diketahui' }}</p>
                                <p class="text-sm font-medium text-blue-600">Rp {{ number_format($item['price'], 0, ',', '.') }} / hari</p>
                                
                                <div class="mt-4">
                                    <label class="block text-xs text-gray-600 mb-1">Jumlah</label>
                                    <div class="flex items-center space-x-2">
                                        <button type="button" 
                                                class="quantity-btn decrease-btn w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-600 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition"
                                                data-action="decrease"
                                                data-cart-key="{{ $cartKey }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        
                                        <span class="quantity-display text-lg font-medium text-gray-900 min-w-8 text-center" data-quantity="{{ $item['quantity'] }}">
                                            {{ $item['quantity'] }}
                                        </span>
                                        
                                        <button type="button" 
                                                class="quantity-btn increase-btn w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-600 hover:bg-gray-50 transition"
                                                data-action="increase"
                                                data-cart-key="{{ $cartKey }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-right flex flex-col items-end gap-2">
                                <p class="item-total text-lg font-bold text-gray-900">
                                    Rp {{ number_format($itemSubtotal, 0, ',', '.') }}
                                </p>
                                <button type="button" 
                                        class="remove-btn text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-50 transition"
                                        data-cart-key="{{ $cartKey }}"
                                        title="Hapus dari keranjang">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            @if(!empty($cartItems))
            @php
                $initialDuration = $cartItems[array_key_first($cartItems)]['duration'] ?? 1;
            @endphp
            
            {{-- Durasi Peminjaman --}}
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Durasi Peminjaman</h2>
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-5 h-5 inline-block mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Tanggal Mulai Sewa
                            </label>
                            <input type="date" 
                                   id="start-date" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                   min="{{ date('Y-m-d') }}"
                                   value="{{ $startDate }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-5 h-5 inline-block mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Tanggal Selesai Sewa
                            </label>
                            <input type="date" 
                                   id="end-date" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                   min="{{ date('Y-m-d') }}"
                                   value="{{ $endDate }}">
                        </div>
                    </div>
                    <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Total Durasi:</span>
                            </div>
                            <span id="duration-display" class="text-lg font-bold text-blue-600">{{ $initialDuration }} Hari</span>
                        </div>
                        <p class="text-xs text-gray-600 mt-2">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Maksimal durasi sewa adalah 30 hari
                        </p>
                    </div>
                </div>
            </div>

            {{-- Ringkasan Pembayaran --}}
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pembayaran</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="subtotal-amount text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Biaya Admin</span>
                        <span class="text-gray-900">Rp 5.000</span>
                    </div>
                    <div class="border-t border-gray-300 pt-2">
                        <div class="flex justify-between">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            <span class="total-amount text-lg font-bold text-blue-600">Rp {{ number_format($total + 5000, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex justify-between">
                <a href="{{ route('shop') }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-6 py-3 rounded-lg transition">
                    Lanjut Belanja
                </a>
                
                @if(auth()->user()->verification_status === 'approved' && auth()->user()->is_active)
                    <a href="{{ route('checkout.payment') }}" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg transition">
                        Lanjut ke Pembayaran
                    </a>
                @else
                    <button disabled 
                            class="bg-gray-300 text-gray-500 font-medium px-6 py-3 rounded-lg cursor-not-allowed opacity-60 relative group"
                            title="Akun Anda belum dapat melakukan checkout">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Lanjut ke Pembayaran
                        </span>
                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-800 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                            Menunggu verifikasi admin
                        </span>
                    </button>
                @endif

            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');
    const durationDisplay = document.getElementById('duration-display');

    function calculateDuration() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        
        if (startDate && endDate && endDate >= startDate) {
            const diffTime = Math.abs(endDate - startDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            
            if (diffDays > 30) {
                alert('Maksimal durasi sewa adalah 30 hari');
                const maxEndDate = new Date(startDate);
                maxEndDate.setDate(maxEndDate.getDate() + 29);
                endDateInput.value = maxEndDate.toISOString().split('T')[0];
                return 30;
            }
            
            return diffDays;
        }
        return 1;
    }

    function updateDurationDisplay() {
        const duration = calculateDuration();
        durationDisplay.textContent = `${duration} Hari`;
        updateAllItemsDuration();
    }

    function updateAllItemsDuration() {
        fetch('{{ route("checkout.update-all-duration") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                start_date: startDateInput.value,
                end_date: endDateInput.value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelectorAll('.cart-item').forEach(cartItem => {
                    const cartKey = cartItem.getAttribute('data-cart-key');
                    if (data.items && data.items[cartKey]) {
                        const itemData = data.items[cartKey];
                        const itemTotal = cartItem.querySelector('.item-total');
                        itemTotal.textContent = 'Rp ' + itemData.formatted_subtotal;
                    }
                });
                
                updateTotals(data.formatted_total, data.new_total + 5000);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    startDateInput.addEventListener('change', function() {
        endDateInput.min = this.value;
        
        if (new Date(endDateInput.value) < new Date(this.value)) {
            const nextDay = new Date(this.value);
            nextDay.setDate(nextDay.getDate() + 1);
            endDateInput.value = nextDay.toISOString().split('T')[0];
        }
        
        updateDurationDisplay();
    });

    endDateInput.addEventListener('change', function() {
        if (new Date(this.value) < new Date(startDateInput.value)) {
            alert('Tanggal selesai tidak boleh sebelum tanggal mulai');
            const nextDay = new Date(startDateInput.value);
            nextDay.setDate(nextDay.getDate() + 1);
            this.value = nextDay.toISOString().split('T')[0];
        }
        
        updateDurationDisplay();
    });

    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.getAttribute('data-action');
            const cartKey = this.getAttribute('data-cart-key');
            const cartItem = this.closest('.cart-item');
            
            updateQuantity(cartKey, action, cartItem);
        });
    });
    
    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const cartKey = this.getAttribute('data-cart-key');
            const cartItem = this.closest('.cart-item');
            
            removeItem(cartKey, cartItem);
        });
    });
});

function updateQuantity(cartKey, action, cartItem) {
    const quantityBtns = cartItem.querySelectorAll('.quantity-btn');
    quantityBtns.forEach(btn => {
        btn.disabled = true;
        btn.classList.add('opacity-50');
    });
    
    fetch('{{ route("checkout.update-quantity") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            cart_key: cartKey,
            action: action
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.item_removed) {
                cartItem.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                cartItem.style.opacity = '0';
                cartItem.style.transform = 'translateX(-100%)';
                
                setTimeout(() => {
                    cartItem.remove();
                    if (document.querySelectorAll('.cart-item').length === 0) {
                        location.reload();
                    }
                }, 300);
            } else {
                const quantityDisplay = cartItem.querySelector('.quantity-display');
                quantityDisplay.textContent = data.new_quantity;
                quantityDisplay.setAttribute('data-quantity', data.new_quantity);
                
                const itemTotal = cartItem.querySelector('.item-total');
                itemTotal.textContent = 'Rp ' + data.formatted_item_subtotal;
                
                const decreaseBtn = cartItem.querySelector('.quantity-btn.decrease-btn');
                if (data.new_quantity <= 1) {
                    decreaseBtn.disabled = true;
                    decreaseBtn.classList.add('opacity-50');
                } else {
                    decreaseBtn.disabled = false;
                    decreaseBtn.classList.remove('opacity-50');
                }
            }
            
            updateTotals(data.formatted_total, data.new_total + 5000);
            
            if (window.updateCartCounter) {
                window.updateCartCounter(data.cart_count);
            }
        }
    })
    .catch(error => console.error('Error:', error))
    .finally(() => {
        quantityBtns.forEach(btn => {
            btn.disabled = false;
            btn.classList.remove('opacity-50');
        });
    });
}

function removeItem(cartKey, cartItem) {
    if (!confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')) {
        return;
    }
    
    const removeBtn = cartItem.querySelector('.remove-btn');
    removeBtn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    removeBtn.disabled = true;
    
    fetch('{{ route("checkout.remove-item") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            cart_key: cartKey
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            cartItem.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            cartItem.style.opacity = '0';
            cartItem.style.transform = 'translateX(-100%)';
            
            setTimeout(() => {
                cartItem.remove();
                if (document.querySelectorAll('.cart-item').length === 0) {
                    location.reload();
                }
            }, 300);
            
            updateTotals(data.formatted_total, data.new_total + 5000);
            
            if (window.updateCartCounter) {
                window.updateCartCounter(data.cart_count);
            }
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateTotals(formattedSubtotal, newTotalWithAdmin) {
    document.querySelector('.subtotal-amount').textContent = 'Rp ' + formattedSubtotal;
    document.querySelector('.total-amount').textContent = 'Rp ' + newTotalWithAdmin.toLocaleString('id-ID');
}
</script>
@endpush
@endsection