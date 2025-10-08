@extends('layouts.app')

@section('title', 'Masuk - Sewa Barang Konser')
@section('description', 'Masuk ke akun Anda untuk mulai menyewa peralatan konser terbaik.')

@section('breadcrumbs')
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <span class="text-gray-500">Masuk</span>
</li>
@endsection

@section('content')
<div class="py-12 bg-gradient-to-br from-[#D5DEEF] to-[#B1C9EF]">
    <div class="max-w-md mx-auto px-4 sm:px-6">
        
        <!-- Success Message - Moved to top -->
        @if(session('status'))
            <div class="mb-6">
                <div class="bg-white border-2 border-[#9db8e0] rounded-xl p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-[#395886]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-semibold text-[#2d4a6b] mb-1">Berhasil!</h3>
                            <p class="text-sm text-[#395886]">{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-[#395886] w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-[#2d4a6b] mb-2">Selamat Datang Kembali</h1>
            <p class="text-[#395886]">Masuk ke akun Anda untuk melanjutkan</p>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 bg-white border-2 border-[#9db8e0] rounded-xl p-4 text-center text-[#395886]">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-2 border-red-200 rounded-xl p-4 text-center text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 bg-white border-2 border-[#9db8e0] rounded-xl p-4 text-center text-[#395886]">
                {{ session('info') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="mb-6 bg-yellow-50 border-2 border-yellow-200 rounded-xl p-4 text-center text-yellow-700">
                {{ session('warning') }}
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-[#2d4a6b] mb-2">
                        Email
                    </label>
                    <div class="relative">
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required 
                               value="{{ old('email') }}"
                               class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#395886] focus:border-transparent @error('email') border-red-500 @enderror" 
                               placeholder="nama@email.com">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-[#9db8e0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-[#2d4a6b] mb-2">
                        Password
                    </label>
                    <div class="relative" x-data="{ showPassword: false }">
                        <input :type="showPassword ? 'text' : 'password'" 
                               id="password" 
                               name="password" 
                               required 
                               class="w-full pl-12 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#395886] focus:border-transparent @error('password') border-red-500 @enderror" 
                               placeholder="Masukkan password">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-[#9db8e0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-9a2 2 0 00-2-2H6a2 2 0 00-2 2v9a2 2 0 002 2zm10-12V9a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <button type="button" 
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg x-show="!showPassword" class="h-5 w-5 text-[#9db8e0] hover:text-[#395886]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="showPassword" class="h-5 w-5 text-[#9db8e0] hover:text-[#395886]" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="remember" 
                               name="remember" 
                               class="h-4 w-4 text-[#395886] focus:ring-[#395886] border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-[#395886]">
                            Ingat saya
                        </label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-sm text-[#395886] hover:text-[#2d4a6b] font-medium">
                        Lupa password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-[#395886] hover:bg-[#2d4a6b] text-white font-bold py-3 px-4 rounded-lg transition duration-200 transform hover:-translate-y-1 hover:shadow-lg">
                    Masuk
                </button>

                <!-- Divider -->
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Atau</span>
                    </div>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-sm text-[#395886] mb-4">
                        Belum punya akun?
                    </p>
                    <a href="{{ route('create-account') }}" 
                       class="w-full inline-block bg-[#D5DEEF] hover:bg-[#B1C9EF] text-[#2d4a6b] font-medium py-3 px-4 rounded-lg transition duration-200 border border-[#9db8e0]">
                        Daftar Akun Baru
                    </a>
                </div>
            </form>
        </div>

        <!-- Benefits -->
        <div class="mt-8 bg-white border-2 border-[#9db8e0] rounded-lg p-6 shadow-md">
            <h3 class="text-lg font-semibold text-[#2d4a6b] mb-4">Keuntungan Memiliki Akun:</h3>
            <ul class="space-y-3">
                <li class="flex items-center text-[#395886]">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 text-[#395886]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Proses sewa lebih cepat
                </li>
                <li class="flex items-center text-[#395886]">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 text-[#395886]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Riwayat transaksi tersimpan
                </li>
                <li class="flex items-center text-[#395886]">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 text-[#395886]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Bisa cek status sewa kapan saja
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection