<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Review;

class ProfileOrderController extends Controller
{
    // List semua pesanan user
    public function index()
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(5);

        return view('profile.orders.index', compact('orders'));
    }

    // Detail pesanan tertentu
    public function show($id)
    {
        $order = Order::with('orderItems.product')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('profile.orders.show', compact('order'));
    }

    public function showReviewForm($orderId)
    {
        $order = Order::with(['orderItems.product.reviews' => function($query) {
                            $query->where('user_id', auth()->id());
                        }])
                        ->where('id', $orderId)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        // Only allow review for completed orders
        if ($order->status !== 'completed') {
            return redirect()->route('profile.orders.show', $order->id)
                            ->with('error', 'Ulasan hanya dapat diberikan untuk pesanan yang telah selesai.');
        }

        return view('profile.orders.review', compact('order'));
    }

    /**
     * Store reviews for order products
     */
    public function storeReview(Request $request, $orderId)
    {
        $order = Order::with('orderItems.product')
                        ->where('id', $orderId)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        // Validate order status
        if ($order->status !== 'completed') {
            return redirect()->route('profile.orders.show', $order->id)
                            ->with('error', 'Ulasan hanya dapat diberikan untuk pesanan yang telah selesai.');
        }

        // Validate request
        $validated = $request->validate([
            'reviews' => 'required|array',
            'reviews.*.product_id' => 'required|exists:products,id',
            'reviews.*.rating' => 'required|integer|min:1|max:5',
            'reviews.*.comment' => 'required|string|min:10|max:1000',
        ], [
            'reviews.*.rating.required' => 'Rating harus dipilih.',
            'reviews.*.comment.required' => 'Komentar harus diisi.',
            'reviews.*.comment.min' => 'Komentar minimal 10 karakter.',
        ]);

        $reviewedCount = 0;

        foreach ($validated['reviews'] as $reviewData) {
            // Check if product is in this order
            $orderItem = $order->orderItems()
                              ->where('product_id', $reviewData['product_id'])
                              ->first();

            if (!$orderItem) {
                continue;
            }

            // Check if already reviewed
            $existingReview = Review::where('user_id', auth()->id())
                                   ->where('product_id', $reviewData['product_id'])
                                   ->where('order_id', $order->id)
                                   ->first();

            if ($existingReview) {
                continue;
            }

            // Create review
            Review::create([
                'user_id' => auth()->id(),
                'product_id' => $reviewData['product_id'],
                'order_id' => $order->id,
                'rating' => $reviewData['rating'],
                'comment' => $reviewData['comment'],
                'user_name' => auth()->user()->name,
            ]);

            $reviewedCount++;
        }

        if ($reviewedCount > 0) {
            return redirect()->route('profile.orders.show', $order->id)
                            ->with('success', "Berhasil memberikan ulasan untuk {$reviewedCount} produk.");
        }

        return redirect()->route('profile.orders.show', $order->id)
                        ->with('info', 'Semua produk sudah pernah diulas sebelumnya.');
    }
}