@extends('layouts.app')

@section('title', 'Syarat dan Ketentuan - Sewa Barang Konser')
@section('description', 'Baca syarat dan ketentuan layanan sewa peralatan konser kami.')

@section('breadcrumbs')
<li class="flex items-center">
    <svg class="w-4 h-4 text-[#4a5f7e] mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <span class="text-[#2d4a6b]">Syarat dan Ketentuan</span>
</li>
@endsection

@section('content')
<div class="py-12" style="background: linear-gradient(to bottom right, #D5DEEF, #B1C9EF);">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">

        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-[#395886] to-[#2d4a6b] px-8 py-10">
                <h1 class="text-4xl font-bold text-[#B1C9EF] mb-3">Syarat dan Ketentuan</h1>
                <p class="text-[#D5DEEF] text-lg">Mohon baca dengan seksama sebelum menggunakan layanan kami</p>
            </div>
        </div>

        <!-- Content Section -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-8 lg:p-12">

                @php
                    $sections = [
                        [
                            'number' => 1,
                            'title' => 'Ketentuan Umum',
                            'items' => [
                                'Dengan menggunakan layanan sewa peralatan konser kami, Anda menyatakan telah membaca, memahami, dan menyetujui seluruh syarat dan ketentuan yang berlaku.',
                                'Syarat dan ketentuan ini merupakan perjanjian hukum antara Anda (penyewa) dengan kami (penyedia layanan sewa).'
                            ]
                        ],
                        [
                            'number' => 2,
                            'title' => 'Persyaratan Penyewaan',
                            'alert' => [
                                'type' => 'amber',
                                'title' => 'Dokumen Wajib',
                                'text' => 'Penyewa wajib menyerahkan KTP asli sebagai jaminan pada saat pengambilan barang. KTP akan dikembalikan setelah barang dikembalikan dalam kondisi baik.'
                            ],
                            'items' => [
                                'Penyewa harus berusia minimal 17 tahun dan memiliki KTP yang masih berlaku',
                                'Mengisi formulir penyewaan dengan data yang benar dan lengkap',
                                'Menyetujui untuk dihubungi melalui nomor telepon yang didaftarkan'
                            ]
                        ],
                        [
                            'number' => 3,
                            'title' => 'Pembayaran dan Deposit',
                            'alert' => [
                                'type' => 'green',
                                'title' => 'Deposit Keamanan: Rp 300.000',
                                'text' => 'Deposit akan dikembalikan 100% setelah barang dikembalikan dalam kondisi baik dan tepat waktu.'
                            ],
                            'items' => [
                                'Pembayaran penuh (biaya sewa + deposit Rp 300.000) dilakukan di muka sebelum pengambilan barang',
                                'Metode pembayaran: Transfer bank, Cash, atau E-wallet',
                                'Deposit akan dikembalikan melalui metode yang sama dalam 1x24 jam setelah pengembalian barang',
                                'Bukti pembayaran wajib disimpan hingga transaksi selesai'
                            ]
                        ],
                        [
                            'number' => 4,
                            'title' => 'Kondisi Barang dan Penggunaan',
                            'items' => [
                                'Semua barang disewakan dalam kondisi baik, bersih, dan berfungsi normal',
                                'Penyewa wajib melakukan pengecekan kondisi barang saat pengambilan bersama petugas',
                                'Barang harus digunakan sesuai fungsinya dan dengan hati-hati',
                                'Dilarang menyewakan kembali atau meminjamkan barang kepada pihak lain',
                                'Penyewa bertanggung jawab menjaga barang dari kehilangan, kerusakan, atau pencurian'
                            ]
                        ],
                        [
                            'number' => 5,
                            'title' => 'Masa Sewa dan Pengembalian',
                            'items' => [
                                'Masa sewa dihitung berdasarkan hari, dengan waktu pengambilan dan pengembalian yang telah disepakati',
                                'Keterlambatan pengembalian dikenakan denda sebesar 10% dari harga sewa per hari',
                                'Perpanjangan sewa dapat dilakukan maksimal H-1 sebelum batas waktu pengembalian',
                                'Barang harus dikembalikan dalam kondisi bersih dan lengkap sesuai saat pengambilan'
                            ]
                        ],
                        [
                            'number' => 6,
                            'title' => 'Kerusakan dan Kehilangan',
                            'alert' => [
                                'type' => 'red',
                                'title' => 'Penting!',
                                'text' => 'Penyewa bertanggung jawab penuh atas kerusakan, kehilangan, atau pencurian barang selama masa sewa.'
                            ],
                            'items' => [
                                'Kerusakan ringan: Biaya perbaikan akan dipotong dari deposit',
                                'Kerusakan berat/total loss: Penyewa wajib mengganti sesuai harga barang baru atau nilai yang disepakati',
                                'Kehilangan: Penyewa wajib mengganti 100% harga barang baru',
                                'Penyewa wajib melaporkan kerusakan atau kehilangan maksimal 6 jam setelah kejadian'
                            ]
                        ],
                        [
                            'number' => 7,
                            'title' => 'Pembatalan dan Refund',
                            'items' => [
                                'Pembatalan lebih dari 24 jam sebelum waktu pengambilan: refund 100%',
                                'Pembatalan kurang dari 24 jam: refund 50%',
                                'Pembatalan setelah barang diambil: tidak ada refund',
                                'Proses refund dilakukan maksimal 3x24 jam kerja setelah pembatalan'
                            ]
                        ],
                        [
                            'number' => 8,
                            'title' => 'Lain-lain',
                            'items' => [
                                'Segala bentuk perselisihan yang timbul akan diselesaikan secara musyawarah untuk mufakat.',
                                'Perubahan syarat dan ketentuan dapat dilakukan sewaktu-waktu, dan akan diumumkan di website.'
                            ]
                        ]
                    ];
                @endphp

                @foreach($sections as $section)
                    <div class="mb-10">
                        <div class="flex items-start mb-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-[#395886] rounded-lg flex items-center justify-center text-[#B1C9EF] font-bold mr-4">{{ $section['number'] }}</div>
                            <h2 class="text-2xl font-bold text-[#2d4a6b] mt-1">{{ $section['title'] }}</h2>
                        </div>

                        <div class="ml-14 space-y-3 text-[#2d4a6b]">
                            @if(isset($section['alert']))
                                @php
                                    $type = $section['alert']['type'];
                                    $colors = [
                                        'amber' => ['bg' => 'bg-[#B1C9EF]','border' => 'border-[#395886]','text' => 'text-[#2d4a6b]','title' => 'text-[#4a5f7e]'],
                                        'green' => ['bg' => 'bg-[#9db8e0]','border' => 'border-[#2d4a6b]','text' => 'text-[#2d4a6b]','title' => 'text-[#395886]'],
                                        'red' => ['bg' => 'bg-[#D5DEEF]','border' => 'border-[#395886]','text' => 'text-[#2d4a6b]','title' => 'text-[#395886]']
                                    ];
                                @endphp
                                <div class="{{ $colors[$type]['bg'] }} border-l-4 {{ $colors[$type]['border'] }} p-5 mb-5 rounded-r-lg">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-5 h-5 {{ $colors[$type]['title'] }} mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="font-semibold {{ $colors[$type]['title'] }}">{{ $section['alert']['title'] }}</span>
                                    </div>
                                    <p class="{{ $colors[$type]['text'] }}">{{ $section['alert']['text'] }}</p>
                                </div>
                            @endif

                            @foreach($section['items'] as $item)
                                <div class="flex items-start">
                                    <svg class="w-6 h-6 text-[#395886] mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p>{{ $item }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if(!$loop->last)
                        <hr class="my-8 border-[#4a5f7e]">
                    @endif
                @endforeach

            </div>
        </div>
    </div>
</div>
@endsection