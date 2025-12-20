<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OwnerDashboardController extends Controller
{
    public function index(Request $request)
    {
        // DATE RANGE PARAMETERS
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        
        // Parse dates
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        // Calculate period info
        $periodDays = $start->diffInDays($end) + 1;
        $periodLabel = $this->getPeriodLabel($start, $end);
        
        // 1. TOTAL OMZET
        $totalRevenue = DB::connection('warehouse')
            ->table('fact_order_items as f')
            ->join('dim_time as t', 'f.time_key', '=', 't.time_key')
            ->whereBetween('t.full_date', [$startDate, $endDate])
            ->sum('f.subtotal') ?? 0;

        // 2. TOTAL ORDER PAID
        $completedOrders = DB::connection('warehouse')
            ->table('fact_orders as fo')
            ->join('dim_time as t', 'fo.time_key', '=', 't.time_key')
            ->where('fo.status', 'paid')
            ->whereBetween('t.full_date', [$startDate, $endDate])
            ->count();

        // 3. TOTAL CUSTOMER (all time)
        $activeCustomers = DB::connection('warehouse')
            ->table('dim_users')
            ->count();

        // 4. RATA-RATA KEPUASAN PELANGGAN
        $avgRating = DB::connection('warehouse')
            ->table('fact_reviews')
            ->avg('rating') ?? 0;

        // 5. TOP 5 PRODUK TERLARIS
        $topProducts = DB::connection('warehouse')
            ->table('fact_order_items as f')
            ->join('dim_products as p', 'f.product_key', '=', 'p.product_key')
            ->join('dim_time as t', 'f.time_key', '=', 't.time_key')
            ->select(
                'p.name',
                DB::raw('SUM(f.quantity) as total_qty'),
                DB::raw('SUM(f.subtotal) as total_money')
            )
            ->whereBetween('t.full_date', [$startDate, $endDate])
            ->groupBy('p.product_key', 'p.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // 6. TREN PENDAPATAN (Auto-detect granularity)
        $revenueTrend = $this->getRevenueTrend($startDate, $endDate);

        // 7. STATISTIK METODE PEMBAYARAN
        $paymentStats = DB::connection('warehouse')
            ->table('fact_payments as fp')
            ->join('dim_payment_method as dpm', 'fp.payment_method_key', '=', 'dpm.payment_method_key')
            ->join('dim_time as t', 'fp.time_key', '=', 't.time_key')
            ->select(
                'dpm.provider_name',
                DB::raw('COUNT(*) as total_transaksi'),
                DB::raw('SUM(fp.payment_amount) as total_uang')
            )
            ->whereBetween('t.full_date', [$startDate, $endDate])
            ->groupBy('dpm.payment_method_key', 'dpm.provider_name')
            ->orderByDesc('total_transaksi')
            ->get();

        // 8. STATISTIK STATUS ORDER
        $orderStatusStats = DB::connection('warehouse')
            ->table('fact_orders as fo')
            ->join('dim_time as t', 'fo.time_key', '=', 't.time_key')
            ->select(
                'fo.status',
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('t.full_date', [$startDate, $endDate])
            ->groupBy('fo.status')
            ->get();

        // 9. PERFORMA KATEGORI PRODUK
        $categoryStats = DB::connection('warehouse')
            ->table('fact_order_items as f')
            ->join('dim_products as p', 'f.product_key', '=', 'p.product_key')
            ->join('dim_time as t', 'f.time_key', '=', 't.time_key')
            ->select(
                'p.category',
                DB::raw('SUM(f.quantity) as total_qty'),
                DB::raw('SUM(f.subtotal) as total_revenue')
            )
            ->whereBetween('t.full_date', [$startDate, $endDate])
            ->groupBy('p.category')
            ->orderByDesc('total_revenue')
            ->get();

        // 10. TOP 5 CUSTOMER
        $topCustomers = DB::connection('warehouse')
            ->table('fact_orders as fo')
            ->join('dim_users as u', 'fo.user_key', '=', 'u.user_key')
            ->join('fact_order_items as foi', 'fo.order_key', '=', 'foi.order_key')
            ->join('dim_time as t', 'fo.time_key', '=', 't.time_key')
            ->select(
                'u.name',
                'u.email',
                DB::raw('COUNT(DISTINCT fo.order_key) as total_orders'),
                DB::raw('SUM(foi.subtotal) as total_spent')
            )
            ->whereBetween('t.full_date', [$startDate, $endDate])
            ->groupBy('u.user_key', 'u.name', 'u.email')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();

        // Kirim data ke View
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
            'topCustomers',
            'startDate',
            'endDate',
            'periodDays',
            'periodLabel'
        ));
    }

    // HELPER: Get Revenue Trend (Auto Granularity)
    private function getRevenueTrend($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $days = $start->diffInDays($end) + 1;

        $query = DB::connection('warehouse')
            ->table('fact_order_items as f')
            ->join('dim_time as t', 'f.time_key', '=', 't.time_key')
            ->whereBetween('t.full_date', [$startDate, $endDate]);

        // Auto-detect granularity based on date range
        if ($days <= 31) {
            // Daily (up to 1 month)
            return $query->select(
                    't.full_date',
                    't.day',
                    't.month',
                    't.year',
                    DB::raw('CASE DAYOFWEEK(t.full_date)
                        WHEN 1 THEN "Minggu"
                        WHEN 2 THEN "Senin"
                        WHEN 3 THEN "Selasa"
                        WHEN 4 THEN "Rabu"
                        WHEN 5 THEN "Kamis"
                        WHEN 6 THEN "Jumat"
                        WHEN 7 THEN "Sabtu"
                    END as day_name'),
                    DB::raw('SUM(f.subtotal) as total')
                )
                ->groupBy('t.full_date', 't.day', 't.month', 't.year')
                ->orderBy('t.full_date')
                ->get();
        } elseif ($days <= 90) {
            // Weekly
            return $query->select(
                    DB::raw('WEEK(t.full_date) as week'),
                    DB::raw('YEAR(t.full_date) as year'),
                    DB::raw('MIN(t.full_date) as start_date'),
                    DB::raw('MAX(t.full_date) as end_date'),
                    DB::raw('SUM(f.subtotal) as total')
                )
                ->groupBy(DB::raw('YEAR(t.full_date), WEEK(t.full_date)'))
                ->orderBy('year')
                ->orderBy('week')
                ->get();
        } elseif ($days <= 365) {
            // Monthly
            return $query->select(
                    't.month',
                    't.year',
                    DB::raw('SUM(f.subtotal) as total')
                )
                ->groupBy('t.year', 't.month')
                ->orderBy('t.year')
                ->orderBy('t.month')
                ->get();
        } else {
            // Yearly
            return $query->select(
                    't.year',
                    DB::raw('SUM(f.subtotal) as total')
                )
                ->groupBy('t.year')
                ->orderBy('t.year')
                ->get();
        }
    }

    // HELPER: Generate Period Label
    private function getPeriodLabel($start, $end)
    {
        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        // Same month and year
        if ($start->format('Y-m') === $end->format('Y-m')) {
            return $monthNames[$start->month] . ' ' . $start->year;
        }

        // Same year
        if ($start->year === $end->year) {
            return $monthNames[$start->month] . ' - ' . $monthNames[$end->month] . ' ' . $start->year;
        }

        // Different years
        return $start->format('d M Y') . ' - ' . $end->format('d M Y');
    }
}