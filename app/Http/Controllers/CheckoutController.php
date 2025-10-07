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
    public function __construct()
    {
        // Allow browsing checkout pages for guests, but require auth for final submit/payment.
        // We'll enforce login when needed inside methods (payment submission / order creation).
    }

    /**
     * Step 1: Halaman checkout (menangani guest & auth)
     */
    public function index()
    {
        $cartItems = $this->getDetailedCartItems();

        // Jika keranjang kosong -> redirect ke cart
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Cek apakah user login & sudah diverifikasi
        // Cek status verifikasi user (bukan email verification)
        $showVerificationWarning = false;
        $verificationMessage = null;

        if (auth()->check()) {
            $user = auth()->user();

            if ($user->verification_status === 'pending') {
                $showVerificationWarning = true;
                $verificationMessage = 'Akun Anda masih menunggu verifikasi admin. Anda belum bisa melanjutkan checkout.';
            } elseif ($user->verification_status === 'rejected') {
                $showVerificationWarning = true;
                $verificationMessage = 'Verifikasi akun Anda ditolak. Alasan: ' . ($user->verification_notes ?? 'Tidak ada catatan dari admin.');
            } elseif (!$user->is_active) {
                $showVerificationWarning = true;
                $verificationMessage = 'Akun Anda sedang dinonaktifkan. Silakan hubungi admin.';
            }
        }

        // Ambil tanggal dari session atau dari item pertama
        $first = reset($cartItems);
        $startDate = session('start_date', $first['start_date'] ?? Carbon::now()->toDateString());
        $endDate = session('end_date', $first['end_date'] ?? Carbon::now()->toDateString());
        $duration = $first['duration'] ?? 1;

        $total = $this->calculateTotalFromItems($cartItems);

        return view('checkout.index', compact(
            'cartItems',
            'total',
            'startDate',
            'endDate',
            'duration',
            'showVerificationWarning',
            'verificationMessage'
        ));
    }


    /**
     * Update quantity untuk item (mendukung guest via session & user via DB)
     * body: cart_key, action (increase|decrease)
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
            // Cart item di DB: kita gunakan pola di getDetailedCartItems -> item menyimpan cart_id
            // Support: cart_key bisa berupa "<category>_<productId>" atau "cart_<cartId>"
            $cartId = $this->extractCartIdFromKey($cartKey);

            $cartItem = Cart::where('user_id', Auth::id())->where('id', $cartId)->first();
            if (!$cartItem) {
                return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan di keranjang'], 404);
            }

            $newQuantity = $cartItem->quantity + ($action === 'increase' ? 1 : -1);

            if ($newQuantity <= 0) {
                $cartItem->delete();
                $itemRemoved = true;
                $newQuantity = 0;
            } else {
                // cek stok bila perlu
                if ($cartItem->product && $cartItem->product->stock < $newQuantity) {
                    return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi.'], 400);
                }
                $cartItem->quantity = $newQuantity;
                $cartItem->save();
            }

        } else {
            // guest: session('cart') struktur: [cart_key => [id, name, price, quantity, duration,...]]
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

        // ambil ulang cart terperinci dan total
        $newCartItems = $this->getDetailedCartItems();
        $newTotal = $this->calculateTotalFromItems($newCartItems);
        $cartCount = count($newCartItems);
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
     * Hapus item (guest & auth)
     */
    public function removeItem(Request $request)
    {
        $request->validate(['cart_key' => 'required|string']);
        $cartKey = $request->cart_key;

        if (Auth::check()) {
            $cartId = $this->extractCartIdFromKey($cartKey);
            $deleted = Cart::where('user_id', Auth::id())->where('id', $cartId)->delete();
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
        $cartCount = count($newCartItems);
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
     * Update durasi untuk semua item (dari calendar) - mendukung guest & auth
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
            // update massal di DB
            $cartIds = Cart::where('user_id', Auth::id())->pluck('id')->toArray();
            if (!empty($cartIds)) {
                Cart::whereIn('id', $cartIds)->where('user_id', Auth::id())->update([
                    'duration' => $duration,
                    'start_date' => $start->toDateString(),
                    'end_date' => $end->toDateString(),
                ]);
            }
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
        session()->save();

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
     * Step 2: payment page - if guest: redirect to login to proceed payment
     */
    public function payment()
    {
        $cartItems = $this->getDetailedCartItems();
        if (empty($cartItems)) {
            return redirect()->route('checkout.index')->with('error', 'Keranjang Anda kosong.');
        }

        // jika guest, suruh login sebelum memilih metode pembayaran
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk melanjutkan pembayaran.');
        }
         // Cek verifikasi sebelum masuk halaman payment
        if (!auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('checkout.index')
                ->with('error', 'Akun Anda belum diverifikasi. Harap tunggu verifikasi admin.');
        }
        
        // Lanjut proses payment
        return view('checkout.payment');
        $subtotal = $this->calculateTotalFromItems($cartItems);
        $total = $subtotal + 5000;

        return view('checkout.payment', compact('cartItems', 'total'));
    }

    /**
     * Step 2b: Simpan pilihan bank
     */
    public function processPayment(Request $request)
    {
        $request->validate(['bank' => 'required|in:bca,mandiri,bri']);

        // simpan key bank & payment_method di session
        session(['selected_bank' => $request->bank, 'payment_method' => $request->bank]);

        return redirect()->route('checkout.confirmation')->with('success', 'Metode pembayaran berhasil dipilih.');
    }

    /**
     * Step 3: Konfirmasi pembayaran (menampilkan bank, order summary)
     */
    public function confirmation()
    {
        $cartItems = $this->getDetailedCartItems();
        if (empty($cartItems)) {
            return redirect()->route('checkout.index')->with('error', 'Keranjang Anda kosong.');
        }

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk konfirmasi pembayaran.');
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

        return view('checkout.confirmation', compact('cartItems', 'total', 'selectedBank', 'selectedBankKey'));
    }

    /**
     * Step 4: Upload bukti transfer & buat Order + OrderItems (hanya untuk user terautentikasi)
     */
    public function paymentStatus(Request $request)
    {
        $request->validate([
            'bukti_transfer' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
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
                return redirect()->route('checkout.index')->with('error', 'Keranjang kosong');
            }

            // hitung subtotal
            $subtotal = 0;
            foreach ($cartItems as $c) {
                if ($c->product) {
                    $subtotal += $c->quantity * $c->product->price * $c->duration;
                }
            }
            $totalAmount = $subtotal + 5000;

            // upload bukti
            $paymentProofPath = null;
            if ($request->hasFile('bukti_transfer')) {
                $file = $request->file('bukti_transfer');
                $filename = 'payment_' . time() . '_' . Auth::id() . '.' . $file->getClientOriginalExtension();
                $paymentProofPath = $file->storeAs('payment_proofs', $filename, 'public');
            }

            // create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'waiting_verification',
                'payment_method' => session('payment_method', 'transfer'),
                'payment_proof' => $paymentProofPath,
                'rental_date' => $cartItems->first()->start_date ?? now()->toDateString(),
                'rental_days' => $cartItems->first()->duration ?? 1,
            ]);

            // create order items and decrement stock
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

                // update stok aman
                $product = Product::find($cartItem->product_id);
                if ($product) {
                    $product->stock = max(0, $product->stock - $cartItem->quantity);
                    $product->save();
                }
            }

            // optional: simpan juga Payment record (jika Anda pakai model Payment)
            if (class_exists(Payment::class)) {
                Payment::create([
                    'user_id' => Auth::id(),
                    'order_id' => $order->id,
                    'bank' => $selectedBankKey,
                    'bukti_transfer' => $paymentProofPath,
                    'status' => 'waiting',
                ]);
            }

            // hapus cart DB user
            Cart::where('user_id', Auth::id())->delete();

            // bersihkan session terkait cart/payment
            session()->forget(['cart', 'cart_count', 'selected_bank', 'payment_method', 'start_date', 'end_date']);

            DB::commit();

            // pasang object sederhana untuk tampilan status
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
     * Ambil data keranjang terperinci (mendukung guest/session & auth/db)
     * returns array keyed by "<category>_<productId>" (sama seperti sebelumnya)
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
            // guest: asumsi session('cart') sudah berisi data lengkap seperti name, price, quantity, duration
            $cartItems = session('cart', []);
        }

        session()->put('cart_count', count($cartItems));
        return $cartItems;
    }

    /**
     * Hitung total dari array cartItems (yang dikembalikan getDetailedCartItems)
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
     * Extract cart_id from cart_key if possible.
     * Accept formats: "cart_123" or "<category>_123" -> returns 123
     */
    private function extractCartIdFromKey(string $cartKey)
    {
        // kalau key seperti 'cart_123' atau 'something_123' -> ambil angka terakhir
        $parts = explode('_', $cartKey);
        $last = end($parts);
        return is_numeric($last) ? (int)$last : 0;
    }

    /**
     * Daftar bank
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
