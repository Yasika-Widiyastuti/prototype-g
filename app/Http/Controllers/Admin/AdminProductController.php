<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    // List produk
    public function index(Request $request)
    {
        $categories = Product::distinct()->pluck('category', 'category'); // kategori unik
        $query = Product::query();

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

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

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->latest()->paginate(10);

        return view('admin.products.index', compact('products', 'categories'));
    }

    // Show detail produk
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    // Halaman tambah produk
    public function create()
    {
        $categories = Product::distinct()->pluck('category'); // ambil kategori unik
        return view('admin.products.create', compact('categories'));
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'is_available' => 'nullable|boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Bersihkan nama file dari karakter special dan spasi
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $cleanName = Str::slug($originalName); // Ubah ke format slug (lowercase, tanpa spasi)
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '_' . $cleanName . '.' . $extension;
            
            $imagePath = $image->storeAs('products', $imageName, 'public');
            $validated['image_url'] = $imagePath;
        }

        // Convert features string to array
        if (isset($validated['features'])) {
            $validated['features'] = array_map('trim', explode(',', $validated['features']));
        }

        // Set is_available
        $validated['is_available'] = $request->has('is_available') ? true : false;

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    // Halaman edit produk
    public function edit(Product $product)
    {
        $categories = Product::distinct()->pluck('category')->toArray(); // ambil kategori unik
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Update produk
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'is_available' => 'nullable|boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
                Storage::disk('public')->delete($product->image_url);
            }

            $image = $request->file('image');
            
            // Bersihkan nama file dari karakter special dan spasi
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $cleanName = Str::slug($originalName); // Ubah ke format slug (lowercase, tanpa spasi)
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '_' . $cleanName . '.' . $extension;
            
            $imagePath = $image->storeAs('products', $imageName, 'public');
            chmod(storage_path('app/public/' . $imagePath), 0644);
            $validated['image_url'] = $imagePath;
        }

        // Convert features string to array
        if (isset($validated['features'])) {
            $validated['features'] = array_map('trim', explode(',', $validated['features']));
        }

        // Set is_available
        $validated['is_available'] = $request->has('is_available') ? true : false;

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui');
    }

    // Toggle status aktif / nonaktif
    public function toggleAvailability(Product $product)
    {
        $product->is_available = !$product->is_available;
        $product->save();
        return redirect()->route('admin.products.index')->with('success', 'Status produk berhasil diubah');
    }

    // Bulk update stock
    public function bulkUpdateStock(Request $request)
    {
        $productIds = $request->input('product_ids');
        $newStock = $request->input('new_stock');
        Product::whereIn('id', $productIds)->update(['stock' => $newStock]);
        return redirect()->route('admin.products.index')->with('success', 'Stok berhasil diupdate');
    }

    // Hapus produk
    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
    }
}