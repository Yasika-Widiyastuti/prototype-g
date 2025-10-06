<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', config('app.name', 'Sewa Barang Konser'))</title>
    
    <!-- Meta Description for SEO -->
    <meta name="description" content="@yield('description', 'Sewa lightstick, powerbank, dan handphone untuk konser dengan harga terjangkau. Kualitas terbaik, pelayanan terpercaya.')">
    
    <!-- Scripts & Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom Styles -->
    <style>
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Loading animation */
        .loading {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }
        
        .loading.loaded {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Custom hover effects */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        /* Cart counter animation */
        .cart-counter {
            animation: bounceIn 0.3s ease;
        }

        @keyframes bounceIn {
            0% { transform: scale(0.3) rotate(-10deg); opacity: 0; }
            50% { transform: scale(1.05) rotate(5deg); }
            70% { transform: scale(0.9) rotate(-2deg); }
            100% { transform: scale(1) rotate(0deg); opacity: 1; }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header / Navigation -->
    <header class="bg-gray-900 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex justify-between items-center py-4">
                
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 hover:opacity-80 transition">
                        <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0L24 22H0z"/>
                        </svg>
                        <span class="font-bold text-xl">{{ config('app.name', 'SewaKonser') }}</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex space-x-8 items-center">
                    <a href="{{ route('home') }}" 
                       class="hover:text-yellow-500 transition {{ request()->routeIs('home') ? 'text-yellow-500' : '' }}">
                        Home
                    </a>
                    
                    <a href="{{ route('tentangKami') }}" 
                       class="hover:text-yellow-500 transition {{ request()->routeIs('tentangKami') ? 'text-yellow-500' : '' }}">
                        Tentang Kami
                    </a>
                    
                    <!-- Dropdown Kategori -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" 
                                class="flex items-center hover:text-yellow-500 transition focus:outline-none">
                            Kategori
                            <svg class="w-4 h-4 ml-1 transition-transform" 
                                 :class="open ? 'rotate-180' : ''" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute left-0 mt-2 w-48 bg-white text-gray-900 rounded-lg shadow-lg py-2 z-50">
                            
                            <a href="/lightstick" class="block px-4 py-2 hover:bg-yellow-50 hover:text-yellow-600">
                                🎤 Lightstick
                            </a>
                            <a href="/powerbank" class="block px-4 py-2 hover:bg-yellow-50 hover:text-yellow-600">
                                🔋 Powerbank
                            </a>
                            <a href="/handphone" class="block px-4 py-2 hover:bg-yellow-50 hover:text-yellow-600">
                                📱 Handphone
                            </a>
                        </div>
                    </div>
                    
                    <a href="{{ route('hubungi') }}" 
                       class="hover:text-yellow-500 transition {{ request()->routeIs('hubungi') ? 'text-yellow-500' : '' }}">
                        Hubungi Kami
                    </a>
                </nav>

                <!-- Right Side: Search & Auth -->
                <div class="hidden lg:flex items-center space-x-4">
                    
                    <!-- Search Form -->
                    <form action="{{ route('shop') }}" method="GET" class="flex items-center">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   placeholder="Cari produk..." 
                                   value="{{ request('search') }}"
                                   class="w-64 px-4 py-2 pl-4 pr-10 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2">
                                <svg class="w-5 h-5 text-gray-500 hover:text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>

                    @guest
                        <!-- Login & Register -->
                        <a href="{{ route('signIn') }}" 
                           class="px-4 py-2 hover:text-yellow-500 transition">
                            Masuk
                        </a>
                        
                        <a href="{{ route('create-account') }}" 
                           class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-gray-900 rounded-lg font-medium transition">
                            Daftar
                        </a>
                    @else
                        <!-- User Menu -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" 
                                    class="flex items-center space-x-2 hover:text-yellow-500 transition focus:outline-none">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <div x-show="open" @click.away="open = false"
                                 x-transition
                                 class="absolute right-0 mt-2 w-48 bg-white text-gray-900 rounded-lg shadow-lg py-2 z-50">
                                <a href="{{ route('profile.index') }}" class="block px-4 py-2 hover:bg-gray-100">Profil</a>
                                <a href="{{ route('profile.orders') }}" class="block px-4 py-2 hover:bg-gray-100">Pesanan Saya</a>
                                <div class="border-t border-gray-200"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest

                    <!-- Shopping Cart -->
                    <a href="{{ route('checkout.index') }}" id="cart-link" class="relative hover:text-yellow-500 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.195.195-.195.512 0 .707L7 18h12M9 19a2 2 0 100 4 2 2 0 000-4zM20 19a2 2 0 100 4 2 2 0 000-4z">
                            </path>
                        </svg>
                        @if(($globalCartCount ?? session('cart_count', 0)) > 0)
                        <span id="cart-counter" class="cart-counter absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            <span id="cart-count">{{ $globalCartCount ?? session('cart_count', 0) }}</span>
                        </span>
                        @endif

                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden">
                    <button x-data @click="$dispatch('toggle-mobile-menu')" 
                            class="text-white hover:text-yellow-500 transition p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-data="{ mobileMenuOpen: false }" 
                 @toggle-mobile-menu.window="mobileMenuOpen = !mobileMenuOpen"
                 x-show="mobileMenuOpen" 
                 x-transition
                 class="lg:hidden bg-gray-800 pb-4">
                <nav class="space-y-2">
                    <a href="{{ route('home') }}" class="block px-4 py-2 hover:bg-gray-700 hover:text-yellow-500 transition">Home</a>
                    <a href="{{ route('tentangKami') }}" class="block px-4 py-2 hover:bg-gray-700 hover:text-yellow-500 transition">Tentang Kami</a>
                    <a href="/lightstick" class="block px-4 py-2 hover:bg-gray-700 hover:text-yellow-500 transition">🎤 Lightstick</a>
                    <a href="/powerbank" class="block px-4 py-2 hover:bg-gray-700 hover:text-yellow-500 transition">🔋 Powerbank</a>
                    <a href="/handphone" class="block px-4 py-2 hover:bg-gray-700 hover:text-yellow-500 transition">📱 Handphone</a>
                    <a href="{{ route('hubungi') }}" class="block px-4 py-2 hover:bg-gray-700 hover:text-yellow-500 transition">Hubungi Kami</a>
                    
                    <div class="border-t border-gray-700 pt-2">
                        @guest
                            <a href="{{ route('signIn') }}" class="block px-4 py-2 hover:bg-gray-700 hover:text-yellow-500 transition">Masuk</a>
                            <a href="{{ route('create-account') }}" class="block px-4 py-2 hover:bg-gray-700 hover:text-yellow-500 transition">Daftar</a>
                        @else
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700 hover:text-yellow-500 transition">Profile</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-700 hover:text-yellow-500 transition">Pesanan</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-700 text-red-400 transition">Logout</button>
                            </form>
                        @endguest
                    </div>
                    
                    <!-- Mobile Cart -->
                    <div class="border-t border-gray-700 pt-2">
                        <a href="{{ route('checkout.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-700 hover:text-yellow-500 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.195.195-.195.512 0 .707L7 18h12M9 19a2 2 0 100 4 2 2 0 000-4zM20 19a2 2 0 100 4 2 2 0 000-4z"></path>
                            </svg>
                            Keranjang 
                            <span id="mobile-cart-counter" class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full {{  $globalCartCount ?? session('cart_count', 0) }}">
                                <span id="mobile-cart-count">{{  $globalCartCount ?? session('cart_count', 0) }}</span>
                            </span>
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Breadcrumbs -->
    @if(!request()->routeIs('home'))
    <nav class="bg-gray-50 border-b border-gray-200" aria-label="Breadcrumb">
        <div class="container mx-auto px-4 sm:px-6 py-3">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                </li>
                @yield('breadcrumbs')
            </ol>
        </div>
    </nav>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-auto">
        <div class="container mx-auto px-4 sm:px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                
                <!-- Company Info -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0L24 22H0z"/>
                        </svg>
                        <span class="font-bold text-xl">{{ config('app.name', 'SewaKonser') }}</span>
                    </div>
                    <p class="text-gray-400">
                        Layanan sewa peralatan konser terpercaya dengan kualitas terbaik dan harga terjangkau.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="space-y-4">
                    <h3 class="font-semibold text-lg">Link Cepat</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('tentangKami') }}" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="{{ route('shop') }}" class="hover:text-white transition">Semua Produk</a></li>
                        <li><a href="{{ route('hubungi') }}" class="hover:text-white transition">Hubungi Kami</a></li>
                        <li><a href="{{ route('termsAndConditions') }}" class="hover:text-white transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div class="space-y-4">
                    <h3 class="font-semibold text-lg">Kategori</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="/handphone" class="hover:text-white transition">📱 Handphone</a></li>
                        <li><a href="/powerbank" class="hover:text-white transition">🔋 Powerbank</a></li>
                        <li><a href="/lightstick" class="hover:text-white transition">🎤 Lightstick</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="space-y-4">
                    <h3 class="font-semibold text-lg">Kontak</h3>
                    <div class="space-y-2 text-gray-400">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>info@sewakonser.com</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>+62 812 3456 7890</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Surabaya, Indonesia</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'SewaKonser') }}. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Flash Messages -->
    @if(session('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition
             x-init="setTimeout(() => show = false, 5000)"
             class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 max-w-sm">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
                <button @click="show = false" class="ml-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition
             x-init="setTimeout(() => show = false, 5000)"
             class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 max-w-sm">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span>{{ session('error') }}</span>
                <button @click="show = false" class="ml-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @stack('scripts')
    
    <!-- Global Cart Management Script -->
    <!-- Tambahkan di bagian <script> sebelum closing </body> -->
    <script>
        // Function to update cart counter
        function updateCartCounter(count) {
            const cartCounter = document.getElementById('cart-counter');
            const cartCount = document.getElementById('cart-count');
            const mobileCartCounter = document.getElementById('mobile-cart-counter');
            const mobileCartCount = document.getElementById('mobile-cart-count');
            
            if (count > 0) {
                if (cartCounter) {
                    cartCounter.classList.remove('hidden');
                    cartCount.textContent = count;
                    // Add bounce animation
                    cartCounter.classList.remove('cart-counter');
                    void cartCounter.offsetWidth;
                    cartCounter.classList.add('cart-counter');
                }
                
                if (mobileCartCounter) {
                    mobileCartCounter.classList.remove('hidden');
                    mobileCartCount.textContent = count;
                }
            } else {
                if (cartCounter) cartCounter.classList.add('hidden');
                if (mobileCartCounter) mobileCartCounter.classList.add('hidden');
            }
        }

        // Function to show notification
        function showNotification(message, type = 'success') {
            const existingNotification = document.querySelector('.notification-toast');
            if (existingNotification) {
                existingNotification.remove();
            }

            const notification = document.createElement('div');
            notification.className = `notification-toast fixed bottom-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 max-w-sm transition-all duration-300 transform translate-x-full ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            notification.innerHTML = `
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        ${type === 'success' 
                            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'
                            : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
                        }
                    </svg>
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-2 hover:opacity-70">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 300);
            }, 4000);
        }

        // Global add to cart handler
        function handleAddToCart(form, button) {
            const originalText = button.innerHTML;
            
            // Show loading state
            button.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Menambahkan...';
            button.disabled = true;
            button.classList.add('opacity-75', 'cursor-not-allowed');
            
            // Submit form via fetch
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Add to cart response:', data); // Debug
                
                if (data.success) {
                    // PENTING: Update cart counter dengan cart_count dari response
                    updateCartCounter(data.cart_count || 0);
                    
                    // Show success message
                    let successText = '✓ Ditambahkan!';
                    if (data.product_quantity && data.product_quantity > 1) {
                        successText = `✓ Qty: ${data.product_quantity}`;
                    }
                    
                    button.innerHTML = successText;
                    button.className = button.className.replace('bg-blue-600', 'bg-green-600').replace('hover:bg-blue-700', 'hover:bg-green-700');
                    
                    showNotification(data.message || 'Produk berhasil ditambahkan ke keranjang!', 'success');
                    
                    // Reset button after 3 seconds
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                        button.className = button.className.replace('bg-green-600', 'bg-blue-600').replace('hover:bg-green-700', 'hover:bg-blue-700');
                        button.classList.remove('opacity-75', 'cursor-not-allowed');
                    }, 3000);
                } else {
                    throw new Error(data.message || 'Gagal menambahkan ke keranjang');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification(error.message || 'Terjadi kesalahan. Silakan coba lagi.', 'error');
                
                // Reset button
                button.innerHTML = originalText;
                button.disabled = false;
                button.classList.remove('opacity-75', 'cursor-not-allowed');
            });
        }

        // Auto-attach event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Handle all add to cart forms
            const addToCartForms = document.querySelectorAll('form[action*="cart/add"]');
            
            addToCartForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const button = this.querySelector('button[type="submit"]');
                    if (button) {
                        handleAddToCart(this, button);
                    }
                });
            });
            
            // Loading Animation
            const elements = document.querySelectorAll('.loading');
            elements.forEach((element, index) => {
                setTimeout(() => {
                    element.classList.add('loaded');
                }, index * 100);
            });
        });
    </script>

</body>
</html>