<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\Cart; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon; 
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    // Main shop page
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        // Get all available products from database
        $query = Product::where('is_available', true)->where('stock', '>', 0);
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        
        $products = $query->latest()->get();
        
        return view('products.index', compact('search', 'products'));
    }

    // Handphone methods
    public function handphoneIndex()
    {
        $products = Product::where('category', 'handphone')
                           ->where('is_available', true)
                           ->where('stock', '>', 0)
                           ->get()
                           ->map(function($product) {
                               return [
                                   'id' => $product->id,
                                   'name' => $product->name,
                                   'price' => $product->price,
                                   'image' => $product->image_url,
                                   'description' => $product->description
                               ];
                           });
        
        return view('handphone.index', compact('products'));
    }

    public function handphoneShow($id)
    {
        $product = Product::where('category', 'handphone')
                          ->where('id', $id)
                          ->where('is_available', true)
                          ->where('stock', '>', 0)
                          ->first();
        
        if (!$product) {
            abort(404);
        }
        
        // Convert to array format for view compatibility
        $product = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image_url, // Menggunakan ->image_url
            'description' => $product->description
        ];
        
        $relatedProducts = Product::where('category', 'handphone')
                                 ->where('id', '!=', $id)
                                 ->where('is_available', true)
                                 ->where('stock', '>', 0)
                                 ->limit(2)
                                 ->get()
                                 ->map(function($item) {
                                     return [
                                         'id' => $item->id,
                                         'name' => $item->name,
                                         'price' => $item->price,
                                         'image' => $item->image_url,
                                         'description' => $item->description
                                     ];
                                 });
        $reviews = Review::where('product_id', $id)
        ->with('user')
        ->latest()
        ->get();

        return view('handphone.show', compact('product', 'relatedProducts', 'reviews'));
    }

    // Lightstick methods
    public function lightstickIndex()
    {
        $products = Product::where('category', 'lightstick')
                           ->where('is_available', true)
                           ->where('stock', '>', 0)
                           ->get()
                           ->map(function($product) {
                               return [
                                   'id' => $product->id,
                                   'name' => $product->name,
                                   'price' => $product->price,
                                   'image' => $product->image_url,
                                   'description' => $product->description
                               ];
                           });
        
        return view('lightstick.index', compact('products'));
    }

    public function lightstickShow($id)
    {
        $product = Product::where('category', 'lightstick')
                          ->where('id', $id)
                          ->where('is_available', true)
                          ->where('stock', '>', 0)
                          ->first();
        
        if (!$product) {
            abort(404);
        }
        
        // Convert to array format for view compatibility
        $product = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image_url,
            'description' => $product->description
        ];
        
        $relatedProducts = Product::where('category', 'lightstick')
                                 ->where('id', '!=', $id)
                                 ->where('is_available', true)
                                 ->where('stock', '>', 0)
                                 ->limit(2)
                                 ->get()
                                 ->map(function($item) {
                                     return [
                                         'id' => $item->id,
                                         'name' => $item->name,
                                         'price' => $item->price,
                                         'image' => $item->image_url,
                                         'description' => $item->description
                                     ];
                                 });
        $reviews = Review::where('product_id', $id)
        ->with('user')
        ->latest()
        ->get();

        return view('lightstick.show', compact('product', 'relatedProducts', 'reviews'));
    }

    // Powerbank methods
    public function powerbankIndex()
    {
        $products = Product::where('category', 'powerbank')
                           ->where('is_available', true)
                           ->where('stock', '>', 0)
                           ->get()
                           ->map(function($product) {
                               return [
                                   'id' => $product->id,
                                   'name' => $product->name,
                                   'price' => $product->price,
                                   'image' => $product->image_url,
                                   'description' => $product->description
                               ];
                           });
        
        return view('powerbank.index', compact('products'));
    }

    public function powerbankShow($id)
    {
        $product = Product::where('category', 'powerbank')
                          ->where('id', $id)
                          ->where('is_available', true)
                          ->where('stock', '>', 0)
                          ->first();
        
        if (!$product) {
            abort(404);
        }
        
        // Convert to array format for view compatibility
        $product = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image_url,
            'description' => $product->description
        ];
        
        $relatedProducts = Product::where('category', 'powerbank')
                                 ->where('id', '!=', $id)
                                 ->where('is_available', true)
                                 ->where('stock', '>', 0)
                                 ->limit(2)
                                 ->get()
                                 ->map(function($item) {
                                     return [
                                         'id' => $item->id,
                                         'name' => $item->name,
                                         'price' => $item->price,
                                         'image' => $item->image_url,
                                         'description' => $item->description
                                     ];
                                 });
        $reviews = Review::where('product_id', $id)
        ->with('user')
        ->latest()
        ->get();

        return view('powerbank.show', compact('product', 'relatedProducts', 'reviews'));
    }
    
    // =================================================================
    // START: LOGIKA KERANJANG (CART LOGIC) - Halaman Cart
    // =================================================================
    
    /**
     * Menampilkan halaman keranjang.
     */
    public function cart()
    {
        $cartItems = [];
        $totalHarga = 0; // <--- Variabel ini hanya digunakan di method ini
        
        if (Auth::check()) {
            // JIKA PENGGUNA LOGIN: Ambil data keranjang dari DATABASE
            $dbCart = Cart::where('user_id', Auth::id())
                        ->with('product')
                        ->get();

            foreach ($dbCart as $item) {
                // Pastikan produk ada sebelum melanjutkan
                if ($item->product) { 
                    $itemKey = $item->product->category . '_' . $item->product_id;
                    // Hitung subtotal berdasarkan harga produk, kuantitas, dan durasi sewa
                    $subtotal = $item->quantity * $item->product->price * $item->duration;
                    $totalHarga += $subtotal; // <-- Perhitungan Total
                    
                    $cartItems[$itemKey] = [
                        // ... detail item
                        'cart_id' => $item->id, // PENTING: ID dari baris tabel carts
                    ];
                }
            }
            
            // Update cart_count di session agar selalu sinkron dengan DB 
            $totalUniqueItems = $dbCart->count();
            session()->put('cart_count', $totalUniqueItems);

        } else {
            // JIKA GUEST: Ambil data keranjang dari SESSION
            if (session('cart')) {
                $cartItems = session('cart');
                foreach ($cartItems as $item) {
                    // Hitung total harga dari item di session
                    $totalHarga += $item['price'] * $item['quantity'] * ($item['duration'] ?? 1); 
                }
            }
            // Pastikan cart_count di session diupdate
            session()->put('cart_count', count($cartItems));
        }

        // Mengirim ke view
        return view('cart.index', compact('cartItems', 'totalHarga')); 
    }


    // Add to Cart method - PERMANENT VERSION
    public function addToCart(Request $request, $id)
    {
        try {
            // Determine product category based on current route
            $routeName = $request->route()->getName();
            $product = null;
            $category = null;
            
            if (str_contains($routeName, 'handphone')) {
                $product = Product::where('category', 'handphone')->find($id);
                $category = 'handphone';
            } elseif (str_contains($routeName, 'lightstick')) {
                $product = Product::where('category', 'lightstick')->find($id);
                $category = 'lightstick';
            } elseif (str_contains($routeName, 'powerbank')) {
                $product = Product::where('category', 'powerbank')->find($id);
                $category = 'powerbank';
            }

            if (!$product || !$product->is_available || $product->stock <= 0) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false, 
                        'message' => 'Produk tidak tersedia atau stok habis'
                    ], 404);
                }
                return redirect()->back()->with('error', 'Produk tidak tersedia atau stok habis');
            }

            // --- LOGIKA PERMANEN (DATABASE) vs TEMPORARY (SESSION) ---
            if (Auth::check()) {
                // User sudah Login: Simpan ke Database (Tabel 'carts')
                
                $cartItem = Cart::firstOrNew([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id
                ]);

                $isExisting = $cartItem->exists;
                $newQuantity = $cartItem->quantity + 1; // Kuantitas yang diinginkan
                
                // --- KOREKSI KRUSIAL: Pengecekan Stok DB ---
                if ($product->stock < $newQuantity) {
                    $message = 'Stok produk tidak mencukupi untuk penambahan ini. Maksimal stok: ' . $product->stock;
                    return redirect()->back()->with('error', $message);
                }
                // --- END KOREKSI STOK DB ---

                // Jika stok aman, update kuantitas
                $cartItem->quantity = $newQuantity;

                if ($isExisting) {
                    $message = 'Quantity produk berhasil ditambahkan! (Jumlah: ' . $cartItem->quantity . ')';
                } else {
                    // Produk baru, set tanggal default
                    $cartItem->start_date = Carbon::now()->toDateString();
                    $cartItem->end_date = Carbon::now()->addDay()->toDateString(); // Default 1 hari
                    $cartItem->duration = 1;
                    $message = 'Produk berhasil ditambahkan ke keranjang!';
                }

                $cartItem->save(); // SIMPAN SETELAH STOK DIPASTIKAN AMAN
                $totalUniqueItems = Cart::where('user_id', Auth::id())->count();
                
                // --- FIX KRUSIAL: Update session cart_count untuk user yang login ---
                session()->put('cart_count', $totalUniqueItems);
                // --- END FIX ---
                
            } else {
                // User adalah Guest: Simpan ke Session (Logika lama Anda)
                
                // Start session if not started
                if (!session()->isStarted()) {
                    session()->start();
                }

                $cart = session()->get('cart', []);
                $cartKey = $category . '_' . $id;

                $isExisting = isset($cart[$cartKey]);
                $currentQuantity = $isExisting ? $cart[$cartKey]['quantity'] : 0;
                $newQuantity = $currentQuantity + 1; // Kuantitas yang diinginkan
                
                // --- KOREKSI KRUSIAL: Pengecekan Stok Session ---
                if ($product->stock < $newQuantity) {
                     $message = 'Stok produk tidak mencukupi untuk penambahan ini. Maksimal stok: ' . $product->stock;
                     return redirect()->back()->with('error', $message);
                }
                // --- END KOREKSI STOK Session ---

                if ($isExisting) {
                    // Product already in cart, update quantity
                    $cart[$cartKey]['quantity'] = $newQuantity;
                    $message = 'Quantity produk berhasil ditambahkan! (Jumlah: ' . $cart[$cartKey]['quantity'] . ')';
                } else {
                    // Add new product to cart with quantity 1
                    $cart[$cartKey] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => (int) $product->price,
                        'image' => $product->image_url,
                        'category' => $category,
                        'quantity' => 1,
                        'description' => $product->description ?? '',
                        // KOREKSI: Tambah field rental untuk konsistensi dengan DB
                        'start_date' => Carbon::now()->toDateString(),
                        'end_date' => Carbon::now()->addDay()->toDateString(),
                        'duration' => 1, 
                    ];
                    $message = 'Produk berhasil ditambahkan ke keranjang!';
                }

                // KOREKSI: Hitung subtotal setelah kuantitas di-update
                $cart[$cartKey]['subtotal'] = $cart[$cartKey]['price'] * $cart[$cartKey]['quantity'] * ($cart[$cartKey]['duration'] ?? 1);
                
                // Update session with new cart
                session()->put('cart', $cart);
                
                // Calculate total unique items (not quantity)
                $totalUniqueItems = count($cart);
                session()->put('cart_count', $totalUniqueItems);
                session()->save(); // Force save session
            }
            // --- END LOGIKA CART ---

            Log::info('Cart updated:', [
                'user_id' => Auth::id() ?? 'Guest',
                'product_id' => $id,
                'cart_count' => $totalUniqueItems,
                'is_existing' => $isExisting
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'cart_count' => $totalUniqueItems,
                    'product_name' => $product->name,
                    'is_existing' => $isExisting
                ]);
            }

            return redirect()->back()->with('success', $message);
            
        } catch (\Exception $e) {
            Log::error('Error adding to cart:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Terjadi kesalahan sistem. Silakan coba lagi. (' . $e->getMessage() . ')' 
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}
