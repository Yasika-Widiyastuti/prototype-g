@extends('layouts.app')

@section('title', 'Tentang Kami - Sewa Barang Konser Terpercaya')
@section('description', 'Pelajari lebih lanjut tentang layanan sewa peralatan konser kami. Pengalaman bertahun-tahun melayani ribuan konser di Indonesia.')

@section('breadcrumbs')
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <span class="text-gray-500">Tentang Kami</span>
</li>
@endsection

@section('content')
<!-- Hero Section -->
<section class="relative py-20 bg-gradient-to-r from-[#2d4a6b] to-[#395886] text-white overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <img src="https://images.unsplash.com/photo-1519681393784-e1f7bb1243f3?crop=entropy&cs=tinysrgb&fit=max&ixid=MnwzNjUyOXwwfDF8c2VhY3R8MHx8Y3VsdHVyYWwlMjBzb2NpZXR5fGVufDB8fHx8&ixlib=rb-1.2.1&q=80&w=1080" 
         alt="Tim Sewa Konser" 
         class="absolute inset-0 w-full h-full object-cover mix-blend-overlay"
         onerror="this.style.display='none'">
    
    <div class="relative container mx-auto px-4 sm:px-6 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-6 loading">
            Tentang <span class="text-[#B1C9EF]">Kami</span>
        </h1>
        <p class="text-xl md:text-2xl max-w-3xl mx-auto text-[#D5DEEF] loading">
            Dipercaya ribuan pelanggan untuk menyediakan peralatan konser terbaik sejak 2018
        </p>
    </div>
</section>

<!-- Our Story -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16 loading">
                <h2 class="text-3xl md:text-4xl font-bold text-[#2d4a6b] mb-6">Cerita Kami</h2>
                <p class="text-lg text-gray-600 leading-relaxed">
                    Berawal dari kecintaan terhadap musik dan pengalaman pribadi yang kurang memuaskan saat menghadiri konser, 
                    kami memutuskan untuk memulai layanan sewa peralatan konser yang dapat diandalkan.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="loading">
                    <img src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=800&q=80" 
                         alt="Konser dengan lightstick" 
                         class="rounded-xl shadow-lg w-full h-auto">
                </div>
                <div class="space-y-6 loading">
                    <div class="prose prose-lg text-gray-700">
                        <p class="mb-6">
                            Kami memahami betapa pentingnya momen konser bagi setiap penggemar musik. 
                            Lightstick yang tidak berfungsi, powerbank yang kehabisan daya, atau handphone yang tidak memadai 
                            dapat merusak pengalaman yang telah ditunggu-tunggu.
                        </p>
                        <p class="mb-6">
                            Dengan pengalaman lebih dari 5 tahun di industri ini, kami telah melayani lebih dari 1000 pelanggan 
                            dan 500+ acara konser di seluruh Indonesia. Kepercayaan Anda adalah prioritas utama kami.
                        </p>
                        <p>
                            Setiap produk yang kami sewakan telah melalui quality control ketat untuk memastikan 
                            kondisi prima saat sampai di tangan Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Mission & Vision -->
