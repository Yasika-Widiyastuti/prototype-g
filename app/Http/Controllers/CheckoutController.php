<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // Step 1: Halaman checkout
    public function index()
    {
        $cartItems = session('cart', []);
        $total = $this->calculateTotal($cartItems);

        return view('checkout.index', compact('cartItems', 'total'));
    }

    // Update quantity produk di cart
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
            'action' => 'required|in:increase,decrease'
        ]);

        $cart = session('cart', []);
        $cartKey = $request->cart_key;

        if (!isset($cart[$cartKey])) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan di keranjang'
                ], 404);
            }
            return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang');
        }

        if ($request->action === 'increase') {
            $cart[$cartKey]['quantity']++;
        } else { // decrease
            $cart[$cartKey]['quantity']--;
            
            // Jika quantity jadi 0, hapus item dari cart
            if ($cart[$cartKey]['quantity'] <= 0) {
                unset($cart[$cartKey]);
            }
        }

        // Update session
        session()->put('cart', $cart);
        session()->put('cart_count', count($cart));
        session()->save();

        $newTotal = $this->calculateTotal($cart);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'cart_count' => count($cart),
                'new_total' => $newTotal,
                'formatted_total' => number_format($newTotal, 0, ',', '.'),
                'item_removed' => $request->action === 'decrease' && !isset($cart[$cartKey]),
                'new_quantity' => isset($cart[$cartKey]) ? $cart[$cartKey]['quantity'] : 0,
                'message' => isset($cart[$cartKey]) 
                    ? 'Barang berhasil diupdate' 
                    : 'Produk berhasil dihapus dari keranjang'
            ]);
        }

        return redirect()->back()->with('success', 'Keranjang berhasil diupdate');
    }

    // Hapus item dari cart
    public function removeItem(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string'
        ]);

        $cart = session('cart', []);
        $cartKey = $request->cart_key;

        if (!isset($cart[$cartKey])) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan di keranjang'
                ], 404);
            }
            return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang');
        }

        // Hapus item
        unset($cart[$cartKey]);

        // Update session
        session()->put('cart', $cart);
        session()->put('cart_count', count($cart));
        session()->save();

        $newTotal = $this->calculateTotal($cart);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'cart_count' => count($cart),
                'new_total' => $newTotal,
                'formatted_total' => number_format($newTotal, 0, ',', '.'),
                'message' => 'Produk berhasil dihapus dari keranjang'
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang');
    }

    // Step 2: Halaman payment
    public function payment()
    {
        $cartItems = session('cart', []);
        $total = $this->calculateTotal($cartItems) + 5000; // biaya admin

        return view('checkout.payment', compact('cartItems', 'total'));
    }

    // Step 2b: Proses simpan pilihan bank
    public function processPayment(Request $request)
    {
        $request->validate([
            'bank' => 'required|in:bca,mandiri,bri',
        ]);

        session(['selected_bank' => $request->bank]);

        return redirect()->route('checkout.confirmation')
            ->with('success', 'Metode pembayaran berhasil dipilih.');
    }

    // Step 3: Konfirmasi pembayaran
    public function confirmation()
    {
        $cartItems = session('cart', []);
        $total = $this->calculateTotal($cartItems) + 5000;

        $selectedBankKey = session('selected_bank');
        if (!$selectedBankKey) {
            return redirect()->route('checkout.payment')
                ->with('error', 'Silakan pilih metode pembayaran terlebih dahulu.');
        }

        $banks = $this->getBanks();
        if (!array_key_exists($selectedBankKey, $banks)) {
            return redirect()->route('checkout.payment')
                ->with('error', 'Bank yang dipilih tidak valid.');
        }

        $selectedBank = $banks[$selectedBankKey];

        return view('checkout.confirmation', compact(
            'cartItems',
            'total',
            'selectedBank',
            'selectedBankKey'
        ));
    }

    // Step 4: Upload bukti transfer
    public function paymentStatus(Request $request)
    {
        $request->validate([
            'bukti_transfer' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $selectedBankKey = session('selected_bank');
        if (!$selectedBankKey) {
            return redirect()->route('checkout.payment')
                ->with('error', 'Metode pembayaran tidak ditemukan.');
        }

        $banks = $this->getBanks();
        if (!array_key_exists($selectedBankKey, $banks)) {
            return redirect()->route('checkout.payment')
                ->with('error', 'Bank tidak valid.');
        }

        // Upload file
        $filePath = null;
        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('bukti_transfer', $filename, 'public');
        }

        // Simpan ke database
        $payment = Payment::create([
            'user_id'        => Auth::id(),
            'bank'           => $selectedBankKey,
            'bukti_transfer' => $filePath,
            'status'         => 'waiting',
        ]);

        // Bersihkan session
        session()->forget(['cart', 'cart_count', 'selected_bank']);

        return view('checkout.status', compact('payment'));
    }

    // List bank
    private function getBanks(): array
    {
        return [
            'bca' => [
                'name'     => 'Bank BCA',
                'rekening' => '1234567890',
                'an'       => 'PT Sewa Konser Indonesia',
            ],
            'mandiri' => [
                'name'     => 'Bank Mandiri',
                'rekening' => '9876543210',
                'an'       => 'PT Sewa Konser Indonesia',
            ],
            'bri' => [
                'name'     => 'Bank BRI',
                'rekening' => '1122334455',
                'an'       => 'PT Sewa Konser Indonesia',
            ],
        ];
    }

    // Hitung total harga
    private function calculateTotal($cartItems): int
    {
        if (empty($cartItems)) {
            return 0;
        }

        return collect($cartItems)->sum(fn($item) =>
            (isset($item['price'], $item['quantity']))
                ? $item['price'] * $item['quantity']
                : 0
        );
    }
}