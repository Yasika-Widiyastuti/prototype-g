<?php
namespace App\Http\Controllers\Admin;
use App\Models\OrderItem;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $stats = [
            'total_users'      => User::where('role', 'customer')->count(),
            'total_products'   => Product::count(),
            'total_orders'     => Order::whereMonth('created_at', Carbon::now()->month)
                                        ->whereYear('created_at', Carbon::now()->year)
                                        ->count(), // Total pesanan bulan ini
            'pending_orders'   => Order::where('status', 'pending')->count(),
            'monthly_revenue'  => Order::where('status', 'completed')
                                        ->whereMonth('created_at', Carbon::now()->month)
                                        ->whereYear('created_at', Carbon::now()->year)
                                        ->sum('total_amount'),
            'today_orders'     => Order::whereDate('created_at', Carbon::today())->count(),
            'new_customers_today' => User::where('role', 'customer')
                                         ->whereDate('created_at', Carbon::today())
                                         ->count(),
        ];

        // Pesanan terbaru dengan user & produk
        $recent_orders = Order::with(['user', 'orderItems.product'])
            ->latest()
            ->limit(5)
            ->get();

        // Ringkasan stok
        $stock_summary = [
            'available'    => Product::where('stock', '>', 0)->count(),  // semua yang tersedia (termasuk low stock)
            'low_stock'    => Product::where('stock', '>', 0)
                                     ->where('stock', '<=', 5)
                                     ->count(), 
            'out_of_stock' => Product::where('stock', 0)->count(),
        ];

        // Produk dengan stok menipis (untuk ditampilkan di alert box)
        $low_stock_products = Product::where('stock', '>', 0)
            ->where('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->limit(6) // Tampilkan maksimal 6 produk
            ->get();

        // Top 5 produk paling banyak disewa (bulan ini)
        $top_rented_products = OrderItem::select('product_id', DB::raw('SUM(quantity) as rental_count'))
             ->with('product')
             ->whereHas('order', function ($q) {
                 $q->whereMonth('created_at', Carbon::now()->month)
                   ->whereYear('created_at', Carbon::now()->year)
                  ->whereIn('status', ['confirmed', 'completed']);
             })
             ->groupBy('product_id')
             ->orderBy('rental_count', 'desc')
             ->limit(5)
             ->get();

        return view('admin.dashboard', compact(
            'stats', 
            'recent_orders', 
            'stock_summary',
            'low_stock_products',
            'top_rented_products'
        ));
    }
}