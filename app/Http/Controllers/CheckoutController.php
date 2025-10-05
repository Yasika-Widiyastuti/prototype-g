<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CheckoutController extends Controller
{
    // Step 1: Halaman checkout
    public function index()
    {
        // 1. Ambil data keranjang yang sudah LENGKAP detailnya (menggabungkan Session + DB Product)
        $cartItems = $this->getDetailedCartItems(); 

        // 2. Ambil nilai tanggal dari session atau item pertama yang sudah lengkap
        $firstItem = reset($cartItems);
        
        // Gunakan session/default untuk mengisi tanggal
        $startDate = session('start_date', $firstItem['start_date'] ?? now()->toDateString());
        $endDate = session('end_date', $firstItem['end_date'] ?? now()->toDateString());
        $duration = $firstItem['duration'] ?? 1;

        // 3. Hitung total
        $total = $this->calculateTotal($cartItems);

        // 4. Kirim data lengkap ke view
        return view('checkout.index', compact('cartItems', 'total', 'startDate', 'endDate', 'duration'));
    }


    // Update quantity produk di cart
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
            'action' => 'required|in:increase,decrease'
        ]);

        $cartKey = $request->cart_key;
        $action = $request->action;

        // Pisahkan cartKey untuk mendapatkan product_id
        // Contoh: 'powerbank_12' -> product_id = 12
        $parts = explode('_', $cartKey);
        $productId = end($parts); // Ambil bagian terakhir sebagai product_id

        $itemRemoved = false;

        if (Auth::check()) {
            // --- LOGIKA UNTUK PENGGUNA LOGIN (DATABASE) ---
            $cartItem = Cart::where('user_id', Auth::id())
                            ->where('product_id', $productId)
                            ->first();
            
            if (!$cartItem) {
                return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan di keranjang'], 404);
            }

            $newQuantity = $cartItem->quantity;

            if ($action === 'increase') {
                $newQuantity++;
            } else { // decrease
                $newQuantity--;
            }

            if ($newQuantity <= 0) {
                $cartItem->delete();
                $itemRemoved = true;
                $newQuantity = 0;
            } else {
                $cartItem->quantity = $newQuantity;
                $cartItem->save();
            }

        } else {
            // --- LOGIKA UNTUK GUEST (SESSION) ---
            $cart = session('cart', []);
            
            if (!isset($cart[$cartKey])) {
                return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan di keranjang'], 404);
            }
            
            $newQuantity = $cart[$cartKey]['quantity'];

            if ($action === 'increase') {
                $newQuantity++;
            } else { // decrease
                $newQuantity--;
            }

            if ($newQuantity <= 0) {
                unset($cart[$cartKey]);
                $itemRemoved = true;
                $newQuantity = 0;
            } else {
                $cart[$cartKey]['quantity'] = $newQuantity;
            }
            
            session()->put('cart', $cart);
        }
        
        // Ambil data terbaru untuk menghitung total
        $newCartItems = $this->getDetailedCartItems();
        $newTotal = $this->calculateTotal($newCartItems);
        $cartCount = count($newCartItems);

        $itemData = $itemRemoved ? null : ($newCartItems[$cartKey] ?? null);
        $formattedItemSubtotal = '0';
        
        if ($itemData) {
            $duration = $itemData['duration'] ?? 1;
            $subtotal = $itemData['price'] * $itemData['quantity'] * $duration;
            $formattedItemSubtotal = number_format($subtotal, 0, ',', '.');
        }

        session()->put('cart_count', $cartCount); // Sinkronisasi cart_count

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

    // Update durasi peminjaman (deprecated - replaced by updateAllDuration)
    public function updateDuration(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
            'action' => 'required|in:increase,decrease'
        ]);

        $cart = session('cart', []);
        $cartKey = $request->cart_key;

        if (!isset($cart[$cartKey])) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan di keranjang'
            ], 404);
        }

        // Initialize duration if not exists (default 1 day)
        if (!isset($cart[$cartKey]['duration'])) {
            $cart[$cartKey]['duration'] = 1;
        }

        if ($request->action === 'increase') {
            // Max 30 days
            if ($cart[$cartKey]['duration'] < 30) {
                $cart[$cartKey]['duration']++;
            }
        } else { // decrease
            // Min 1 day
            if ($cart[$cartKey]['duration'] > 1) {
                $cart[$cartKey]['duration']--;
            }
        }

        // Update session
        session()->put('cart', $cart);
        session()->save();

        $newTotal = $this->calculateTotal($cart);

        return response()->json([
            'success' => true,
            'new_duration' => $cart[$cartKey]['duration'],
            'new_total' => $newTotal,
            'formatted_total' => number_format($newTotal, 0, ',', '.'),
            'item_subtotal' => $cart[$cartKey]['price'] * $cart[$cartKey]['quantity'] * $cart[$cartKey]['duration'],
            'formatted_item_subtotal' => number_format($cart[$cartKey]['price'] * $cart[$cartKey]['quantity'] * $cart[$cartKey]['duration'], 0, ',', '.'),
            'message' => 'Durasi peminjaman berhasil diupdate'
        ]);
    }

    // Update durasi untuk semua item sekaligus (dari calendar)
    public function updateAllDuration(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        // Ambil data keranjang dengan cara yang konsisten (dari DB jika login)
        // Gunakan getDetailedCartItems() untuk memastikan kita mendapatkan data yang benar
        $cartItems = $this->getDetailedCartItems();
        
        if (empty($cartItems)) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang kosong'
            ], 404);
        }

        // 1. Konversi dan Hitung Durasi (Logika yang sudah benar)
        $start = Carbon::parse($request->start_date)->setTimezone('Asia/Jakarta')->startOfDay();
        $end = Carbon::parse($request->end_date)->setTimezone('Asia/Jakarta')->startOfDay();

        if ($end->lt($start)) {
            return response()->json([
                'success' => false,
                'message' => 'Tanggal kembali tidak boleh lebih awal dari tanggal mulai sewa.'
            ], 422);
        }

        $duration = $start->diffInDays($end) + 1;
        
        if ($duration > 30) {
            $duration = 30;
        }

        // 2. LOGIKA PERBAIKAN: Update Data Keranjang (DB atau Session)
        if (Auth::check()) {
            // --- PENGGUNA LOGIN: UPDATE DATABASE ---
            $userId = Auth::id();
            
            // Ambil ID Cart yang relevan dari data yang sudah kita load (untuk efisiensi)
            $cartIds = collect($cartItems)->pluck('cart_id')->filter()->unique()->toArray();
            
            if (!empty($cartIds)) {
                // Lakukan update massal (mass update) di tabel carts
                \App\Models\Cart::whereIn('id', $cartIds)
                    ->where('user_id', $userId)
                    ->update([
                        'duration' => $duration,
                        'start_date' => $start->toDateString(),
                        'end_date' => $end->toDateString(),
                    ]);
            }
            
        } else {
            // --- GUEST: UPDATE SESSION (Logika lama Anda yang sudah benar untuk guest) ---
            $cart = session('cart', []);
            foreach ($cart as $cartKey => $item) {
                $cart[$cartKey]['duration'] = $duration;
                $cart[$cartKey]['start_date'] = $start->toDateString();
                $cart[$cartKey]['end_date'] = $end->toDateString();
            }
            session()->put('cart', $cart);
        }
        
        // Update session tanggal yang dipilih (tetap lakukan untuk konsistensi)
        session()->put('start_date', $start->toDateString());
        session()->put('end_date', $end->toDateString());
        session()->save();

        // 3. Ambil ulang data keranjang terbaru untuk perhitungan total dan respons JSON
        $newCartItems = $this->getDetailedCartItems(); // Panggil lagi untuk mendapatkan data terbaru
        $newTotal = $this->calculateTotal($newCartItems);

        // 4. Siapkan respons JSON
        $items = [];
        foreach ($newCartItems as $cartKey => $item) {
            // Gunakan $item yang sudah diupdate dari $newCartItems
            $itemSubtotal = $item['price'] * $item['quantity'] * $item['duration'];
            $items[$cartKey] = [
                'subtotal' => $itemSubtotal,
                'formatted_subtotal' => number_format($itemSubtotal, 0, ',', '.')
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


    // Hapus item dari cart
    public function removeItem(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string'
        ]);

        $cartKey = $request->cart_key;

        if (Auth::check()) {
            // --- LOGIKA UNTUK PENGGUNA LOGIN (DATABASE) ---
            // Pisahkan cartKey untuk mendapatkan product_id
            $parts = explode('_', $cartKey);
            $productId = end($parts);
            
            $deleted = Cart::where('user_id', Auth::id())
                        ->where('product_id', $productId)
                        ->delete();

            if (!$deleted) {
                return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan di keranjang'], 404);
            }

        } else {
            // --- LOGIKA UNTUK GUEST (SESSION) ---
            $cart = session('cart', []);
            
            if (!isset($cart[$cartKey])) {
                return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan di keranjang'], 404);
            }

            unset($cart[$cartKey]);
            session()->put('cart', $cart);
        }

        // Ambil data terbaru untuk menghitung total
        $newCartItems = $this->getDetailedCartItems();
        $newTotal = $this->calculateTotal($newCartItems);
        $cartCount = count($newCartItems);
        
        session()->put('cart_count', $cartCount); // Sinkronisasi cart_count

        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'new_total' => $newTotal,
            'formatted_total' => number_format($newTotal, 0, ',', '.'),
            'message' => 'Produk berhasil dihapus dari keranjang'
        ]);
    }

    // Step 2: Halaman payment
    public function payment()
    {
        // GANTI: $cartItems = session('cart', []);
        $cartItems = $this->getDetailedCartItems(); // Ambil dari DB/Session yang sudah terperinci
        
        // Tambahkan validasi keranjang tidak boleh kosong sebelum lanjut
        if (empty($cartItems)) {
            return redirect()->route('checkout.index')
                            ->with('error', 'Keranjang Anda kosong. Silakan tambahkan produk terlebih dahulu.');
        }

        $subtotal = $this->calculateTotal($cartItems);
        $total = $subtotal + 5000; // biaya admin

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
        // Ambil data keranjang dari DB (jika login) atau Session (jika guest)
        $cartItems = $this->getDetailedCartItems();
        
        // --- TAMBAHAN PENTING: Validasi Keranjang Kosong ---
        if (empty($cartItems)) {
            return redirect()->route('checkout.index')
                            ->with('error', 'Keranjang Anda kosong. Tidak dapat melanjutkan konfirmasi pembayaran.');
        }
        // --------------------------------------------------
        
        $subtotal = $this->calculateTotal($cartItems);
        $total = $subtotal + 5000;

        $selectedBankKey = session('selected_bank');
        
        // Validasi pemilihan bank
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
        $payment = \App\Models\Payment::create([
            'user_id'        => Auth::id(),
            'bank'           => $selectedBankKey,
            'bukti_transfer' => $filePath,
            'status'         => 'waiting',
        ]);

        // Hapus keranjang dari DATABASE untuk pengguna yang login
        \App\Models\Cart::where('user_id', Auth::id())->delete();
        // Bersihkan session
        session()->forget(['cart', 'cart_count', 'selected_bank']);

        return view('checkout.status', compact('payment'));
    }

    private function getDetailedCartItems(): array
    {
        $cartItems = [];
        
        if (Auth::check()) {
            // 1. Ambil dari DATABASE (Jika pengguna login)
            // Logika ini diambil dari ProductController@cart()
            $dbCart = \App\Models\Cart::where('user_id', Auth::id())
                                    ->with('product')
                                    ->get();

            foreach ($dbCart as $item) {
                if ($item->product) { 
                    $itemKey = $item->product->category . '_' . $item->product_id;
                    $duration = $item->duration ?? 1;
                    $subtotal = $item->quantity * $item->product->price * $duration;

                    $cartItems[$itemKey] = [
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
                        'cart_id' => $item->id,
                    ];
                }
            }

        } else {
            // 2. Ambil dari SESSION (Jika Guest/Belum login)
            // Item di session sudah berisi detail yang cukup (price, name, dll.)
            $cartItems = session('cart', []);
            
            // Opsional: Pastikan harga/detail di-refresh dari DB untuk Guest
            // (Jika Anda yakin data di session sudah lengkap, langkah ini tidak perlu)
        }

        // Pastikan cart_count di session di-update sesuai data yang ditemukan
        session()->put('cart_count', count($cartItems));

        return $cartItems;
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

    // Hitung total harga (dengan durasi)
    private function calculateTotal(array $cartItems): int
    {
        if (empty($cartItems)) {
            return 0;
        }

        return collect($cartItems)->sum(function($item) {
            $price = $item['price'] ?? 0;
            $quantity = $item['quantity'] ?? 0;
            $duration = $item['duration'] ?? 1;

            return $price * $quantity * $duration;
        });
    }
}