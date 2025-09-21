<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    public function index()
    {
        // Mengambil data keranjang yang disimpan di session
        $cartItems = session('cart', []);

        // Menghitung total harga dari item keranjang
        $total = $this->calculateTotal($cartItems);

        // Mengirim data keranjang dan total harga ke view checkout.index
        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function payment()
    {
        return view('checkout.payment');
    }

    public function confirmation()
    {
        return view('checkout.confirmation');
    }

    public function paymentStatus(Request $request)
    {
        $request->validate([
            'bank' => 'required|string',
            'bukti_transfer' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $filePath = null;
        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('bukti_transfer', $filename, 'public');
        }

        $payment = new Payment();
        $payment->user_id = Auth::id();
        $payment->bank = $request->bank;
        $payment->bukti_transfer = $filePath;
        $payment->status = 'waiting';
        $payment->save();

        session()->forget('cart');
        session()->forget('cart_count');

        return view('checkout.status', ['payment' => $payment]);
    }

    private function calculateTotal($cartItems)
    {
        if (empty($cartItems)) {
            return 0;
        }

        return collect($cartItems)->sum(function ($item) {
            return isset($item['price']) && isset($item['quantity']) 
                ? $item['price'] * $item['quantity'] 
                : 0;
        });
    }
}