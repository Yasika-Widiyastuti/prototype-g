@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran - Sewa Barang Konser')
@section('description', 'Upload bukti pembayaran untuk menyelesaikan pesanan Anda.')

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
    <a href="{{ route('payment') }}" class="text-gray-500 hover:text-gray-700">Pembayaran</a>
</li>
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
    <span class="text-gray-500">Konfirmasi</span>
</li>
@endsection

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Konfirmasi Pembayaran</h1>
            
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
                    <div class="flex items-center text-green-600">
                        <div class="flex-shrink-0 w-8 h-8 border-2 border-green-600 rounded-full bg-green-600 text-white flex items-center justify-center text-sm font-medium">
                            ✓
                        </div>
                        <span class="ml-4 text-sm font-medium">Pembayaran</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-blue-600 mx-4"></div>
                    <div class="flex items-center text-blue-600">
                        <div class="flex-shrink-0 w-8 h-8 border-2 border-blue-600 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-medium">
                            3
                        </div>
                        <span class="ml-4 text-sm font-medium">Konfirmasi</span>
                    </div>
                </div>
            </div>

            <!-- Upload Form -->
            <form action="{{ route('payment.status') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Bank Selection -->
                <div>
                    <label for="bank" class="block text-sm font-medium text-gray-700 mb-2">
                        Bank Tujuan Transfer <span class="text-red-500">*</span>
                    </label>
                    <select name="bank" 
                            id="bank" 
                            required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih bank yang Anda gunakan untuk transfer</option>
                        <option value="bca">Bank BCA - 1234567890</option>
                        <option value="mandiri">Bank Mandiri - 9876543210</option>
                        <option value="bri">Bank BRI - 1122334455</option>
                    </select>
                    @error('bank')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Bukti Transfer -->
                <div>
                    <label for="bukti_transfer" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Bukti Transfer <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="bukti_transfer" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload file</span>
                                    <input id="bukti_transfer" 
                                           name="bukti_transfer" 
                                           type="file" 
                                           accept="image/*,.pdf" 
                                           required 
                                           class="sr-only">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, PDF sampai 5MB</p>
                        </div>
                    </div>
                    @error('bukti_transfer')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Summary -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-800 mb-4">Ringkasan Pembayaran</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between text-blue-700">
                            <span>Total yang harus dibayar:</span>
                            <span class="font-bold text-xl">Rp 90.000</span>
                        </div>
                        <p class="text-sm text-blue-600">
                            Pastikan nominal transfer sesuai dengan total di atas
                        </p>
                    </div>
                </div>

                <!-- Important Notes -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                    <div class="flex">
                        <svg class="w-5 h-5 text-yellow-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-yellow-800 mb-1">Penting!</h3>
                            <ul class="text-sm text-yellow-700 list-disc list-inside space-y-1">
                                <li>Upload bukti transfer yang jelas dan dapat dibaca</li>
                                <li>Pastikan nominal transfer tepat sesuai total pembayaran</li>
                                <li>Verifikasi akan dilakukan maksimal 2 jam kerja</li>
                                <li>Anda akan mendapat notifikasi via email setelah pembayaran dikonfirmasi</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-between pt-6">
                    <a href="{{ route('payment') }}" 
                       class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-6 py-3 rounded-lg transition">
                        Kembali
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg transition">
                        Kirim Konfirmasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// File upload preview
document.getElementById('bukti_transfer').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const fileName = file.name;
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        
        // Show file info
        const fileInfo = document.createElement('div');
        fileInfo.className = 'mt-2 text-sm text-gray-600';
        fileInfo.innerHTML = `File dipilih: ${fileName} (${fileSize} MB)`;
        
        // Remove existing file info
        const existingInfo = e.target.parentElement.parentElement.parentElement.querySelector('.file-info');
        if (existingInfo) {
            existingInfo.remove();
        }
        
        fileInfo.className += ' file-info';
        e.target.parentElement.parentElement.parentElement.appendChild(fileInfo);
    }
});
</script>
@endpush
@endsection