@extends('layouts.app')

@section('title', 'Daftar Akun - Sewa Barang Konser')
@section('description', 'Daftar akun baru untuk mulai menyewa peralatan konser terbaik dengan mudah dan aman.')

@section('breadcrumbs')
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <span class="text-gray-500">Daftar Akun</span>
</li>
@endsection

@section('content')
<div class="py-12 bg-gradient-to-br from-[#D5DEEF] to-[#B1C9EF]">
    <div class="max-w-md mx-auto px-4 sm:px-6">
        
        <!-- Header -->
        <div class="text-center mb-8 loading">
            <div class="bg-[#395886] w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-[#2d4a6b] mb-2">Daftar Akun Baru</h1>
            <p class="text-[#395886]">Lengkapi form di bawah untuk membuat akun</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-lg p-8 loading">
            <form action="{{ route('create.account.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-[#2d4a6b] mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           required 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#395886] focus:border-transparent @error('name') border-red-500 @enderror" 
                           placeholder="Masukkan nama lengkap">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-[#2d4a6b] mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           required 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#395886] focus:border-transparent @error('email') border-red-500 @enderror" 
                           placeholder="nama@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-[#2d4a6b] mb-2">
                        Nomor HP <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" 
                           id="phone" 
                           name="phone" 
                           required 
                           value="{{ old('phone') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#395886] focus:border-transparent @error('phone') border-red-500 @enderror" 
                           placeholder="08123456789">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-[#2d4a6b] mb-2">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea id="address" 
                              name="address" 
                              required 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#395886] focus:border-transparent resize-none @error('address') border-red-500 @enderror" 
                              placeholder="Alamat lengkap dengan kota dan kode pos">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-[#2d4a6b] mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#395886] focus:border-transparent @error('password') border-red-500 @enderror" 
                           placeholder="Minimal 8 karakter">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-[#2d4a6b] mb-2">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#395886] focus:border-transparent" 
                           placeholder="Ulangi password">
                </div>

                <!-- Upload KTP -->
                <div>
                    <label for="ktp" class="block text-sm font-medium text-[#2d4a6b] mb-2">
                        Upload KTP <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="file" 
                               id="ktp" 
                               name="ktp" 
                               required 
                               accept="image/*,.pdf"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#395886] focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#D5DEEF] file:text-[#395886] hover:file:bg-[#B1C9EF] @error('ktp') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-[#395886]">Format: JPG, PNG, atau PDF (Max. 5MB)</p>
                    </div>
                    @error('ktp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload KK -->
                <div>
                    <label for="kk" class="block text-sm font-medium text-[#2d4a6b] mb-2">
                        Upload KK <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="file" 
                               id="kk" 
                               name="kk" 
                               required 
                               accept="image/*,.pdf"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#395886] focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#D5DEEF] file:text-[#395886] hover:file:bg-[#B1C9EF] @error('kk') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-[#395886]">Format: JPG, PNG, atau PDF (Max. 5MB)</p>
                    </div>
                    @error('kk')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-start space-x-3">
                    <input type="checkbox" 
                           id="agree" 
                           name="agree" 
                           required 
                           class="mt-1 h-4 w-4 text-[#395886] focus:ring-[#395886] border-gray-300 rounded">
                    <label for="agree" class="text-sm text-[#395886]">
                        Saya setuju dengan 
                        <a href="{{ route('termsAndConditions') }}" 
                           target="_blank"
                           class="text-[#2d4a6b] hover:text-[#395886] underline font-medium">
                            Syarat dan Ketentuan
                        </a> 
                        serta 
                        <a href="{{ route('termsAndConditions') }}" 
                           target="_blank"
                           class="text-[#2d4a6b] hover:text-[#395886] underline font-medium">
                            Kebijakan Privasi
                        </a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-[#395886] hover:bg-[#2d4a6b] text-white font-bold py-3 px-4 rounded-lg transition duration-200 hover-lift">
                    Daftar Sekarang
                </button>

                <!-- Sign In Link -->
                <div class="text-center pt-6 border-t border-gray-200">
                    <p class="text-sm text-[#395886]">
                        Sudah punya akun? 
                        <a href="{{ route('signIn') }}" class="text-[#2d4a6b] hover:text-[#395886] font-medium">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Security Info -->
        <div class="mt-8 bg-white border-2 border-[#9db8e0] rounded-lg p-4 shadow-md loading">
            <div class="flex">
                <svg class="w-5 h-5 text-[#395886] mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-9a2 2 0 00-2-2H6a2 2 0 00-2 2v9a2 2 0 002 2zm10-12V9a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-[#2d4a6b] mb-1">Keamanan Data</h3>
                    <p class="text-sm text-[#395886]">
                        Data pribadi Anda aman bersama kami. KTP dan KK hanya digunakan untuk verifikasi identitas dan tidak akan disalahgunakan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');

    // Password confirmation validation
    confirmPassword.addEventListener('input', function() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Password tidak sama');
        } else {
            confirmPassword.setCustomValidity('');
        }
    });

    // File size validation
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            const maxSize = 5 * 1024 * 1024; // 5MB

            if (file && file.size > maxSize) {
                alert('Ukuran file maksimal 5MB');
                this.value = '';
            }
        });
    });
});
</script>
@endpush
@endsection