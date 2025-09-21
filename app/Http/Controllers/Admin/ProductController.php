<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index(Request $request)
    {
        $query = Product::query();

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter berdasarkan status ketersediaan
        if ($request->has('availability') && $request->availability != '') {
            if ($request->availability == 'available') {
                $query->where('is_available', true)->where('stock', '>', 0);
            } elseif ($request->availability == 'unavailable') {
                $query->where('is_available', false);
            } elseif ($request->availability == 'low_stock') {
                $query->where('stock', '<=', 2)->where('is_available', true);
            } elseif ($request->availability == 'out_of_stock') {
                $query->where('stock', 0);
            }
        }

        // Search berdasarkan nama atau deskripsi
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->latest()->paginate(10);

        // Untuk dropdown filter
        $categories = Product::getAvailableCategories();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Product::getAvailableCategories();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:handphone,lightstick,powerbank',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'required|url',
            'features' => 'nullable|string',
        ]);

        $features = $request->features ? explode(',', $request->features) : null;

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'image_url' => $request->image_url,
            'features' => $features,
            'is_available' => $request->has('is_available'),
        ]);

        // Log activity
        $this->activityLogService->logProductUpdate($product, 'created');

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        // Statistik produk
        $stats = [
            'total_orders' => $product->orderItems()->count(),
            'total_quantity_ordered' => $product->orderItems()->sum('quantity'),
            'total_revenue' => $product->orderItems()->sum('total'),
            'average_rating' => 0, // Bisa ditambahkan jika ada sistem rating
        ];

        // Recent orders untuk produk ini
        $recent_orders = $product->orderItems()
            ->with(['order.user'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.products.show', compact('product', 'stats', 'recent_orders'));
    }

    public function edit(Product $product)
    {
        $categories = Product::getAvailableCategories();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:handphone,lightstick,powerbank',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'required|url',
            'features' => 'nullable|string',
        ]);

        $features = $request->features ? explode(',', $request->features) : null;

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'image_url' => $request->image_url,
            'features' => $features,
            'is_available' => $request->has('is_available'),
        ]);

        // Log activity
        $this->activityLogService->logProductUpdate($product, 'updated');

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(Product $product)
    {
        // Cek apakah produk masih ada di order yang aktif
        $activeOrders = $product->orderItems()
            ->whereHas('order', function($query) {
                $query->whereIn('status', ['pending', 'paid', 'confirmed']);
            })
            ->count();

        if ($activeOrders > 0) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Tidak dapat menghapus produk yang masih ada di order aktif');
        }

        // Log activity sebelum dihapus
        $this->activityLogService->logProductUpdate($product, 'deleted');

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    // Method tambahan untuk bulk actions
    public function bulkUpdateStock(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.stock' => 'required|integer|min:0',
        ]);

        foreach ($request->products as $productData) {
            $product = Product::find($productData['id']);
            $oldStock = $product->stock;
            $product->update(['stock' => $productData['stock']]);

            // Log stock update
            $this->activityLogService->log(
                'product_stock_update',
                "Updated stock for {$product->name} from {$oldStock} to {$productData['stock']}",
                'Product',
                $product->id
            );
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Stok produk berhasil diupdate.');
    }

    public function toggleAvailability(Product $product)
    {
        $product->update(['is_available' => !$product->is_available]);

        $status = $product->is_available ? 'tersedia' : 'tidak tersedia';
        
        $this->activityLogService->log(
            'product_availability_toggle',
            "Changed product {$product->name} status to {$status}",
            'Product',
            $product->id
        );

        return redirect()->route('admin.products.index')
            ->with('success', "Produk {$product->name} berhasil diubah menjadi {$status}");
    }
}
