@extends('layouts.app')

@section('title', 'Hubungi Kami - Sewa Barang Konser')
@section('description', 'Hubungi tim customer service kami untuk informasi lebih lanjut tentang layanan sewa peralatan konser. Kami siap membantu 24/7.')

@section('breadcrumbs')
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <span class="text-gray-500">Hubungi Kami</span>
</li>
@endsection

@section('content')
<!-- Hero Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
    <div class="container mx-auto px-4 sm:px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6 loading">
            Hubungi Kami
        </h1>
        <p class="text-xl md:text-2xl max-w-3xl mx-auto text-blue-100 loading">
            Tim customer service kami siap membantu Anda 24/7. Jangan ragu untuk menghubungi kami kapan saja!
        </p>
    </div>
</section>

<!-- Contact Methods -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="text-center mb-16 loading">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Cara Menghubungi Kami</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Pilih cara yang paling nyaman untuk Anda. Kami akan merespons secepat mungkin!
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- WhatsApp -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-xl p-8 text-center hover:shadow-lg transition hover-lift loading">
                <div class="bg-green-500 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.04 2c-5.51 0-10 4.49-10 10 0 1.77.47 3.5 1.37 5.02L2 22l5.11-1.34c1.45.79 3.09 1.2 4.75 1.2h.01c5.51 0 10-4.49 10-10s-4.49-10-10-10zM12 20.07h-.01c-1.5 0-2.96-.4-4.23-1.16l-.3-.18-3.04.8.81-2.96-.2-.3C4.34 15.01 4 13.54 4 12.01c0-4.41 3.59-8 8-8s8 3.59 8 8c0 4.41-3.59 8.06-8 8.06zm4.27-5.34c-.23-.12-1.36-.67-1.57-.74-.21-.08-.36-.12-.52.12-.16.23-.6.74-.74.9-.14.16-.27.17-.5.06-.23-.12-.96-.35-1.82-1.11-.67-.6-1.12-1.34-1.25-1.57-.13-.23-.01-.35.1-.47.1-.1.23-.27.34-.4.11-.13.14-.23.21-.39.07-.16.04-.3-.02-.42-.06-.12-.52-1.26-.72-1.72-.19-.46-.39-.4-.52-.41-.13-.01-.28-.01-.43-.01s-.4.06-.61.28c-.21.23-.8.78-.8 1.9s.82 2.2.93 2.35c.12.16 1.62 2.48 3.93 3.48.55.24.98.38 1.31.49.55.17 1.05.15 1.44.09.44-.07 1.36-.56 1.55-1.1.19-.54.19-1 .13-1.1-.06-.1-.21-.16-.44-.28z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">WhatsApp</h3>
                <p class="text-gray-700 mb-6">Chat langsung dengan tim customer service kami untuk konsultasi cepat</p>
                <div class="space-y-4">
                    <div class="bg-white rounded-lg p-4 border border-green-200">
                        <p class="font-semibold text-green-700">Customer Service</p>
                        <p class="text-2xl font-bold text-gray-900">+62 812 3456 7890</p>
                        <p class="text-sm text-gray-600 mt-2">Online: 24/7</p>
                    </div>
                    <a href="https://wa.me/6281234567890?text=Halo,%20saya%20tertarik%20dengan%20layanan%20sewa%20peralatan%20konser" 
                       target="_blank"
                       class="inline-block w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition">
                        <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.04 2c-5.51 0-10 4.49-10 10 0 1.77.47 3.5 1.37 5.02L2 22l5.11-1.34c1.45.79 3.09 1.2 4.75 1.2h.01c5.51 0 10-4.49 10-10s-4.49-10-10-10z"/>
                        </svg>
                        Chat Sekarang
                    </a>
                </div>
            </div>

            <!-- Email -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl p-8 text-center hover:shadow-lg transition hover-lift loading">
                <div class="bg-blue-500 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Email</h3>
                <p class="text-gray-700 mb-6">Kirim email untuk pertanyaan detail atau permintaan khusus</p>
                <div class="space-y-4">
                    <div class="bg-white rounded-lg p-4 border border-blue-200">
                        <p class="font-semibold text-blue-700">Email Utama</p>
                        <p class="text-lg font-bold text-gray-900">info@sewakonser.com</p>
                        <p class="text-sm text-gray-600 mt-2">Response: 1-3 jam</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 border border-blue-200">
                        <p class="font-semibold text-blue-700">Email Bisnis</p>
                        <p class="text-lg font-bold text-gray-900">bisnis@sewakonser.com</p>
                        <p class="text-sm text-gray-600 mt-2">Untuk kerjasama & korporat</p>
                    </div>
                    <a href="mailto:info@sewakonser.com?subject=Pertanyaan%20Layanan%20Sewa&body=Halo,%0A%0ASaya%20ingin%20menanyakan%20tentang%20layanan%20sewa%20peralatan%20konser.%0A%0ATerima%20kasih." 
                       class="inline-block w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8"></path>
                        </svg>
                        Kirim Email
                    </a>
                </div>
            </div>

            <!-- Telepon -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 border-2 border-purple-200 rounded-xl p-8 text-center hover:shadow-lg transition hover-lift loading">
                <div class="bg-purple-500 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h2l3.6 7.59-1.35 2.44A1 1 0 008 17h8a1 1 0 00.9-.55l3.24-6.48A1 1 0 0019 9h-6l-2-4H3z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Telepon</h3>
                <p class="text-gray-700 mb-6">Hubungi langsung via telepon untuk bantuan cepat</p>
                <div class="space-y-4">
                    <div class="bg-white rounded-lg p-4 border border-purple-200">
                        <p class="font-semibold text-purple-700">Hotline Utama</p>
                        <p class="text-2xl font-bold text-gray-900">+62 812 9876 5432</p>
                        <p class="text-sm text-gray-600 mt-2">Jam operasional: 08.00 - 22.00</p>
                    </div>
                    <a href="tel:+6281298765432" 
                       class="inline-block w-full bg-purple-500 hover:bg-purple-600 text-white font-bold py-3 px-6 rounded-lg transition">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h2l3.6 7.59-1.35 2.44A1 1 0 008 17h8a1 1 0 00.9-.55l3.24-6.48A1 1 0 0019 9h-6l-2-4H3z"></path>
                        </svg>
                        Panggil Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