<section class="py-20 bg-gradient-to-br from-[#D5DEEF] to-[#B1C9EF]">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Mission -->
                <div class="text-center lg:text-left loading">
                    <div class="bg-[#395886] w-16 h-16 rounded-full flex items-center justify-center mx-auto lg:mx-0 mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[#2d4a6b] mb-4">Misi Kami</h3>
                    <p class="text-[#395886] leading-relaxed">
                        Memberikan akses mudah dan terjangkau terhadap peralatan konser berkualitas tinggi, 
                        sehingga setiap orang dapat menikmati pengalaman konser yang tak terlupakan tanpa khawatir 
                        tentang peralatan yang mereka butuhkan.
                    </p>
                </div>

                <!-- Vision -->
                <div class="text-center lg:text-left loading">
                    <div class="bg-[#395886] w-16 h-16 rounded-full flex items-center justify-center mx-auto lg:mx-0 mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[#2d4a6b] mb-4">Visi Kami</h3>
                    <p class="text-[#395886] leading-relaxed">
                        Menjadi penyedia layanan sewa peralatan konser terdepan di Indonesia, 
                        yang dikenal karena kualitas produk, keandalan layanan, dan komitmen 
                        untuk menciptakan pengalaman musik yang luar biasa bagi setiap pelanggan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Services -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="text-center mb-16 loading">
            <h2 class="text-3xl md:text-4xl font-bold text-[#2d4a6b] mb-6">Layanan Kami</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Kami menyediakan berbagai peralatan konser berkualitas dengan layanan yang komprehensif
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Lightstick Service -->
            <div class="text-center p-8 rounded-xl hover:shadow-lg transition hover-lift loading border-2 border-[#D5DEEF]">
                <div class="bg-gradient-to-br from-[#395886] to-[#2d4a6b] w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-[#2d4a6b] mb-4">Sewa Lightstick</h3>
                <p class="text-gray-600 mb-6">
                    Lightstick official dari berbagai grup K-Pop dan artis internasional. 
                    Semua dalam kondisi prima dengan baterai penuh dan fungsi yang sempurna.
                </p>
                <ul class="text-left space-y-2 text-gray-600">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-[#395886] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Berbagai model dan fandom
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-[#395886] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Kondisi sempurna & terawat
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-[#395886] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Baterai penuh siap pakai
                    </li>
                </ul>
            </div>

            <!-- Powerbank Service -->
            <div class="text-center p-8 rounded-xl hover:shadow-lg transition hover-lift loading border-2 border-[#D5DEEF]">
                <div class="bg-gradient-to-br from-[#395886] to-[#2d4a6b] w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-[#2d4a6b] mb-4">Sewa Powerbank</h3>
                <p class="text-gray-600 mb-6">
                    Powerbank berkualitas tinggi dengan kapasitas besar untuk memastikan 
                    perangkat Anda tidak kehabisan daya selama acara berlangsung.
                </p>
                <ul class="text-left space-y-2 text-gray-600">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-[#395886] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Kapasitas 10.000-20.000 mAh
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-[#395886] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Fast charging support
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-[#395886] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Multiple USB ports
                    </li>
                </ul>
            </div>

            <!-- Handphone Service -->
            <div class="text-center p-8 rounded-xl hover:shadow-lg transition hover-lift loading border-2 border-[#D5DEEF]">
                <div class="bg-gradient-to-br from-[#4a5f7e] to-[#395886] w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-[#2d4a6b] mb-4">Sewa Handphone</h3>
                <p class="text-gray-600 mb-6">
                    Smartphone flagship dengan kamera berkualitas tinggi untuk dokumentasi 
                    konser yang memukau dan komunikasi yang lancar.
                </p>
                <ul class="text-left space-y-2 text-gray-600">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-[#4a5f7e] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Kamera berkualitas profesional
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-[#4a5f7e] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Performa tinggi & stabil
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-[#4a5f7e] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Kondisi mulus terawat
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Statistics -->
<section class="py-20 bg-[#2d4a6b] text-white">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="text-center mb-16 loading">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Pencapaian Kami</h2>
            <p class="text-xl text-[#B1C9EF]">Kepercayaan Anda adalah kebanggaan kami</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="loading">
                <div class="text-4xl md:text-5xl font-bold text-[#B1C9EF] mb-2">5+</div>
                <div class="text-[#D5DEEF] font-medium">Tahun Pengalaman</div>
            </div>
            <div class="loading">
                <div class="text-4xl md:text-5xl font-bold text-[#B1C9EF] mb-2">500+</div>
                <div class="text-[#D5DEEF] font-medium">Konser Dilayani</div>
            </div>
            <div class="loading">
                <div class="text-4xl md:text-5xl font-bold text-[#B1C9EF] mb-2">1000+</div>
                <div class="text-[#D5DEEF] font-medium">Pelanggan Puas</div>
            </div>
            <div class="loading">
                <div class="text-4xl md:text-5xl font-bold text-[#B1C9EF] mb-2">100+</div>
                <div class="text-[#D5DEEF] font-medium">Produk Tersedia</div>
            </div>
        </div>
    </div>
</section>

<!-- Team Values -->
<section class="py-20 bg-gradient-to-br from-[#D5DEEF] to-[#B1C9EF]">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="text-center mb-16 loading">
            <h2 class="text-3xl md:text-4xl font-bold text-[#2d4a6b] mb-4">Nilai-Nilai Kami</h2>
            <p class="text-lg text-[#395886] max-w-2xl mx-auto">
                Prinsip yang memandu setiap langkah dan keputusan dalam melayani Anda
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-xl shadow-lg text-center hover-lift loading">
                <div class="bg-[#D5DEEF] w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-[#395886]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-[#2d4a6b] mb-4">Kualitas Terjamin</h3>
                <p class="text-gray-600">
                    Kami berkomitmen memberikan produk berkualitas tinggi yang telah melalui quality control ketat.
                </p>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-lg text-center hover-lift loading">
                <div class="bg-[#D5DEEF] w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-[#395886]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-[#2d4a6b] mb-4">Pelayanan Prima</h3>
                <p class="text-gray-600">
                    Customer service yang responsif dan ramah, siap membantu Anda 24/7 dengan sepenuh hati.
                </p>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-lg text-center hover-lift loading">
                <div class="bg-[#D5DEEF] w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-[#395886]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-[#2d4a6b] mb-4">Harga Transparan</h3>
                <p class="text-gray-600">
                    Tarif yang jelas tanpa biaya tersembunyi, memberikan value terbaik untuk investasi Anda.
                </p>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-lg text-center hover-lift loading">
                <div class="bg-[#D5DEEF] w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-[#395886]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-[#2d4a6b] mb-4">Proses Cepat</h3>
                <p class="text-gray-600">
                    Booking mudah, konfirmasi cepat, dan pengambilan yang fleksibel sesuai jadwal Anda.
                </p>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-lg text-center hover-lift loading">
                <div class="bg-[#D5DEEF] w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-[#395886]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-[#2d4a6b] mb-4">Kepercayaan</h3>
                <p class="text-gray-600">
                    Membangun hubungan jangka panjang berdasarkan kepercayaan dan komitmen mutual.
                </p>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-lg text-center hover-lift loading">
                <div class="bg-[#D5DEEF] w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-[#395886]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-[#2d4a6b] mb-4">Inovasi</h3>
                <p class="text-gray-600">
                    Terus berinovasi dalam layanan dan teknologi untuk memberikan pengalaman terbaik.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-[#395886] to-[#2d4a6b]">
    <div class="container mx-auto px-4 sm:px-6 text-center">
        <div class="max-w-3xl mx-auto loading">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                Siap Berkolaborasi dengan Kami?
            </h2>
            <p class="text-lg text-[#D5DEEF] mb-8">
                Bergabunglah dengan ribuan pelanggan yang telah mempercayai kami untuk menyediakan peralatan konser terbaik
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('shop') }}" 
                   class="bg-white hover:bg-[#D5DEEF] text-[#395886] font-bold px-8 py-4 rounded-lg text-lg transition">
                    Lihat Produk Kami
                </a>
                <a href="{{ route('hubungi') }}" 
                   class="border-2 border-white hover:bg-white hover:text-[#395886] text-white font-bold px-8 py-4 rounded-lg text-lg transition">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>
@endsection