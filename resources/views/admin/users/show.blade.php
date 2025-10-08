@extends('admin.layouts2.app2')

@section('title', 'Detail User')
@section('page-title', 'Detail User: ' . $user->name)

@section('content')
<div class="space-y-6">

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <p class="text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
            <p class="text-red-700 font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Header -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg">
            ← Kembali ke Daftar
        </a>

        <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
            @csrf
            @method('PATCH')
            <button type="submit" onclick="return confirm('Yakin ingin {{ $user->is_active ? 'menonaktifkan' : 'mengaktifkan' }} akun ini?')"
                    class="px-5 py-2 {{ $user->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded-lg">
                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} Akun
            </button>
        </form>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-600">Total Orders</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-600">Selesai</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['completed_orders'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-600">Pending</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_orders'] }}</p>
        </div>
    </div>

    <!-- Main Content: 2 Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Dokumen & Data User -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Dokumen Identitas -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Dokumen Identitas</h3>

                @if(!$user->ktp_path || !$user->kk_path)
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                        <p class="text-sm text-yellow-700 font-medium">User belum mengupload dokumen lengkap.</p>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- KTP -->
                    <div class="border-2 {{ $user->ktp_path ? 'border-blue-200' : 'border-gray-200' }} rounded-xl overflow-hidden p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">KTP</h4>
                        @if($user->ktp_path && Storage::disk('public')->exists($user->ktp_path))
                            @php
                                $ktpUrl = Storage::url($user->ktp_path);
                                $isPdf = str_ends_with(strtolower($user->ktp_path), '.pdf');
                            @endphp

                            @if($isPdf)
                                <embed src="{{ $ktpUrl }}" type="application/pdf" class="w-full h-96 rounded-lg">
                            @else
                                <img src="{{ $ktpUrl }}" alt="KTP" class="w-full h-auto rounded-lg">
                            @endif
                        @else
                            <p class="text-sm text-gray-500">Belum upload dokumen</p>
                        @endif
                    </div>

                    <!-- KK -->
                    <div class="border-2 {{ $user->kk_path ? 'border-blue-200' : 'border-gray-200' }} rounded-xl overflow-hidden p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Kartu Keluarga</h4>
                        @if($user->kk_path && Storage::disk('public')->exists($user->kk_path))
                            @php
                                $kkUrl = Storage::url($user->kk_path);
                                $isPdf = str_ends_with(strtolower($user->kk_path), '.pdf');
                            @endphp

                            @if($isPdf)
                                <embed src="{{ $kkUrl }}" type="application/pdf" class="w-full h-96 rounded-lg">
                            @else
                                <img src="{{ $kkUrl }}" alt="KK" class="w-full h-auto rounded-lg">
                            @endif
                        @else
                            <p class="text-sm text-gray-500">Belum upload dokumen</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Data User -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Data User</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Nama Lengkap</p>
                        <p class="text-base text-gray-900 font-medium">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-base text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nomor HP</p>
                        <p class="text-base text-gray-900">{{ $user->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Bergabung</p>
                        <p class="text-base text-gray-900">{{ $user->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm text-gray-500">Alamat</p>
                        <p class="text-base text-gray-900">{{ $user->address ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Status Verifikasi -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Verifikasi</h3>

                @if($user->verification_status === 'pending')
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 rounded-r-lg">
                        <p class="text-sm font-semibold text-yellow-800">Menunggu Verifikasi</p>
                        <p class="text-xs text-yellow-700 mt-1">User ini menunggu verifikasi dokumen</p>
                    </div>

                    @if($user->ktp_path && $user->kk_path)
                        <form method="POST" action="{{ route('admin.users.verify', $user) }}" class="space-y-3">
                            @csrf
                            @method('PATCH')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                <textarea name="notes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500" placeholder="Tambahkan catatan..."></textarea>
                            </div>
                            <button type="submit" name="action" value="approve" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">✓ Approve</button>
                            <button type="submit" name="action" value="reject" onclick="return confirm('Yakin tolak verifikasi?')" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">✗ Reject</button>
                        </form>
                    @else
                        <p class="text-sm text-gray-600 text-center py-3">Dokumen belum lengkap</p>
                    @endif

                @elseif($user->verification_status === 'approved')
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                        <p class="text-sm font-semibold text-green-800">Terverifikasi</p>
                        @if($user->verified_at)
                            <p class="text-xs text-green-700 mt-1">{{ $user->verified_at->format('d M Y, H:i') }}</p>
                        @endif
                        @if($user->verification_notes)
                            <p class="text-xs text-green-700 mt-2">Catatan: {{ $user->verification_notes }}</p>
                        @endif
                    </div>

                @elseif($user->verification_status === 'rejected')
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4 rounded-r-lg">
                        <p class="text-sm font-semibold text-red-800">Ditolak</p>
                        @if($user->verified_at)
                            <p class="text-xs text-red-700 mt-1">{{ $user->verified_at->format('d M Y, H:i') }}</p>
                        @endif
                        @if($user->verification_notes)
                            <p class="text-xs text-red-700 mt-2">Alasan: {{ $user->verification_notes }}</p>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('admin.users.verify', $user) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="action" value="approve">
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">Verifikasi Ulang</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection