@extends('layouts.app')

@section('title', 'Beranda - Sewa Barang Konser Terpercaya')
@section('description', 'Sewa lightstick, powerbank, dan handphone untuk konser dengan harga terjangkau. Kualitas terbaik, pelayanan terpercaya di Surabaya.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-gray-900 to-gray-800 text-white">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <img src="{{ asset('storage/img/fotow.jpg') }}" 
         alt="Konser Background" 
         class="absolute inset-0 w-full h-full object-cover mix-blend-overlay"
         onerror="this.style.display='none'">
    
    <div class="relative container mx-auto px-4 sm:px-6 py-20 lg:py-32">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 loading">
                Sewa Peralatan <span class="text-yellow-500">Konser</span> Terpercaya
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 mb-8 loading">
                Dapatkan lightstick, powerbank, dan handphone berkualitas dengan harga terjangkau untuk konser impian Anda!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center loading">
                <a href="{{ route('shop') }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold px-8 py-4 rounded-lg text-lg transition hover-lift">
                    Lihat Semua Produk
                </a>
                <a href="{{ route('tentangKami') }}" 
                   class="border-2 border-white hover:bg-white hover:text-gray-900 text-white font-bold px-8 py-4 rounded-lg text-lg transition">
                    Tentang Kami
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-yellow-500">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-gray-900">
            <div class="loading">
                <div class="text-3xl md:text-4xl font-bold mb-2">500+</div>
                <div class="text-sm md:text-base font-medium">Konser Dilayani</div>
            </div>
            <div class="loading">
                <div class="text-3xl md:text-4xl font-bold mb-2">100+</div>
                <div class="text-sm md:text-base font-medium">Produk Tersedia</div>
            </div>
            <div class="loading">
                <div class="text-3xl md:text-4xl font-bold mb-2">1000+</div>
                <div class="text-sm md:text-base font-medium">Pelanggan Puas</div>
            </div>
            <div class="loading">
                <div class="text-3xl md:text-4xl font-bold mb-2">5+</div>
                <div class="text-sm md:text-base font-medium">Tahun Pengalaman</div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Categories -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="text-center mb-16 loading">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Kategori Produk</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Pilih kategori produk yang sesuai dengan kebutuhan konser atau event Anda
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Lightstick -->
            <div class="group bg-gray-50 rounded-xl p-8 hover:bg-yellow-50 transition hover-lift loading">
                <div class="text-center">
                    <div class="bg-yellow-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Lightstick</h3>
                    <p class="text-gray-600 mb-6">
                        Lightstick official berbagai grup K-Pop untuk menambah semangat di konser
                    </p>
                    <a href="/lightstick" 
                       class="inline-flex items-center text-yellow-600 hover:text-yellow-700 font-medium">
                        Lihat Produk 
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Powerbank -->
            <div class="group bg-gray-50 rounded-xl p-8 hover:bg-yellow-50 transition hover-lift loading">
                <div class="text-center">
                    <div class="bg-yellow-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Powerbank</h3>
                    <p class="text-gray-600 mb-6">
                        Powerbank kapasitas besar untuk memastikan gadget Anda tidak kehabisan daya
                    </p>
                    <a href="/powerbank" 
                       class="inline-flex items-center text-yellow-600 hover:text-yellow-700 font-medium">
                        Lihat Produk 
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Handphone -->
            <div class="group bg-gray-50 rounded-xl p-8 hover:bg-yellow-50 transition hover-lift loading">
                <div class="text-center">
                    <div class="bg-yellow-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Handphone</h3>
                    <p class="text-gray-600 mb-6">
                        Smartphone dengan kamera berkualitas untuk dokumentasi konser terbaik
                    </p>
                    <a href="/handphone" 
                       class="inline-flex items-center text-yellow-600 hover:text-yellow-700 font-medium">
                        Lihat Produk 
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="text-center mb-16 loading">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Produk Unggulan</h2>
            <p class="text-lg text-gray-600">Produk terpopuler yang sering disewa untuk konser</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Product 1 - Lightstick BTS -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-lift loading">
                <img src="https://i.pinimg.com/736x/aa/32/68/aa3268c1a2e0c97b80787932ad4b01a4.jpg" 
                     alt="Lightstick BTS" 
                     class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-lg font-bold text-gray-900">Lightstick BTS Army Bomb</h3>
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded">Popular</span>
                    </div>
                    <p class="text-gray-600 mb-4">Official lightstick BTS dengan koneksi Bluetooth dan berbagai mode pencahayaan</p>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-yellow-600">Rp 75.000<span class="text-sm text-gray-500">/hari</span></span>
                        @auth
                            <a href="{{ route('lightstick.show', 3) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition">
                                Sewa
                            </a>
                        @else
                            <a href="{{ route('signIn') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition">
                                Sewa
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Product 2 - Samsung Galaxy S24 Ultra -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-lift loading">
                <img src="https://i.pinimg.com/1200x/a8/3f/4b/a83f4bbf667e46d68e67ed0155218a9a.jpg" 
                     alt="Samsung Galaxy S24 Ultra" 
                     class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-lg font-bold text-gray-900">Samsung Galaxy S24 Ultra</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded">Premium</span>
                    </div>
                    <p class="text-gray-600 mb-4">Android flagship dengan S Pen dan kamera zoom 100x untuk dokumentasi konser</p>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-yellow-600">Rp 140.000<span class="text-sm text-gray-500">/hari</span></span>
                        @auth
                            <a href="{{ route('handphone.show', 2) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition">
                                Sewa
                            </a>
                        @else
                            <a href="{{ route('signIn') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition">
                                Sewa
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Product 3 - Powerbank Xiaomi 20000mAh -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-lift loading">
                <img src="https://i.pinimg.com/1200x/16/30/6c/16306c1e7c40aa1d33c57d4f209d2445.jpg" 
                     alt="Powerbank Xiaomi" 
                     class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-lg font-bold text-gray-900">Powerbank Xiaomi 20000mAh</h3>
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded">Reliable</span>
                    </div>
                    <p class="text-gray-600 mb-4">Powerbank berkualitas tinggi dengan fast charging untuk berbagai device</p>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-yellow-600">Rp 25.000<span class="text-sm text-gray-500">/hari</span></span>
                        @auth
                            <a href="{{ route('powerbank.show', 6) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition">
                                Sewa
                            </a>
                        @else
                            <a href="{{ route('signIn') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition">
                                Sewa
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-12 loading">
            <a href="{{ route('shop') }}" 
               class="bg-gray-900 hover:bg-gray-800 text-white font-bold px-8 py-4 rounded-lg transition">
                Lihat Semua Produk
            </a>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="text-center mb-16 loading">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Mengapa Pilih Kami?</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Kami berkomitmen memberikan pelayanan terbaik untuk pengalaman konser yang tak terlupakan
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center loading">
                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Kualitas Terjamin</h3>
                <p class="text-gray-600">Semua produk dalam kondisi prima dan terawat dengan baik</p>
            </div>

            <div class="text-center loading">
                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Harga Terjangkau</h3>
                <p class="text-gray-600">Tarif sewa yang kompetitif dengan kualitas terbaik di kelasnya</p>
            </div>

            <div class="text-center loading">
                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Layanan 24/7</h3>
                <p class="text-gray-600">Customer service siap membantu kapan saja Anda membutuhkan</p>
            </div>

            <div class="text-center loading">
                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Proses Cepat</h3>
                <p class="text-gray-600">Booking mudah dan pengambilan barang yang fleksibel</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-yellow-500 to-yellow-600">
    <div class="container mx-auto px-4 sm:px-6 text-center">
        <div class="max-w-3xl mx-auto loading">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                Siap untuk Konser Impian Anda?
            </h2>
            <p class="text-lg text-gray-800 mb-8">
                Dapatkan peralatan terbaik dengan proses sewa yang mudah dan cepat. Hubungi kami sekarang!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('shop') }}" 
                   class="bg-gray-900 hover:bg-gray-800 text-white font-bold px-8 py-4 rounded-lg text-lg transition">
                    Mulai Sewa Sekarang
                </a>
                <a href="{{ route('hubungi') }}" 
                   class="border-2 border-gray-900 hover:bg-gray-900 hover:text-white text-gray-900 font-bold px-8 py-4 rounded-lg text-lg transition">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>
@endsection