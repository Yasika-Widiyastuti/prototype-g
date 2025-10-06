<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    /**
     * Step 1: Halaman checkout
     */
    public function index()
    {
        $cartItems = $this->getDetailedCartItems();

        if (empty($cartItems)) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong.');
        }

        $first = reset($cartItems);
        $startDate = session('start_date', $first['start_date'] ?? Carbon::now()->toDateString());
        $endDate = session('end_date', $first['end_date'] ?? Carbon::now()->toDateString());
        $duration = $first['duration'] ?? 1;

        $total = $this->calculateTotalFromItems($cartItems);

        // PENTING: Update cart_count dengan TOTAL QUANTITY (bukan unique items)
        $this->updateCartCount();

        return view('checkout.index', compact('cartItems', 'total', 'startDate', 'endDate', 'duration'));
    }

    /**
     * Update quantity
     */
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
            'action' => 'required|in:increase,decrease'
        ]);

        $cartKey = $request->cart_key;
        $action = $request->action;
        $itemRemoved = false;
        $newQuantity = 0;

        if (Auth::check()) {
            // Extract product_id dari cart_key (format: category_productId)
            $parts = explode('_', $cartKey);
            $productId = end($parts);

            $cartItem = Cart::where('user_id', Auth::id())
                           ->where('product_id', $productId)
                           ->first();

            if (!$cartItem) {
                return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan di keranjang'], 404);
            }

            $newQuantity = $cartItem->quantity + ($action === 'increase' ? 1 : -1);

            if ($newQuantity <= 0) {
                $cartItem->delete();
                $itemRemoved = true;
                $newQuantity = 0;
            } else {
                // Cek stok
                if ($cartItem->product && $cartItem->product->stock < $newQuantity) {
                    return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi.'], 400);
                }
                $cartItem->quantity = $newQuantity;
                $cartItem->save();
            }

        } else {
            // Guest
            $cart = session('cart', []);
            if (!isset($cart[$cartKey])) {
                return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan di keranjang'], 404);
            }

            $newQuantity = $cart[$cartKey]['quantity'] + ($action === 'increase' ? 1 : -1);

            if ($newQuantity <= 0) {
                unset($cart[$cartKey]);
                $itemRemoved = true;
                $newQuantity = 0;
            } else {
                $cart[$cartKey]['quantity'] = $newQuantity;
            }

            session()->put('cart', $cart);
        }

        $newCartItems = $this->getDetailedCartItems();
        $newTotal = $this->calculateTotalFromItems($newCartItems);
        
        // PERBAIKAN: Hitung TOTAL QUANTITY (bukan unique items)
        $cartCount = $this->calculateCartCount($newCartItems);
        session()->put('cart_count', $cartCount);

        $itemData = $itemRemoved ? null : ($newCartItems[$cartKey] ?? null);
        $formattedItemSubtotal = '0';
        if ($itemData) {
            $duration = $itemData['duration'] ?? 1;
            $subtotal = ($itemData['price'] ?? 0) * ($itemData['quantity'] ?? 0) * $duration;
            $formattedItemSubtotal = number_format($subtotal, 0, ',', '.');
        }

        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'new_total' => $newTotal,
            'formatted_total' => number_format($newTotal, 0, ',', '.'),
            'item_removed' => $itemRemoved,
            'new_quantity' => $newQuantity,
            'formatted_item_subtotal' => $formattedItemSubtotal,
            'message' => $itemRemoved ? 'Produk berhasil dihapus dari keranjang' : 'Barang berhasil diupdate'
        ]);
    }

    /**
     * Hapus item
     */
    public function removeItem(Request $request)
    {
        $request->validate(['cart_key' => 'required|string']);
        $cartKey = $request->cart_key;

        if (Auth::check()) {
            $parts = explode('_', $cartKey);
            $productId = end($parts);
            
            $deleted = Cart::where('user_id', Auth::id())
                         ->where('product_id', $productId)
                         ->delete();

            if (!$deleted) {
                return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan di keranjang'], 404);
            }
        } else {
            $cart = session('cart', []);
            if (!isset($cart[$cartKey])) {
                return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan di keranjang'], 404);
            }
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
        }

        $newCartItems = $this->getDetailedCartItems();
        $newTotal = $this->calculateTotalFromItems($newCartItems);
        
        // PERBAIKAN: Hitung TOTAL QUANTITY
        $cartCount = $this->calculateCartCount($newCartItems);
        session()->put('cart_count', $cartCount);

        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'new_total' => $newTotal,
            'formatted_total' => number_format($newTotal, 0, ',', '.'),
            'message' => 'Produk berhasil dihapus dari keranjang'
        ]);
    }

    /**
     * Update durasi semua item
     */
    public function updateAllDuration(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
        ]);

        $start = Carbon::parse($request->start_date)->startOfDay();
        $end = Carbon::parse($request->end_date)->startOfDay();

        if ($end->lt($start)) {
            return response()->json(['success' => false, 'message' => 'Tanggal kembali tidak boleh lebih awal dari tanggal mulai sewa.'], 422);
        }

        $duration = $start->diffInDays($end) + 1;
        if ($duration > 30) $duration = 30;

        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->update([
                'duration' => $duration,
                'start_date' => $start->toDateString(),
                'end_date' => $end->toDateString(),
            ]);
        } else {
            $cart = session('cart', []);
            foreach ($cart as $k => $v) {
                $cart[$k]['duration'] = $duration;
                $cart[$k]['start_date'] = $start->toDateString();
                $cart[$k]['end_date'] = $end->toDateString();
            }
            session()->put('cart', $cart);
        }

        session()->put('start_date', $start->toDateString());
        session()->put('end_date', $end->toDateString());

        $newCartItems = $this->getDetailedCartItems();
        $newTotal = $this->calculateTotalFromItems($newCartItems);

        $items = [];
        foreach ($newCartItems as $k => $item) {
            $itSub = ($item['price'] ?? 0) * ($item['quantity'] ?? 0) * ($item['duration'] ?? 1);
            $items[$k] = [
                'subtotal' => $itSub,
                'formatted_subtotal' => number_format($itSub, 0, ',', '.')
            ];
        }

        return response()->json([
            'success' => true,
            'duration' => $duration,
            'new_total' => $newTotal,
            'formatted_total' => number_format($newTotal, 0, ',', '.'),
            'items' => $items,
            'message' => 'Durasi peminjaman berhasil diupdate untuk semua produk'
        ]);
    }

    /**
     * Payment page
     */
    public function payment()
    {
        $cartItems = $this->getDetailedCartItems();
        if (empty($cartItems)) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong.');
        }

        if (!Auth::check()) {
            return redirect()->route('signIn')->with('error', 'Silakan login terlebih dahulu untuk melanjutkan pembayaran.');
        }

        $subtotal = $this->calculateTotalFromItems($cartItems);
        $total = $subtotal + 5000;

        $this->updateCartCount();

        return view('checkout.payment', compact('cartItems', 'total'));
    }

    /**
     * Process payment method selection
     */
    public function processPayment(Request $request)
    {
        $request->validate(['bank' => 'required|in:bca,mandiri,bri']);
        session(['selected_bank' => $request->bank, 'payment_method' => $request->bank]);
        return redirect()->route('checkout.confirmation')->with('success', 'Metode pembayaran berhasil dipilih.');
    }

    /**
     * Confirmation page
     */
    public function confirmation()
    {
        $cartItems = $this->getDetailedCartItems();
        if (empty($cartItems)) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong.');
        }

        if (!Auth::check()) {
            return redirect()->route('signIn')->with('error', 'Silakan login terlebih dahulu untuk konfirmasi pembayaran.');
        }

        $subtotal = $this->calculateTotalFromItems($cartItems);
        $total = $subtotal + 5000;

        $selectedBankKey = session('selected_bank');
        if (!$selectedBankKey) {
            return redirect()->route('checkout.payment')->with('error', 'Silakan pilih metode pembayaran terlebih dahulu.');
        }

        $banks = $this->getBanks();
        if (!array_key_exists($selectedBankKey, $banks)) {
            return redirect()->route('checkout.payment')->with('error', 'Bank yang dipilih tidak valid.');
        }

        $selectedBank = $banks[$selectedBankKey];
        $this->updateCartCount();

        return view('checkout.confirmation', compact('cartItems', 'total', 'selectedBank', 'selectedBankKey'));
    }

    /**
     * Upload bukti transfer & create order
     */
    public function paymentStatus(Request $request)
    {
        $request->validate([
            'bukti_transfer' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if (!Auth::check()) {
            return redirect()->route('signIn')->with('error', 'Silakan login terlebih dahulu.');
        }

        $selectedBankKey = session('selected_bank');
        if (!$selectedBankKey) {
            return redirect()->route('checkout.payment')->with('error', 'Metode pembayaran tidak ditemukan.');
        }

        $banks = $this->getBanks();
        if (!array_key_exists($selectedBankKey, $banks)) {
            return redirect()->route('checkout.payment')->with('error', 'Bank tidak valid.');
        }

        DB::beginTransaction();
        try {
            $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('home')->with('error', 'Keranjang kosong');
            }

            $subtotal = 0;
            foreach ($cartItems as $c) {
                if ($c->product) {
                    $subtotal += $c->quantity * $c->product->price * $c->duration;
                }
            }
            $totalAmount = $subtotal + 5000;

            $paymentProofPath = null;
            if ($request->hasFile('bukti_transfer')) {
                $file = $request->file('bukti_transfer');
                $filename = 'payment_' . time() . '_' . Auth::id() . '.' . $file->getClientOriginalExtension();
                $paymentProofPath = $file->storeAs('payment_proofs', $filename, 'public');
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'waiting_verification',
                'payment_method' => session('payment_method', 'transfer'),
                'payment_proof' => $paymentProofPath,
                'rental_date' => $cartItems->first()->start_date ?? now()->toDateString(),
                'rental_days' => $cartItems->first()->duration ?? 1,
            ]);

            foreach ($cartItems as $cartItem) {
                if (!$cartItem->product) continue;

                $lineTotal = $cartItem->quantity * $cartItem->product->price * $cartItem->duration;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                    'total' => $lineTotal,
                ]);

                $product = Product::find($cartItem->product_id);
                if ($product) {
                    $product->stock = max(0, $product->stock - $cartItem->quantity);
                    $product->save();
                }
            }

            if (class_exists(Payment::class)) {
                Payment::create([
                    'user_id' => Auth::id(),
                    'order_id' => $order->id,
                    'bank' => $selectedBankKey,
                    'bukti_transfer' => $paymentProofPath,
                    'status' => 'waiting',
                ]);
            }

            Cart::where('user_id', Auth::id())->delete();
            session()->forget(['cart', 'cart_count', 'selected_bank', 'payment_method', 'start_date', 'end_date']);

            DB::commit();

            $payment = (object)[
                'status' => 'waiting',
                'order' => $order
            ];

            return view('checkout.status', compact('payment'));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Get detailed cart items
     */
    private function getDetailedCartItems(): array
    {
        $cartItems = [];

        if (Auth::check()) {
            $dbCart = Cart::where('user_id', Auth::id())->with('product')->get();

            foreach ($dbCart as $item) {
                if ($item->product) {
                    $itemKey = $item->product->category . '_' . $item->product_id;
                    $duration = $item->duration ?? 1;
                    $subtotal = $item->quantity * $item->product->price * $duration;

                    $cartItems[$itemKey] = [
                        'cart_id' => $item->id,
                        'id' => $item->product_id,
                        'name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                        'category' => $item->product->category,
                        'duration' => $duration,
                        'subtotal' => $subtotal,
                        'image' => $item->product->image_url,
                        'start_date' => $item->start_date,
                        'end_date' => $item->end_date,
                    ];
                }
            }
        } else {
            $cartItems = session('cart', []);
        }

        return $cartItems;
    }

    /**
     * Calculate total from cart items
     */
    private function calculateTotalFromItems(array $cartItems): int
    {
        if (empty($cartItems)) return 0;

        $total = 0;
        foreach ($cartItems as $it) {
            $price = $it['price'] ?? 0;
            $qty = $it['quantity'] ?? 0;
            $dur = $it['duration'] ?? 1;
            $total += $price * $qty * $dur;
        }
        return $total;
    }

    /**
     * Calculate TOTAL QUANTITY (not unique items) dari cart
     */
    private function calculateCartCount(array $cartItems): int
    {
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['quantity'] ?? 0;
        }
        return $total;
    }

    /**
     * Update cart_count di session
     */
    private function updateCartCount(): void
    {
        $cartItems = $this->getDetailedCartItems();
        $count = $this->calculateCartCount($cartItems);
        session()->put('cart_count', $count);
    }

    /**
     * Static method untuk dipanggil dari mana saja
     */
    public static function getCartCount(): int
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->sum('quantity');
        }
        
        $cart = session('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['quantity'] ?? 0;
        }
        return $total;
    }

    /**
     * Bank list
     */
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
}