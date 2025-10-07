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
                           ->get();
        
        return view('handphone.index', compact('products'));
    }

    public function handphoneShow($id)
    {
        $product = Product::where('category', 'handphone')
                          ->where('id', $id)
                          ->where('is_available', true)
                          ->firstOrFail();
        
        if (!$product) {
            abort(404);
        }
        
        $relatedProducts = Product::where('category', 'handphone')
                                 ->where('id', '!=', $id)
                                 ->where('is_available', true)
                                 ->where('stock', '>', 0)
                                 ->limit(3)
                                 ->get();

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
                           ->get();
        
        return view('lightstick.index', compact('products'));
    }

    public function lightstickShow($id)
    {
        $product = Product::where('category', 'lightstick')
                          ->where('id', $id)
                          ->where('is_available', true)
                          ->firstOrFail();
        
        if (!$product) {
            abort(404);
        }
        
        $relatedProducts = Product::where('category', 'lightstick')
                                 ->where('id', '!=', $id)
                                 ->where('is_available', true)
                                 ->where('stock', '>', 0)
                                 ->limit(3)
                                 ->get();

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
                           ->get();
        
        return view('powerbank.index', compact('products'));
    }

    public function powerbankShow($id)
    {
        $product = Product::where('category', 'powerbank')
                          ->where('id', $id)
                          ->where('is_available', true)
                          ->firstOrFail();
        
        if (!$product) {
            abort(404);
        }
        
        $relatedProducts = Product::where('category', 'powerbank')
                                 ->where('id', '!=', $id)
                                 ->where('is_available', true)
                                 ->where('stock', '>', 0)
                                 ->limit(3)
                                 ->get();
                                 
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
            // Validasi produk
            $product = Product::findOrFail($id);

            if ($product->stock < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok produk habis'
                ], 400);
            }

            $isExisting = false;
            $productQuantity = 1;

            if (Auth::check()) {
                // User logged in
                $existingCart = Cart::where('user_id', Auth::id())
                                    ->where('product_id', $id)
                                    ->first();

                if ($existingCart) {
                    $existingCart->quantity += 1;
                    $existingCart->save();
                    $productQuantity = $existingCart->quantity;
                    $isExisting = true;
                } else {
                    Cart::create([
                        'user_id' => Auth::id(),
                        'product_id' => $id,
                        'quantity' => 1,
                        'duration' => 1,
                        'start_date' => now()->toDateString(),
                        'end_date' => now()->toDateString(),
                    ]);
                    $productQuantity = 1;
                    $isExisting = false;
                }

                // Hitung total quantity
                $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

            } else {
                // Guest - session
                $cart = session('cart', []);
                $cartKey = $product->category . '_' . $product->id;

                if (isset($cart[$cartKey])) {
                    $cart[$cartKey]['quantity']++;
                    $productQuantity = $cart[$cartKey]['quantity'];
                    $isExisting = true;
                } else {
                    $cart[$cartKey] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => 1,
                        'category' => $product->category,
                        'image' => $product->image_url,
                        'duration' => 1,
                        'start_date' => now()->toDateString(),
                        'end_date' => now()->toDateString(),
                    ];
                    $productQuantity = 1;
                    $isExisting = false;
                }

                session()->put('cart', $cart);

                // Hitung total quantity
                $cartCount = 0;
                foreach ($cart as $item) {
                    $cartCount += $item['quantity'];
                }
            }

            // Update session cart_count
            session()->put('cart_count', $cartCount);

            // PENTING: Pastikan return JSON dengan status 200
            return response()->json([
                'success' => true,
                'message' => $isExisting 
                    ? "Quantity {$product->name} berhasil ditambahkan! (Total: {$productQuantity})"
                    : "{$product->name} berhasil ditambahkan ke keranjang!",
                'cart_count' => $cartCount,
                'product_quantity' => $productQuantity,
                'is_existing' => $isExisting
            ], 200); // Status 200 OK

        } catch (\Exception $e) {
            \Log::error('Add to cart error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
