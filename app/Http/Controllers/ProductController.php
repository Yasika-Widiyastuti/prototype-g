<?php
namespace App\Http\Controllers;

use App\Models\Product;
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
        
        return view('handphone.show', compact('product', 'relatedProducts'));
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
        
        return view('lightstick.show', compact('product', 'relatedProducts'));
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
        
        return view('powerbank.show', compact('product', 'relatedProducts'));
    }

    // Add to Cart method
    public function addToCart(Request $request, $id)
    {
        try {
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
                \Log::error('Product not found or unavailable', ['id' => $id, 'route' => $routeName]);
                return response()->json(['success' => false, 'message' => 'Produk tidak tersedia'], 404);
            }

            // Get current cart from session
            $cart = session()->get('cart', []);
            $cartKey = $category . '_' . $id;

            \Log::info('Before adding to cart:', [
                'product' => $product->toArray(),
                'category' => $category,
                'cart_key' => $cartKey,
                'existing_cart_count' => count($cart)
            ]);

            // If product already in cart, increase quantity
            if (isset($cart[$cartKey])) {
                $cart[$cartKey]['quantity']++;
                \Log::info('Increased quantity for existing item');
            } else {
                // Add new product to cart with database data
                $cart[$cartKey] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => (int) $product->price,
                    'image' => $product->image_url,
                    'category' => $category,
                    'quantity' => 1,
                    'description' => $product->description ?? ''
                ];
                \Log::info('Added new item to cart', ['item' => $cart[$cartKey]]);
            }

            // Force session start if not started
            if (!session()->isStarted()) {
                session()->start();
            }

            // Update cart in session with explicit put
            session()->put('cart', $cart);
            session()->put('cart_count', count($cart));
            
            // Force session save - THIS IS CRITICAL
            session()->save();
            
            // Verify session was saved
            $verifyCart = session('cart', []);
            $verifyCount = session('cart_count', 0);
            
            \Log::info('After session save verification:', [
                'saved_cart_count' => count($verifyCart),
                'saved_cart_count_session' => $verifyCount,
                'session_id' => session()->getId()
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Produk berhasil ditambahkan ke keranjang',
                    'cart_count' => count($cart),
                    'debug_cart' => $verifyCart
                ]);
            }

            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
            
        } catch (\Exception $e) {
            \Log::error('Error adding to cart:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false, 
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}