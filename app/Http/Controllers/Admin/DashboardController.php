<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'customer')->count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'pending_payments' => Payment::where('status', 'waiting')->count(),
            'monthly_revenue' => Order::where('status', 'completed')
                ->whereMonth('created_at', Carbon::now()->month)
                ->sum('total_amount'),
            'today_orders' => Order::whereDate('created_at', Carbon::today())->count(),
            'new_users_today' => User::where('role', 'customer')
                ->whereDate('created_at', Carbon::today())
                ->count(),
            'active_users' => User::where('role', 'customer')
                ->where('is_active', true)
                ->count(),
        ];

        // Recent orders dengan user
        $recent_orders = Order::with(['user', 'orderItems.product'])
            ->latest()
            ->limit(5)
            ->get();

        // Low stock products
        $low_stock_products = Product::where('stock', '<=', 2)
            ->where('is_available', true)
            ->get();

        // Recent users
        $recent_users = User::where('role', 'customer')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->latest()
            ->limit(5)
            ->get();

        // Pending payments
        $pending_payments = Payment::where('status', 'waiting')
            ->with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 
            'recent_orders', 
            'low_stock_products', 
            'recent_users',
            'pending_payments'
        ));
    }
}