@extends('layouts.app')

@section('title', 'Reset Password - Sewa Barang Konser')

@section('content')
<!-- Background with gradient matching login -->
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50">
    <div class="py-8 lg:py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-lg mx-auto">
            
            <!-- Header with enhanced visual -->
            <div class="text-center mb-6 lg:mb-8 loading">
                <div class="relative mb-4 lg:mb-6">
                    <!-- Background decoration -->
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-400 w-16 h-16 lg:w-20 lg:h-20 rounded-full mx-auto blur-lg opacity-30"></div>
                    <!-- Icon container -->
                    <div class="relative bg-gradient-to-r from-blue-500 to-blue-500 w-16 h-16 lg:w-20 lg:h-20 rounded-2xl flex items-center justify-center mx-auto shadow-lg transform hover:scale-105 transition duration-300">
                        <svg class="w-8 h-8 lg:w-10 lg:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-9a2 2 0 00-2-2H6a2 2 0 00-2 2v9a2 2 0 002 2zm10-12V9a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                </div>
                <h1 class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent mb-2 lg:mb-3">
                    Reset Password
                </h1>
                <p class="text-gray-600 text-base lg:text-lg">Buat password baru untuk mengamankan akun Anda</p>
            </div>

            <!-- Form with enhanced styling -->
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/50 p-6 lg:p-8 loading hover:shadow-2xl transition duration-300">
                <form method="POST" action="{{ route('password.update') }}" class="space-y-5 lg:space-y-6" id="resetPasswordForm">
                    @csrf
                    
                    @if(!($uses_session ?? false))
                        <input type="hidden" name="token" value="{{ $token }}">
                    @endif

                    <!-- Email with floating label effect -->
                    <div class="relative">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2 lg:mb-3">
                            Alamat Email
                        </label>
                        <div class="relative group">
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ $email ?? old('email') }}" 
                                   required
                                   class="w-full pl-11 lg:pl-12 pr-4 py-3 lg:py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition duration-300 bg-gray-50/50 group-hover:bg-white text-sm lg:text-base @error('email') border-red-400 focus:border-red-400 focus:ring-red-500/20 @enderror" 
                                   placeholder="contoh@email.com">
                            <div class="absolute inset-y-0 left-0 pl-3 lg:pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-500 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Baru with enhanced toggle & validation -->
                    <div class="relative">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2 lg:mb-3">
                            Password Baru
                        </label>
                        <div class="relative group" x-data="{ showPassword: false }">
                            <input :type="showPassword ? 'text' : 'password'" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   class="w-full pl-11 lg:pl-12 pr-11 lg:pr-12 py-3 lg:py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition duration-300 bg-gray-50/50 group-hover:bg-white text-sm lg:text-base @error('password') border-red-400 focus:border-red-400 focus:ring-red-500/20 @enderror" 
                                   placeholder="Buat password baru yang kuat"
                                   x-on:input="validatePassword($event.target.value)">
                            <div class="absolute inset-y-0 left-0 pl-3 lg:pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-500 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-9a2 2 0 00-2-2H6a2 2 0 00-2 2v9a2 2 0 002 2zm10-12V9a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <button type="button" 
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-3 lg:pr-4 flex items-center hover:bg-gray-100 rounded-r-xl transition duration-300">
                                <svg x-show="!showPassword" class="h-5 w-5 text-gray-400 hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="showPassword" class="h-5 w-5 text-gray-400 hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        
                        <!-- Password Strength Indicator -->
                        <div id="passwordStrength" class="mt-2 hidden">
                            <div class="flex items-center gap-1 mb-1">
                                <div class="h-1 flex-1 rounded-full bg-gray-200" id="strength-bar-1"></div>
                                <div class="h-1 flex-1 rounded-full bg-gray-200" id="strength-bar-2"></div>
                                <div class="h-1 flex-1 rounded-full bg-gray-200" id="strength-bar-3"></div>
                                <div class="h-1 flex-1 rounded-full bg-gray-200" id="strength-bar-4"></div>
                            </div>
                            <p id="strengthText" class="text-xs text-gray-600"></p>
                        </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="relative">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2 lg:mb-3">
                            Konfirmasi Password
                        </label>
                        <div class="relative group" x-data="{ showConfirmPassword: false }">
                            <input :type="showConfirmPassword ? 'text' : 'password'" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required 
                                   class="w-full pl-11 lg:pl-12 pr-11 lg:pr-12 py-3 lg:py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition duration-300 bg-gray-50/50 group-hover:bg-white text-sm lg:text-base" 
                                   placeholder="Ulangi password baru"
                                   x-on:input="validatePasswordMatch()">
                            <div class="absolute inset-y-0 left-0 pl-3 lg:pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-500 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5-4v12a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h2m8 0V6a2 2 0 012-2h2a2 2 0 012 2v2m0 0v12a2 2 0 01-2 2h-2m-8 0H6a2 2 0 01-2-2v-2"></path>
                                </svg>
                            </div>
                            <button type="button" 
                                    @click="showConfirmPassword = !showConfirmPassword"
                                    class="absolute inset-y-0 right-0 pr-3 lg:pr-4 flex items-center hover:bg-gray-100 rounded-r-xl transition duration-300">
                                <svg x-show="!showConfirmPassword" class="h-5 w-5 text-gray-400 hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="showConfirmPassword" class="h-5 w-5 text-gray-400 hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        <p id="passwordMatchMessage" class="mt-2 text-sm hidden"></p>
                    </div>

                    <!-- Password Requirements Info (Dynamic) -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-blue-800 mb-2">Persyaratan Password (Wajib):</h4>
                                <ul class="text-xs lg:text-sm text-blue-700 space-y-1" id="passwordRequirements">
                                    <li id="req-length" class="flex items-center">
                                        <span class="req-icon mr-2">○</span>
                                        <span>Minimal 8 karakter</span>
                                    </li>
                                    <li id="req-uppercase" class="flex items-center">
                                        <span class="req-icon mr-2">○</span>
                                        <span>Minimal 1 huruf besar (A-Z)</span>
                                    </li>
                                    <li id="req-lowercase" class="flex items-center">
                                        <span class="req-icon mr-2">○</span>
                                        <span>Minimal 1 huruf kecil (a-z)</span>
                                    </li>
                                    <li id="req-number" class="flex items-center">
                                        <span class="req-icon mr-2">○</span>
                                        <span>Minimal 1 angka (0-9)</span>
                                    </li>
                                    <li id="req-special" class="flex items-center">
                                        <span class="req-icon mr-2">○</span>
                                        <span>Minimal 1 karakter khusus (!@#$%^&*)</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Submit Button -->
                    <button type="submit" 
                            id="submitBtn"
                            disabled
                            class="w-full bg-gradient-to-r from-blue-500 to-blue-500 hover:from-blue-600 hover:to-blue-600 text-white font-bold py-3 lg:py-4 px-6 rounded-xl transition duration-300 transform hover:scale-[1.02] hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-500/50 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none text-sm lg:text-base">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Reset Password
                        </span>
                    </button>

                    <!-- Enhanced Divider -->
                    <div class="relative my-5 lg:my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500 font-medium">Atau</span>
                        </div>
                    </div>

                    <!-- Back to Login Link - Fixed Alignment -->
                    <div class="text-center">
                        <a href="{{ route('signIn') }}" 
                           class="inline-flex items-center justify-center text-sm font-semibold text-blue-600 hover:text-blue-700 hover:underline transition duration-300">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span>Kembali ke Halaman Login</span>
                        </a>
                    </div>
                </form>
            </div>

            <!-- Security Notice -->
            <div class="mt-6 lg:mt-8 bg-gradient-to-r from-blue-50 to-blue-50 border-2 border-blue-200/50 rounded-2xl p-4 lg:p-6 loading">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 lg:w-6 lg:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-9a2 2 0 00-2-2H6a2 2 0 00-2 2v9a2 2 0 002 2zm10-12V9a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 lg:ml-4">
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">Keamanan Akun Terjamin</h3>
                        <p class="text-xs lg:text-sm text-gray-600">
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

    /* Requirement checked state */
    .req-checked {
        color: #15803d;
    }
    
    .req-checked .req-icon::before {
        content: '✓';
        font-weight: bold;
    }
    
    .req-icon::before {
        content: '○';
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const submitBtn = document.getElementById('submitBtn');
    const passwordStrengthDiv = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('strengthText');
    const matchMessage = document.getElementById('passwordMatchMessage');
    
    let passwordValid = false;
    let passwordsMatch = false;
    
    // Password validation function
    window.validatePassword = function(password) {
        if (password.length === 0) {
            passwordStrengthDiv.classList.add('hidden');
            passwordValid = false;
            updateSubmitButton();
            resetRequirements();
            return;
        }
        
        passwordStrengthDiv.classList.remove('hidden');
        
        // Check requirements
        const requirements = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
        };
        
        // Update UI for each requirement
        updateRequirement('req-length', requirements.length);
        updateRequirement('req-uppercase', requirements.uppercase);
        updateRequirement('req-lowercase', requirements.lowercase);
        updateRequirement('req-number', requirements.number);
        updateRequirement('req-special', requirements.special);
        
        // Calculate strength
        const metRequirements = Object.values(requirements).filter(Boolean).length;
        passwordValid = metRequirements === 5;
        
        // Update strength bars
        updateStrengthBars(metRequirements);
        
        // Update strength text
        const strengthTexts = [
            'Sangat Lemah',
            'Lemah',
            'Cukup',
            'Kuat',
            'Sangat Kuat'
        ];
        const strengthColors = [
            'text-red-600',
            'text-orange-600',
            'text-blue-600',
            'text-green-600',
            'text-green-700'
        ];
        
        strengthText.textContent = 'Kekuatan Password: ' + strengthTexts[metRequirements - 1];
        strengthText.className = 'text-xs ' + strengthColors[metRequirements - 1];
        
        // Validate match if confirmation is filled
        if (passwordConfirmInput.value) {
            validatePasswordMatch();
        }
        
        updateSubmitButton();
    };
    
    // Update requirement UI
    function updateRequirement(id, met) {
        const element = document.getElementById(id);
        if (met) {
            element.classList.add('req-checked');
        } else {
            element.classList.remove('req-checked');
        }
    }
    
    // Reset requirements UI
    function resetRequirements() {
        ['length', 'uppercase', 'lowercase', 'number', 'special'].forEach(req => {
            document.getElementById('req-' + req).classList.remove('req-checked');
        });
    }
    
    // Update strength bars
    function updateStrengthBars(count) {
        const colors = ['bg-blue-500', 'bg-blue-500', 'bg-blue-500', 'bg-blue-500', 'bg-blue-600'];
        
        for (let i = 1; i <= 4; i++) {
            const bar = document.getElementById('strength-bar-' + i);
            bar.className = 'h-1 flex-1 rounded-full';
            
            if (i <= count) {
                bar.classList.add(colors[Math.min(count - 1, 4)]);
            } else {
                bar.classList.add('bg-gray-200');
            }
        }
    }
    
    // Validate password match
    window.validatePasswordMatch = function() {
        const password = passwordInput.value;
        const confirmPassword = passwordConfirmInput.value;
        
        if (confirmPassword.length === 0) {
            matchMessage.classList.add('hidden');
            passwordsMatch = false;
            updateSubmitButton();
            return;
        }
        
        matchMessage.classList.remove('hidden');
        
        if (password === confirmPassword) {
            matchMessage.textContent = '✓ Password cocok';
            matchMessage.className = 'mt-2 text-sm text-green-600 flex items-center';
            passwordsMatch = true;
        } else {
            matchMessage.textContent = '✗ Password tidak cocok';
            matchMessage.className = 'mt-2 text-sm text-red-600 flex items-center';
            passwordsMatch = false;
        }
        
        updateSubmitButton();
    };
    
    // Update submit button state
    function updateSubmitButton() {
        if (passwordValid && passwordsMatch) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }
    
    // Initialize
    if (passwordInput.value) {
        validatePassword(passwordInput.value);
    }
});
</script>
@endsection