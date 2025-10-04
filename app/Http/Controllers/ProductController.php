<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

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

    // Add to Cart method - FIXED VERSION
    public function addToCart(Request $request, $id)
    {
        try {
            // Check if user is authenticated
            if (!auth()->check()) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false, 
                        'message' => 'Silakan login terlebih dahulu',
                        'redirect' => route('signIn')
                    ], 401);
                }
                return redirect()->route('signIn')->with('error', 'Silakan login terlebih dahulu');
            }

            // Determine product category based on current route
            $routeName = $request->route()->getName();
            $product = null;
            
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

            // Start session if not started
            if (!session()->isStarted()) {
                session()->start();
            }

            // Get current cart from session
            $cart = session()->get('cart', []);
            $cartKey = $category . '_' . $id;

            \Log::info('Before adding to cart:', [
                'cart_key' => $cartKey,
                'existing_cart' => $cart,
                'cart_count_before' => count($cart)
            ]);

            // Check if product already exists in cart
            $isExisting = isset($cart[$cartKey]);
            
            if ($isExisting) {
                // Product already in cart, increase quantity by 1
                $cart[$cartKey]['quantity'] += 1;
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
                    'description' => $product->description ?? ''
                ];
                $message = 'Produk berhasil ditambahkan ke keranjang!';
            }

            // Update session with new cart
            session()->put('cart', $cart);
            
            // Calculate total unique items (not quantity)
            $totalUniqueItems = count($cart);
            session()->put('cart_count', $totalUniqueItems);
            
            // Force save session
            session()->save();

            \Log::info('After adding to cart:', [
                'cart_key' => $cartKey,
                'updated_cart' => $cart,
                'cart_count_after' => count($cart),
                'is_existing' => $isExisting,
                'product_quantity' => $cart[$cartKey]['quantity']
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'cart_count' => $totalUniqueItems,
                    'product_name' => $product->name,
                    'product_quantity' => $cart[$cartKey]['quantity'],
                    'is_existing' => $isExisting
                ]);
            }

            return redirect()->back()->with('success', $message);
            
        } catch (\Exception $e) {
            \Log::error('Error adding to cart:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}