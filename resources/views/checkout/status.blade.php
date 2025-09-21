@extends('layouts.app')

@section('title', 'Status Pembayaran - Sewa Barang Konser')
@section('description', 'Status pembayaran dan pesanan Anda.')

@section('breadcrumbs')
    <li class="flex items-center">
        <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
        </svg>
        <span class="text-gray-500">Status Pembayaran</span>
    </li>
@endsection

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-xl shadow-lg p-8">
            @if ($payment->status == 'waiting')
                <!-- Waiting Status -->
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-6">
                        <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">Pembayaran Sedang Diverifikasi</h1>
                    <p class="text-lg text-gray-600 mb-8">
                        Terima kasih! Bukti pembayaran Anda telah kami terima dan sedang dalam proses verifikasi.
                    </p>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-yellow-800 mb-4">Apa yang terjadi selanjutnya?</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center text-white text-sm font-bold mr-4 mt-0.5">1</div>
                            <div>
                                <h4 class="font-medium text-yellow-900">Verifikasi Pembayaran</h4>
                                <p class="text-yellow-700">Tim kami akan memverifikasi pembayaran Anda dalam 1-2 jam kerja</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center text-white text-sm font-bold mr-4 mt-0.5">2</div>
                            <div>
                                <h4 class="font-medium text-gray-700">Konfirmasi Email</h4>
                                <p class="text-gray-600">Anda akan menerima email konfirmasi setelah pembayaran diverifikasi</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center text-white text-sm font-bold mr-4 mt-0.5">3</div>
                            <div>
                                <h4 class="font-medium text-gray-700">Koordinasi Pengambilan</h4>
                                <p class="text-gray-600">Tim kami akan menghubungi Anda untuk mengatur waktu dan lokasi pengambilan barang</p>
                            </div>
                        </div>
                    </div>
                </div>

            @elseif ($payment->status == 'success')
                <!-- Success Status -->
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">Pembayaran Berhasil!</h1>
                    <p class="text-lg text-gray-600 mb-8">
                        Selamat! Pembayaran Anda telah dikonfirmasi dan pesanan akan segera diproses.
                    </p>
                </div>

                <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-green-800 mb-4">Pesanan Anda</h3>
                    <div class="space-y-2 text-green-700">
                        <p><span class="font-medium">Nomor Pesanan:</span> #ORDER-2025-001</p>
                        <p><span class="font-medium">Total Pembayaran:</span> Rp 90.000</p>
                        <p><span class="font-medium">Status:</span> Dikonfirmasi</p>
                    </div>
                </div>

            @else
                <!-- Failed Status -->
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                        <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">Pembayaran Gagal</h1>
                    <p class="text-lg text-gray-600 mb-8">
                        Maaf, ada masalah dengan bukti pembayaran yang Anda kirimkan.
                    </p>
                </div>

                <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-red-800 mb-4">Kemungkinan Masalah</h3>
                    <ul class="text-red-700 list-disc list-inside space-y-1">
                        <li>Nominal transfer tidak sesuai dengan total pembayaran</li>
                        <li>Bukti transfer tidak jelas atau tidak dapat dibaca</li>
                        <li>Bank tujuan transfer tidak sesuai</li>
                        <li>File bukti transfer rusak atau tidak valid</li>
                    </ul>
                </div>
            @endif

            <!-- Contact Info -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Butuh Bantuan?</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.04 2c-5.51 0-10 4.49-10 10 0 1.77.47 3.5 1.37 5.02L2 22l5.11-1.34c1.45.79 3.09 1.2 4.75 1.2h.01c5.51 0 10-4.49 10-10s-4.49-10-10-10z"/>
                        </svg>
                        <div>
                            <p class="font-medium text-gray-900">WhatsApp</p>
                            <p class="text-gray-600">+62 812 3456 7890</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <p class="font-medium text-gray-900">Email</p>
                            <p class="text-gray-600">info@sewakonser.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center space-x-4">
                <a href="{{ route('home') }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-6 py-3 rounded-lg transition">
                    Kembali ke Beranda
                </a>
                
                @if ($payment->status == 'failed')
                <a href="{{ route('payment.confirmation') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg transition">
                    Coba Upload Ulang
                </a>
                @endif
                
                @if ($payment->status != 'failed')
                <a href="{{ route('shop') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg transition">
                    Lanjut Belanja
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
