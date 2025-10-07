@extends('layouts.app')

@section('title', 'Beri Ulasan - ' . $order->order_number)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('profile.orders.show', $order->id) }}" 
               class="flex items-center text-blue-600 hover:text-blue-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Detail Pesanan
            </a>
        </div>

        <!-- Header -->
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Beri Ulasan Produk</h1>
            <p class="text-gray-600">Pesanan: {{ $order->order_number }}</p>
        </div>

        <!-- Review Form for Each Product -->
        <form action="{{ route('profile.orders.review.store', $order->id) }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                @foreach($order->orderItems as $index => $item)
                    @if($item->product)
                    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                        <!-- Product Info -->
                        <div class="flex items-center space-x-4 mb-6 pb-4 border-b border-gray-200">
                            <img src="{{ asset('storage/' . $item->product->image_url) }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="w-16 h-16 rounded-lg object-cover">
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-600">{{ ucfirst($item->product->category) }}</p>
                            </div>
                        </div>

                        <input type="hidden" name="reviews[{{ $index }}][product_id]" value="{{ $item->product_id }}">

                        <!-- Check if already reviewed -->
                        @php
                            $existingReview = $item->product->reviews()
                                ->where('user_id', auth()->id())
                                ->where('order_id', $order->id)
                                ->first();
                        @endphp

                        @if($existingReview)
                            <!-- Already Reviewed -->
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="font-semibold text-gray-800">Sudah Diulas</span>
                                </div>
                                <div class="flex items-center mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= $existingReview->rating ? 'text-yellow-400' : 'text-gray-300' }} fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                    <span class="ml-2 text-sm text-gray-600">({{ $existingReview->rating }}/5)</span>
                                </div>
                                <p class="text-gray-700">{{ $existingReview->comment }}</p>
                            </div>
                        @else
                            <!-- Rating Stars -->
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Rating <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center space-x-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <input type="radio" 
                                               name="reviews[{{ $index }}][rating]" 
                                               value="{{ $i }}" 
                                               id="rating_{{ $index }}_{{ $i }}" 
                                               class="hidden peer/rating{{ $i }}" 
                                               required>
                                        <label for="rating_{{ $index }}_{{ $i }}" 
                                               class="cursor-pointer star-rating" 
                                               data-index="{{ $index }}" 
                                               data-rating="{{ $i }}">
                                            <svg class="w-8 h-8 text-gray-300 hover:text-yellow-400 transition fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </label>
                                    @endfor
                                </div>
                                @error("reviews.{$index}.rating")
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Comment -->
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Ulasan Anda <span class="text-red-500">*</span>
                                </label>
                                <textarea name="reviews[{{ $index }}][comment]" 
                                          rows="4" 
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          placeholder="Ceritakan pengalaman Anda dengan produk ini..."
                                          required>{{ old("reviews.{$index}.comment") }}</textarea>
                                @error("reviews.{$index}.comment")
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    </div>
                    @endif
                @endforeach
            </div>

            <!-- Submit Button -->
            @if($order->orderItems->filter(function($item) use ($order) {
                return $item->product && !$item->product->reviews()
                    ->where('user_id', auth()->id())
                    ->where('order_id', $order->id)
                    ->exists();
            })->count() > 0)
                <div class="mt-6 flex justify-end space-x-4">
                    <a href="{{ route('profile.orders.show', $order->id) }}" 
                       class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Kirim Ulasan
                    </button>
                </div>
            @else
                <div class="mt-6">
                    <a href="{{ route('profile.orders.show', $order->id) }}" 
                       class="inline-block px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                        Kembali
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>

@push('scripts')
<script>
// Star Rating Interaction
document.querySelectorAll('.star-rating').forEach(star => {
    star.addEventListener('click', function() {
        const index = this.dataset.index;
        const rating = parseInt(this.dataset.rating);
        
        // Update visual feedback
        document.querySelectorAll(`[data-index="${index}"]`).forEach((s, i) => {
            const svg = s.querySelector('svg');
            if (i < rating) {
                svg.classList.remove('text-gray-300');
                svg.classList.add('text-yellow-400');
            } else {
                svg.classList.remove('text-yellow-400');
                svg.classList.add('text-gray-300');
            }
        });
    });
    
    // Hover effect
    star.addEventListener('mouseenter', function() {
        const index = this.dataset.index;
        const rating = parseInt(this.dataset.rating);
        
        document.querySelectorAll(`[data-index="${index}"]`).forEach((s, i) => {
            const svg = s.querySelector('svg');
            if (i < rating) {
                svg.classList.add('text-yellow-400');
            }
        });
    });
    
    star.addEventListener('mouseleave', function() {
        const index = this.dataset.index;
        const checkedRating = document.querySelector(`input[name="reviews[${index}][rating]"]:checked`);
        
        if (checkedRating) {
            const selectedRating = parseInt(checkedRating.value);
            document.querySelectorAll(`[data-index="${index}"]`).forEach((s, i) => {
                const svg = s.querySelector('svg');
                if (i < selectedRating) {
                    svg.classList.add('text-yellow-400');
                    svg.classList.remove('text-gray-300');
                } else {
                    svg.classList.remove('text-yellow-400');
                    svg.classList.add('text-gray-300');
                }
            });
        } else {
            document.querySelectorAll(`[data-index="${index}"]`).forEach(s => {
                const svg = s.querySelector('svg');
                svg.classList.remove('text-yellow-400');
                svg.classList.add('text-gray-300');
            });
        }
    });
});
</script>
@endpush
@endsection