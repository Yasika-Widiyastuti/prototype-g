@auth
    @if(auth()->user()->role === 'customer')
        @if(auth()->user()->verification_status === 'pending')
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-base font-semibold text-gray-900 mb-1">Akun Menunggu Verifikasi</h3>
                        <p class="text-sm text-gray-600">
                            Dokumen Anda sedang dalam proses verifikasi oleh admin. Anda dapat melihat produk, tetapi tidak dapat melakukan checkout hingga akun diverifikasi.
                        </p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @elseif(auth()->user()->verification_status === 'rejected')
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 border-l-4 border-red-500">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-base font-semibold text-gray-900 mb-1">Verifikasi Ditolak</h3>
                        <p class="text-sm text-gray-600 mb-2">
                            <strong>Alasan:</strong> {{ auth()->user()->verification_notes ?? 'Tidak ada catatan' }}
                        </p>
                        <p class="text-sm text-gray-600">
                            Silakan hubungi admin untuk informasi lebih lanjut atau upload ulang dokumen yang benar.
                        </p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    @endif
@endauth