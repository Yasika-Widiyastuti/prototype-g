@extends('admin.layouts2.app2')

@section('title', 'Detail User')
@section('page-title', 'Detail User: ' . $user->name)

@section('content')
<div class="space-y-6">
    <!-- Alert Messages -->
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-red-700 font-medium">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Header -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.users.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar
        </a>
        
        <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
            @csrf
            @method('PATCH')
            <button type="submit" 
                    onclick="return confirm('Yakin ingin {{ $user->is_active ? 'menonaktifkan' : 'mengaktifkan' }} akun ini?')"
                    class="px-5 py-2 {{ $user->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded-lg font-medium transition">
                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} Akun
            </button>
        </form>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Selesai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['completed_orders'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_orders'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content: 2 Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Dokumen & Data User (2/3 width) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Dokumen Verifikasi -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Dokumen Identitas
                </h3>

                <!-- Peringatan jika belum upload -->
                @if(!$user->ktp_path || !$user->kk_path)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-yellow-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <p class="text-sm text-yellow-700 font-medium">User belum mengupload dokumen lengkap. Verifikasi tidak dapat dilakukan.</p>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- KTP -->
                    <div class="border-2 {{ $user->ktp_path ? 'border-blue-200' : 'border-gray-200' }} rounded-xl overflow-hidden">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                            <h4 class="font-semibold text-gray-900">KTP</h4>
                        </div>
                        <div class="bg-white p-6">
                            @if($user->ktp_path)
                                <div class="text-center">
                                    @if(str_ends_with(strtolower($user->ktp_path), '.pdf'))
                                        <!-- PDF Icon -->
                                        <svg class="w-16 h-16 mx-auto text-red-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-sm font-medium text-gray-900 mb-3">File PDF</p>
                                    @else
                                        <!-- Image Icon -->
                                        <svg class="w-16 h-16 mx-auto text-blue-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-sm font-medium text-gray-900 mb-3">File Gambar</p>
                                    @endif
                                    
                                    <a href="{{ asset('storage/' . $user->ktp_path) }}" 
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg font-medium transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                        Buka Dokumen
                                    </a>
                                </div>
                            @else
                                <!-- No Document -->
                                <div class="text-center py-8">
                                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-sm text-gray-500">Belum upload dokumen</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- KK -->
                    <div class="border-2 {{ $user->kk_path ? 'border-blue-200' : 'border-gray-200' }} rounded-xl overflow-hidden">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                            <h4 class="font-semibold text-gray-900">Kartu Keluarga</h4>
                        </div>
                        <div class="bg-white p-6">
                            @if($user->kk_path)
                                <div class="text-center">
                                    @if(str_ends_with(strtolower($user->kk_path), '.pdf'))
                                        <!-- PDF Icon -->
                                        <svg class="w-16 h-16 mx-auto text-red-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-sm font-medium text-gray-900 mb-3">File PDF</p>
                                    @else
                                        <!-- Image Icon -->
                                        <svg class="w-16 h-16 mx-auto text-blue-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-sm font-medium text-gray-900 mb-3">File Gambar</p>
                                    @endif
                                    
                                    <a href="{{ asset('storage/' . $user->kk_path) }}" 
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg font-medium transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                        Buka Dokumen
                                    </a>
                                </div>
                            @else
                                <!-- No Document -->
                                <div class="text-center py-8">
                                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-sm text-gray-500">Belum upload dokumen</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data User -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Data User</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase">Nama Lengkap</label>
                        <p class="text-base text-gray-900 mt-1 font-medium">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase">Email</label>
                        <p class="text-base text-gray-900 mt-1">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase">Nomor HP</label>
                        <p class="text-base text-gray-900 mt-1">{{ $user->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase">Tanggal Bergabung</label>
                        <p class="text-base text-gray-900 mt-1">{{ $user->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="col-span-2">
                        <label class="text-xs font-semibold text-gray-500 uppercase">Alamat</label>
                        <p class="text-base text-gray-900 mt-1">{{ $user->address ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Status & Action -->
        <div class="space-y-6">
            <!-- Status Verifikasi -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Verifikasi</h3>

                @if($user->verification_status === 'pending')
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 rounded-r-lg">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-yellow-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-yellow-800">Menunggu Verifikasi</p>
                                <p class="text-xs text-yellow-700 mt-1">User ini menunggu verifikasi dokumen</p>
                            </div>
                        </div>
                    </div>

                    @if($user->ktp_path && $user->kk_path)
                        <form method="POST" action="{{ route('admin.users.verify', $user) }}" class="space-y-3">
                            @csrf
                            @method('PATCH')
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Optional)</label>
                                <textarea name="notes" 
                                        rows="2" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                        placeholder="Tambahkan catatan..."></textarea>
                            </div>
                            
                            <button type="submit" 
                                    name="action" 
                                    value="approve"
                                    class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition">
                                ✓ Approve
                            </button>
                            
                            <button type="submit" 
                                    name="action" 
                                    value="reject"
                                    onclick="return confirm('Yakin tolak verifikasi?')"
                                    class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition">
                                ✗ Reject
                            </button>
                        </form>
                    @else
                        <p class="text-sm text-gray-600 text-center py-3">Dokumen belum lengkap</p>
                    @endif

                @elseif($user->verification_status === 'approved')
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-green-800">Terverifikasi</p>
                                @if($user->verified_at)
                                    <p class="text-xs text-green-700 mt-1">{{ $user->verified_at->format('d M Y, H:i') }}</p>
                                @endif
                                @if($user->verification_notes)
                                    <p class="text-xs text-green-700 mt-2">Catatan: {{ $user->verification_notes }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                @elseif($user->verification_status === 'rejected')
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4 rounded-r-lg">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-red-800">Ditolak</p>
                                @if($user->verified_at)
                                    <p class="text-xs text-red-700 mt-1">{{ $user->verified_at->format('d M Y, H:i') }}</p>
                                @endif
                                @if($user->verification_notes)
                                    <p class="text-xs text-red-700 mt-2">Alasan: {{ $user->verification_notes }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.users.verify', $user) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="action" value="approve">
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition">
                            Verifikasi Ulang
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection