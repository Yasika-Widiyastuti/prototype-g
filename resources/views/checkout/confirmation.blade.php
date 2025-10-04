@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran - Sewa Barang Konser')
@section('description', 'Upload bukti pembayaran untuk menyelesaikan pesanan Anda.')

@section('breadcrumbs')
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
    </svg>
    <a href="{{ route('checkout.index') }}" class="text-gray-500 hover:text-gray-700">Checkout</a>
</li>
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
    </svg>
    <a href="{{ route('checkout.payment') }}" class="text-gray-500 hover:text-gray-700">Pembayaran</a>
</li>
<li class="flex items-center">
    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/>
    </svg>
    <span class="text-gray-500">Konfirmasi</span>
</li>
@endsection

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Konfirmasi Pembayaran</h1>

            @if(session('error'))
                <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-600 border border-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-8">
                <div class="flex items-center">
                    <div class="flex items-center text-green-600">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-green-600 text-white text-sm font-medium">✓</div>
                        <span class="ml-4 text-sm font-medium">Review Pesanan</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-green-600 mx-4"></div>
                    <div class="flex items-center text-green-600">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-green-600 text-white text-sm font-medium">✓</div>
                        <span class="ml-4 text-sm font-medium">Pembayaran</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-blue-600 mx-4"></div>
                    <div class="flex items-center text-blue-600">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-600 text-white text-sm font-medium">3</div>
                        <span class="ml-4 text-sm font-medium">Konfirmasi</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('checkout.status') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Bank Tujuan Transfer
                    </label>
                    <div class="bg-gray-50 border border-gray-300 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">{{ $selectedBank['name'] }}</p>
                        <p>Nomor Rekening: <strong>{{ $selectedBank['rekening'] }}</strong></p>
                        <p>a.n. {{ $selectedBank['an'] }}</p>
                    </div>
                </div>

                <div>
                    <label for="bukti_transfer" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Bukti Transfer <span class="text-red-500">*</span>
                    </label>
                    
                    <div id="file-drop-area" class="relative">
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="bukti_transfer" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                        <span>Upload file</span>
                                        <input id="bukti_transfer" name="bukti_transfer" type="file" accept="image/*,.pdf" required class="sr-only">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, PDF max 5MB</p>
                            </div>
                        </div>
                        
                        <!-- Preview Area (Hidden by default) -->
                        <div id="file-preview" class="hidden mt-4 p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div id="file-icon" class="flex-shrink-0">
                                        <!-- Icon will be added by JavaScript -->
                                    </div>
                                    <div>
                                        <p id="file-name" class="text-sm font-medium text-gray-900"></p>
                                        <p id="file-size" class="text-xs text-gray-500"></p>
                                    </div>
                                </div>
                                <button type="button" id="remove-file" class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Image Preview (for image files) -->
                            <div id="image-preview" class="hidden mt-3">
                                <img id="preview-img" src="" alt="Preview" class="max-w-full h-48 object-contain mx-auto rounded">
                            </div>
                        </div>
                    </div>
                    
                    @error('bukti_transfer')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-800 mb-4">Ringkasan Pembayaran</h3>
                    <div class="flex justify-between text-blue-700">
                        <span>Total yang harus dibayar:</span>
                        <span class="font-bold text-xl">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-sm text-blue-600 mt-2">
                        Pastikan nominal transfer sesuai dengan total di atas
                    </p>
                </div>

                <div class="flex justify-between pt-6">
                    <a href="{{ route('checkout.payment') }}" 
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
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('bukti_transfer');
    const dropArea = document.getElementById('file-drop-area');
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const fileIcon = document.getElementById('file-icon');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const removeFileBtn = document.getElementById('remove-file');

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    // Highlight drop area when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });

    // Handle dropped files
    dropArea.addEventListener('drop', handleDrop, false);
    
    // Handle file input change
    fileInput.addEventListener('change', function(e) {
        handleFiles(e.target.files);
    });

    // Remove file functionality
    removeFileBtn.addEventListener('click', function() {
        fileInput.value = '';
        filePreview.classList.add('hidden');
        imagePreview.classList.add('hidden');
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight() {
        dropArea.classList.add('border-blue-400', 'bg-blue-50');
    }

    function unhighlight() {
        dropArea.classList.remove('border-blue-400', 'bg-blue-50');
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    function handleFiles(files) {
        if (files.length > 0) {
            const file = files[0];
            
            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
            if (!allowedTypes.includes(file.type)) {
                alert('Hanya file JPG, PNG, dan PDF yang diizinkan');
                return;
            }

            // Validate file size (5MB max)
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file maksimal 5MB');
                return;
            }

            // Update file input
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;

            // Show preview
            showFilePreview(file);
        }
    }

    function showFilePreview(file) {
        // Update file info
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);

        // Show appropriate icon
        if (file.type.startsWith('image/')) {
            fileIcon.innerHTML = `
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            `;

            // Show image preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else if (file.type === 'application/pdf') {
            fileIcon.innerHTML = `
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
            `;
            imagePreview.classList.add('hidden');
        }

        // Show preview container
        filePreview.classList.remove('hidden');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});
</script>
@endpush
@endsection