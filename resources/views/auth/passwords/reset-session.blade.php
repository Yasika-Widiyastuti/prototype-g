@extends('layouts.app')

@section('title', 'Reset Password - Sewa Barang Konser')

@section('content')
<!-- Background with gradient matching login -->
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-white to-orange-50">
    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto">
            
            <!-- Header with enhanced visual -->
            <div class="text-center mb-8 loading">
                <div class="relative mb-6">
                    <!-- Background decoration -->
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-orange-400 w-20 h-20 rounded-full mx-auto blur-lg opacity-30"></div>
                    <!-- Icon container -->
                    <div class="relative bg-gradient-to-r from-yellow-500 to-orange-500 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto shadow-lg transform hover:scale-105 transition duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-9a2 2 0 00-2-2H6a2 2 0 00-2 2v9a2 2 0 002 2zm10-12V9a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                </div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent mb-3">
                    Reset Password
                </h1>
                <p class="text-gray-600 text-lg">Buat password baru untuk akun: <strong>{{ $email }}</strong></p>
            </div>

            <!-- Form with enhanced styling -->
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/50 p-8 loading hover:shadow-2xl transition duration-300">
                
                <!-- Flash messages -->
                @if (session('status'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Session info -->
                @if(isset($expires_at))
                <div class="mb-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-800">Session Information</h4>
                            <p class="text-sm text-blue-700 mt-1">Session expires at: {{ $expires_at }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- FIXED: Single form tag that wraps everything -->
                <form method="POST" action="{{ route('password.reset-session') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">

                    <!-- Password Baru with enhanced toggle -->
                    <div class="relative">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-3">
                            Password Baru
                        </label>
                        <div class="relative group" x-data="{ showPassword: false }">
                            <input :type="showPassword ? 'text' : 'password'" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   class="w-full pl-12 pr-12 py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-yellow-500/20 focus:border-yellow-500 transition duration-300 bg-gray-50/50 group-hover:bg-white @error('password') border-red-400 focus:border-red-400 focus:ring-red-500/20 @enderror" 
                                   placeholder="Buat password baru yang kuat">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-yellow-500 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-9a2 2 0 00-2-2H6a2 2 0 00-2 2v9a2 2 0 002 2zm10-12V9a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <button type="button" 
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center hover:bg-gray-100 rounded-r-xl transition duration-300">
                                <svg x-show="!showPassword" class="h-5 w-5 text-gray-400 hover:text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="showPassword" class="h-5 w-5 text-gray-400 hover:text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="relative">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-3">
                            Konfirmasi Password
                        </label>
                        <div class="relative group" x-data="{ showConfirmPassword: false }">
                            <input :type="showConfirmPassword ? 'text' : 'password'" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required 
                                   class="w-full pl-12 pr-12 py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-yellow-500/20 focus:border-yellow-500 transition duration-300 bg-gray-50/50 group-hover:bg-white" 
                                   placeholder="Ulangi password baru">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-yellow-500 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5-4v12a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h2m8 0V6a2 2 0 012-2h2a2 2 0 012 2v2m0 0v12a2 2 0 01-2 2h-2m-8 0H6a2 2 0 01-2-2v-2"></path>
                                </svg>
                            </div>
                            <button type="button" 
                                    @click="showConfirmPassword = !showConfirmPassword"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center hover:bg-gray-100 rounded-r-xl transition duration-300">
                                <svg x-show="!showConfirmPassword" class="h-5 w-5 text-gray-400 hover:text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="showConfirmPassword" class="h-5 w-5 text-gray-400 hover:text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Password Requirements Info -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="text-sm font-semibold text-yellow-800 mb-2">Tips Password Aman:</h4>
                                <ul class="text-sm text-yellow-700 space-y-1">
                                    <li>• Minimal 8 karakter</li>
                                    <li>• Kombinasi huruf besar dan kecil</li>
                                    <li>• Sertakan angka dan simbol</li>
                                    <li>• Hindari informasi pribadi</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Submit Button -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-bold py-4 px-6 rounded-xl transition duration-300 transform hover:scale-[1.02] hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-yellow-500/50">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Reset Password
                        </span>
                    </button>

                    <!-- Enhanced Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500 font-medium">Atau</span>
                        </div>
                    </div>

                    <!-- Back to Login Link -->
                    <div class="text-center">
                        <a href="{{ route('password.request') }}" 
                           class="inline-flex items-center text-sm font-semibold text-yellow-600 hover:text-yellow-700 hover:underline transition duration-300 mr-4">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Gunakan Email Lain
                        </a>
                        <a href="{{ route('signIn') }}" 
                           class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-gray-700 hover:underline transition duration-300">
                            Kembali Login
                        </a>
                    </div>
                </form>
            </div>

            <!-- Security Notice -->
            <div class="mt-8 bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-200/50 rounded-2xl p-6 loading">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-9a2 2 0 00-2-2H6a2 2 0 00-2 2v9a2 2 0 002 2zm10-12V9a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">Keamanan Akun Terjamin</h3>
                        <p class="text-sm text-gray-600">
                            Password Anda akan dienkripsi dengan teknologi keamanan terdepan. 
                            Setelah reset berhasil, Anda dapat langsung mengakses semua fitur akun.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add custom CSS for animations -->
<style>
    .loading {
        animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Custom gradient text */
    .bg-clip-text {
        background-clip: text;
        -webkit-background-clip: text;
    }
</style>
@endsection