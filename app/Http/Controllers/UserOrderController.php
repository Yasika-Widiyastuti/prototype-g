<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['orderItems.product']) // eager loading
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('profile.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['orderItems.product'])
            ->where('id', $id)
            ->firstOrFail();

        return view('profile.orders.show', compact('order'));
    }
}