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
<section class="py-20 bg-gradient-to-r from-[#395886] to-[#2d4a6b] text-white">
    <div class="container mx-auto px-4 sm:px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6 loading">
            Hubungi Kami
        </h1>
        <p class="text-xl md:text-2xl max-w-3xl mx-auto text-[#B1C9EF] loading">
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
            <div class="bg-gradient-to-br from-[#D5DEEF] to-[#B1C9EF] border-2 border-[#9db8e0] rounded-xl p-8 text-center hover:shadow-lg transition hover-lift loading">
                <div class="bg-[#395886] w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.04 2c-5.51 0-10 4.49-10 10 0 1.77.47 3.5 1.37 5.02L2 22l5.11-1.34c1.45.79 3.09 1.2 4.75 1.2h.01c5.51 0 10-4.49 10-10s-4.49-10-10-10zM12 20.07h-.01c-1.5 0-2.96-.4-4.23-1.16l-.3-.18-3.04.8.81-2.96-.2-.3C4.34 15.01 4 13.54 4 12.01c0-4.41 3.59-8 8-8s8 3.59 8 8c0 4.41-3.59 8.06-8 8.06zm4.27-5.34c-.23-.12-1.36-.67-1.57-.74-.21-.08-.36-.12-.52.12-.16.23-.6.74-.74.9-.14.16-.27.17-.5.06-.23-.12-.96-.35-1.82-1.11-.67-.6-1.12-1.34-1.25-1.57-.13-.23-.01-.35.1-.47.1-.1.23-.27.34-.4.11-.13.14-.23.21-.39.07-.16.04-.3-.02-.42-.06-.12-.52-1.26-.72-1.72-.19-.46-.39-.4-.52-.41-.13-.01-.28-.01-.43-.01s-.4.06-.61.28c-.21.23-.8.78-.8 1.9s.82 2.2.93 2.35c.12.16 1.62 2.48 3.93 3.48.55.24.98.38 1.31.49.55.17 1.05.15 1.44.09.44-.07 1.36-.56 1.55-1.1.19-.54.19-1 .13-1.1-.06-.1-.21-.16-.44-.28z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-[#2d4a6b] mb-4">WhatsApp</h3>
                <p class="text-[#395886] mb-6">Chat langsung dengan tim customer service kami untuk konsultasi cepat</p>
                <div class="space-y-4">
                    <div class="bg-white rounded-lg p-4 border border-[#9db8e0]">
                        <p class="font-semibold text-[#395886]">Customer Service</p>
                        <p class="text-2xl font-bold text-[#2d4a6b]">+62 812 3456 7890</p>
                        <p class="text-sm text-gray-600 mt-2">Online: 24/7</p>
                    </div>
                    <a href="https://wa.me/6281234567890?text=Halo,%20saya%20tertarik%20dengan%20layanan%20sewa%20peralatan%20konser" 
                       target="_blank"
                       class="inline-block w-full bg-[#395886] hover:bg-[#2d4a6b] text-white font-bold py-3 px-6 rounded-lg transition">
                        <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.04 2c-5.51 0-10 4.49-10 10 0 1.77.47 3.5 1.37 5.02L2 22l5.11-1.34c1.45.79 3.09 1.2 4.75 1.2h.01c5.51 0 10-4.49 10-10s-4.49-10-10-10z"/>
                        </svg>
                        Chat Sekarang
                    </a>
                </div>
            </div>

            <!-- Email -->
            <div class="bg-gradient-to-br from-[#D5DEEF] to-[#B1C9EF] border-2 border-[#9db8e0] rounded-xl p-8 text-center hover:shadow-lg transition hover-lift loading">
                <div class="bg-[#395886] w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-[#2d4a6b] mb-4">Email</h3>
                <p class="text-[#395886] mb-6">Kirim email untuk pertanyaan detail atau permintaan khusus</p>
                <div class="space-y-4">
                    <div class="bg-white rounded-lg p-4 border border-[#9db8e0]">
                        <p class="font-semibold text-[#395886]">Email Utama</p>
                        <p class="text-lg font-bold text-[#2d4a6b]">info@sewakonser.com</p>
                        <p class="text-sm text-gray-600 mt-2">Response: 1-3 jam</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 border border-[#9db8e0]">
                        <p class="font-semibold text-[#395886]">Email Bisnis</p>
                        <p class="text-lg font-bold text-[#2d4a6b]">bisnis@sewakonser.com</p>
                        <p class="text-sm text-gray-600 mt-2">Untuk kerjasama & korporat</p>
                    </div>
                    <a href="mailto:info@sewakonser.com?subject=Pertanyaan%20Layanan%20Sewa&body=Halo,%0A%0ASaya%20ingin%20menanyakan%20tentang%20layanan%20sewa%20peralatan%20konser.%0A%0ATerima%20kasih." 
                       class="inline-block w-full bg-[#395886] hover:bg-[#2d4a6b] text-white font-bold py-3 px-6 rounded-lg transition">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8"></path>
                        </svg>
                        Kirim Email
                    </a>
                </div>
            </div>

            <!-- Telepon -->
            <div class="bg-gradient-to-br from-[#D5DEEF] to-[#B1C9EF] border-2 border-[#9db8e0] rounded-xl p-8 text-center hover:shadow-lg transition hover-lift loading">
                <div class="bg-[#395886] w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-[#2d4a6b] mb-4">Telepon</h3>
                <p class="text-[#395886] mb-6">Hubungi langsung via telepon untuk bantuan cepat</p>
                <div class="space-y-4">
                    <div class="bg-white rounded-lg p-4 border border-[#9db8e0]">
                        <p class="font-semibold text-[#395886]">Hotline Utama</p>
                        <p class="text-2xl font-bold text-[#2d4a6b]">+62 812 9876 5432</p>
                        <p class="text-sm text-gray-600 mt-2">Jam operasional: 08.00 - 22.00</p>
                    </div>
                    <a href="tel:+6281298765432" 
                       class="inline-block w-full bg-[#395886] hover:bg-[#2d4a6b] text-white font-bold py-3 px-6 rounded-lg transition">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Panggil Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Additional Info Section -->
<section class="py-16 bg-gradient-to-br from-[#D5DEEF] to-[#B1C9EF]">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-[#395886] rounded-full mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-[#2d4a6b] mb-4">Informasi Tambahan</h3>
                    <p class="text-gray-600">Beberapa hal yang perlu Anda ketahui sebelum menghubungi kami</p>
                </div>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-[#D5DEEF] rounded-lg p-6">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-[#395886] rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#2d4a6b] mb-2">Waktu Respons Cepat</h4>
                                <p class="text-sm text-[#395886]">Kami merespons dalam waktu maksimal 1 jam untuk WhatsApp dan 3 jam untuk email</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-[#D5DEEF] rounded-lg p-6">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-[#395886] rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#2d4a6b] mb-2">Dukungan 24/7</h4>
                                <p class="text-sm text-[#395886]">Tim customer service kami siap membantu Anda kapan saja, termasuk weekend dan hari libur</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-[#D5DEEF] rounded-lg p-6">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-[#395886] rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#2d4a6b] mb-2">Konsultasi Gratis</h4>
                                <p class="text-sm text-[#395886]">Dapatkan konsultasi gratis untuk memilih peralatan yang sesuai dengan kebutuhan Anda</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-[#D5DEEF] rounded-lg p-6">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-[#395886] rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#2d4a6b] mb-2">Multi Channel Support</h4>
                                <p class="text-sm text-[#395886]">Pilih channel komunikasi yang paling nyaman: WhatsApp, Email, atau Telepon</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Location Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="text-center mb-12">
            <h3 class="text-3xl font-bold text-[#2d4a6b] mb-4">Lokasi Kami</h3>
            <p class="text-gray-600 max-w-2xl mx-auto">Kunjungi kantor kami untuk konsultasi langsung atau pengambilan barang</p>
        </div>
        
        <div class="max-w-4xl mx-auto bg-gradient-to-br from-[#D5DEEF] to-[#B1C9EF] rounded-2xl p-8 shadow-lg">
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <h4 class="text-2xl font-bold text-[#2d4a6b] mb-4">Kantor Pusat</h4>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-[#395886] flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-[#2d4a6b]">Alamat</p>
                                <p class="text-[#395886]">Jalan RM Kahfi 1 Gang Asem RT 10 RW 06 <br>Cipedak Jagakarsa Jakarta Selatan</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-[#395886] flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-[#2d4a6b]">Jam Operasional</p>
                                <p class="text-[#395886]">Setiap Hari<br>09.00 - 17.00</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg p-1 shadow-md">
                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-16 h-16 text-[#395886] mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <a href="https://maps.app.goo.gl/TiTYaxrR2eQgtqUA6" class="text-[#395886] font-medium">
                                Klik Lokasi Disini
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection