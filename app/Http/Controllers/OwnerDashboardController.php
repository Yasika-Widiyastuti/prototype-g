<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        // ==========================================
        // 1. TOTAL OMZET (Revenue)
        // ==========================================
        $totalRevenue = DB::connection('warehouse')
            ->table('fact_order_items')
            ->sum('subtotal') ?? 0;

        // ==========================================
        // 2. TOTAL ORDER PAID (bukan completed)
        // ==========================================
        $completedOrders = DB::connection('warehouse')
            ->table('fact_orders')
            ->where('status', 'paid')
            ->count();

        // ==========================================
        // 3. TOTAL CUSTOMER (semua customer)
        // ==========================================
        $activeCustomers = DB::connection('warehouse')
            ->table('dim_users')
            ->count();

        // ==========================================
        // 4. RATA-RATA KEPUASAN PELANGGAN
        // ==========================================
        $avgRating = DB::connection('warehouse')
            ->table('fact_reviews')
            ->avg('rating') ?? 0;

        // ==========================================
        // 5. TOP 5 PRODUK TERLARIS
        // ==========================================
        $topProducts = DB::connection('warehouse')
            ->table('fact_order_items as f')
            ->join('dim_products as p', 'f.product_key', '=', 'p.product_key')
            ->select(
                'p.name', 
                DB::raw('SUM(f.quantity) as total_qty'),
                DB::raw('SUM(f.subtotal) as total_money')
            )
            ->groupBy('p.product_key', 'p.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // ==========================================
        // 6. TREN PENDAPATAN BULANAN (12 Bulan Terakhir)
        // ==========================================
        $revenueTrend = DB::connection('warehouse')
            ->table('fact_order_items as f')
            ->join('dim_time as t', 'f.time_key', '=', 't.time_key')
            ->select(
                't.month',
                't.year',
                DB::raw('SUM(f.subtotal) as total')
            )
            ->where('t.year', '>=', date('Y') - 1)
            ->groupBy('t.year', 't.month')
            ->orderBy('t.year')
            ->orderBy('t.month')
            ->get();

        // ==========================================
        // 7. STATISTIK METODE PEMBAYARAN
        // PENTING: HAPUS FILTER payment_status!
        // ==========================================
        $paymentStats = DB::connection('warehouse')
            ->table('fact_payments as fp')
            ->join('dim_payment_method as dpm', 'fp.payment_method_key', '=', 'dpm.payment_method_key')
            ->select(
                'dpm.provider_name',
                DB::raw('COUNT(*) as total_transaksi'),
                DB::raw('SUM(fp.payment_amount) as total_uang')
            )
            // HAPUS filter payment_status karena tidak ada yang 'paid' atau 'completed'
            ->groupBy('dpm.payment_method_key', 'dpm.provider_name')
            ->orderByDesc('total_transaksi')
            ->get();

        // ==========================================
        // 8. STATISTIK STATUS ORDER
        // ==========================================
        $orderStatusStats = DB::connection('warehouse')
            ->table('fact_orders')
            ->select(
                'status',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('status')
            ->get();

        // ==========================================
        // 9. PERFORMA KATEGORI PRODUK
        // ==========================================
        $categoryStats = DB::connection('warehouse')
            ->table('fact_order_items as f')
            ->join('dim_products as p', 'f.product_key', '=', 'p.product_key')
            ->select(
                'p.category',
                DB::raw('SUM(f.quantity) as total_qty'),
                DB::raw('SUM(f.subtotal) as total_revenue')
            )
            ->groupBy('p.category')
            ->orderByDesc('total_revenue')
            ->get();

        // ==========================================
        // 10. TOP 5 CUSTOMER
        // JOIN dengan fact_order_items untuk dapat total_spent
        // ==========================================
        $topCustomers = DB::connection('warehouse')
            ->table('fact_orders as fo')
            ->join('dim_users as u', 'fo.user_key', '=', 'u.user_key')
            ->join('fact_order_items as foi', 'fo.order_key', '=', 'foi.order_key')
            ->select(
                'u.name',
                'u.email',
                DB::raw('COUNT(DISTINCT fo.order_key) as total_orders'),
                DB::raw('SUM(foi.subtotal) as total_spent')
            )
            ->groupBy('u.user_key', 'u.name', 'u.email')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();

        // Kirim semua data ke View
        return view('owner.dashboard', compact(
            'totalRevenue',
            'completedOrders',
            'activeCustomers',
            'avgRating',
            'topProducts',
            'revenueTrend',
            'paymentStats',
            'orderStatusStats',
            'categoryStats',
            'topCustomers'
        ));
    }
}