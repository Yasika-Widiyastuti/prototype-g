@extends('layouts.app')

@section('title', 'Pembayaran - Sewa Barang Konser')
@section('description', 'Pilih metode pembayaran untuk menyelesaikan pesanan Anda.')

@section('breadcrumbs')
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <a href="{{ route('checkout') }}" class="text-gray-500 hover:text-gray-700">Checkout</a>
</li>
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <span class="text-gray-500">Pembayaran</span>
</li>
@endsection

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Pembayaran</h1>
            
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center">
                    <div class="flex items-center text-green-600">
                        <div class="flex-shrink-0 w-8 h-8 border-2 border-green-600 rounded-full bg-green-600 text-white flex items-center justify-center text-sm font-medium">
                            ✓
                        </div>
                        <span class="ml-4 text-sm font-medium">Review Pesanan</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-green-600 mx-4"></div>
                    <div class="flex items-center text-blue-600">
                        <div class="flex-shrink-0 w-8 h-8 border-2 border-blue-600 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-medium">
                            2
                        </div>
                        <span class="ml-4 text-sm font-medium">Pembayaran</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-gray-200 mx-4"></div>
                    <div class="flex items-center text-gray-400">
                        <div class="flex-shrink-0 w-8 h-8 border-2 border-gray-300 rounded-full flex items-center justify-center text-sm font-medium">
                            3
                        </div>
                        <span class="ml-4 text-sm font-medium">Konfirmasi</span>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Metode Pembayaran</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Bank BCA -->
                    <div class="border border-gray-300 rounded-lg p-6 hover:border-blue-500 cursor-pointer transition">
                        <div class="flex items-center mb-4">
                            <input type="radio" name="bank" value="bca" id="bca" class="text-blue-600">
                            <label for="bca" class="ml-3 text-lg font-medium text-gray-900">Bank BCA</label>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 mb-2">Nomor Rekening:</p>
                            <p class="text-lg font-bold text-blue-800">1234567890</p>
                            <p class="text-sm text-gray-600 mt-2">a.n. PT Sewa Konser Indonesia</p>
                        </div>
                    </div>

                    <!-- Bank Mandiri -->
                    <div class="border border-gray-300 rounded-lg p-6 hover:border-blue-500 cursor-pointer transition">
                        <div class="flex items-center mb-4">
                            <input type="radio" name="bank" value="mandiri" id="mandiri" class="text-blue-600">
                            <label for="mandiri" class="ml-3 text-lg font-medium text-gray-900">Bank Mandiri</label>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 mb-2">Nomor Rekening:</p>
                            <p class="text-lg font-bold text-yellow-800">9876543210</p>
                            <p class="text-sm text-gray-600 mt-2">a.n. PT Sewa Konser Indonesia</p>
                        </div>
                    </div>

                    <!-- Bank BRI -->
                    <div class="border border-gray-300 rounded-lg p-6 hover:border-blue-500 cursor-pointer transition">
                        <div class="flex items-center mb-4">
                            <input type="radio" name="bank" value="bri" id="bri" class="text-blue-600">
                            <label for="bri" class="ml-3 text-lg font-medium text-gray-900">Bank BRI</label>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 mb-2">Nomor Rekening:</p>
                            <p class="text-lg font-bold text-green-800">1122334455</p>
                            <p class="text-sm text-gray-600 mt-2">a.n. PT Sewa Konser Indonesia</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Instructions -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-blue-800 mb-4">Instruksi Pembayaran</h3>
                <ol class="list-decimal list-inside space-y-2 text-blue-700">
                    <li>Pilih salah satu bank di atas</li>
                    <li>Transfer sesuai total pembayaran: <strong>Rp 90.000</strong></li>
                    <li>Simpan bukti transfer</li>
                    <li>Upload bukti transfer di halaman konfirmasi</li>
                    <li>Tunggu verifikasi dari tim kami (max 2 jam)</li>
                </ol>
            </div>

            <!-- Order Summary -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Total Pembayaran</h3>
                <div class="text-center">
                    <p class="text-3xl font-bold text-blue-600">Rp 90.000</p>
                    <p class="text-sm text-gray-500 mt-1">Sudah termasuk biaya admin</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between">
                <a href="{{ route('checkout') }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-6 py-3 rounded-lg transition">
                    Kembali
                </a>
                <a href="{{ route('payment.confirmation') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg transition">
                    Konfirmasi Pembayaran
                </a>
            </div>
        </div>
    </div>
</div>
@endsection