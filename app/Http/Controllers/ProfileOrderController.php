<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

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
}
