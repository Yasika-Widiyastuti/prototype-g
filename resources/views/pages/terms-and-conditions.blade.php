@extends('layouts.app')

@section('title', 'Syarat dan Ketentuan - Sewa Barang Konser')
@section('description', 'Baca syarat dan ketentuan layanan sewa peralatan konser kami.')

@section('breadcrumbs')
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <span class="text-gray-500">Syarat dan Ketentuan</span>
</li>
@endsection

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Syarat dan Ketentuan</h1>
            
            <div class="prose prose-lg max-w-none">
                <h2>1. Ketentuan Umum</h2>
                <p>Dengan menggunakan layanan kami, Anda setuju untuk terikat oleh syarat dan ketentuan berikut.</p>
                
                <h2>2. Layanan Sewa</h2>
                <ul>
                    <li>Semua barang disewakan dalam kondisi baik dan berfungsi</li>
                    <li>Penyewa bertanggung jawab atas kerusakan atau kehilangan</li>
                    <li>Pengembalian harus tepat waktu sesuai kesepakatan</li>
                </ul>
                
                <h2>3. Pembayaran</h2>
                <ul>
                    <li>Pembayaran dilakukan di muka sebelum pengambilan barang</li>
                    <li>Deposit keamanan dapat dikenakan untuk barang tertentu</li>
                    <li>Refund sesuai dengan kebijakan yang berlaku</li>
                </ul>
                
                <h2>4. Tanggung Jawab</h2>
                <p>Penyewa bertanggung jawab penuh atas penggunaan barang selama masa sewa.</p>
                
                <h2>5. Kebijakan Privasi</h2>
                <p>Data pribadi Anda akan dijaga kerahasiaannya dan hanya digunakan untuk keperluan transaksi.</p>
            </div>
        </div>
    </div>
</div>
@endsection