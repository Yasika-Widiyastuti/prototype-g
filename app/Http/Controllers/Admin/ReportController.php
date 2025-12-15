<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class ReportController extends Controller
{
    // Laporan penjualan
    public function sales()
    {
        $sales = Order::where('status', 'completed')->sum('total_amount'); // Menghitung total pendapatan
        
        // Data penjualan per hari
        $salesData = Order::selectRaw('DAY(created_at) as day, SUM(total_amount) as total_sales')
            ->where('status', 'completed')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Format data untuk grafik
        $salesData = [
            'labels' => $salesData->pluck('day'),
            'data' => $salesData->pluck('total_sales')
        ];

        return view('admin.reports.sales', compact('sales', 'salesData')); // Pastikan view 'admin.reports.sales' ada
    }


    // Laporan produk
    public function products()
    {
        $products = Product::all(); // Mengambil semua produk
        return view('admin.reports.products', compact('products')); // Pastikan view 'admin.reports.products' ada
    }

    // Laporan pelanggan
    public function customers()
    {
        $customers = User::where('role', 'customer')->get(); // Mengambil semua pengguna dengan role 'customer'
        return view('admin.reports.customers', compact('customers')); // Pastikan view 'admin.reports.customers' ada
    }
}