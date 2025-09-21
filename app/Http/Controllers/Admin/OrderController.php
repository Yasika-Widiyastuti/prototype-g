<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Menampilkan daftar pesanan dengan paginasi
    public function index()
    {
        // Mengambil pesanan dengan relasi User dan OrderItems(Product) dan menggunakan paginasi
        $orders = Order::with(['user', 'orderItems.product']) // Mengambil relasi dengan User dan Product
            ->latest()
            ->paginate(10); // Gunakan paginate untuk memecah data ke dalam beberapa halaman

        return view('admin.orders.index', compact('orders'));
    }

    // Menampilkan detail pesanan
    public function show(Order $order)
    {
        // Mengambil pesanan lengkap dengan relasi User dan OrderItems(Product)
        $order->load(['user', 'orderItems.product']);

        return view('admin.orders.show', compact('order'));
    }

    // Memperbarui status pesanan
    public function updateStatus(Request $request, Order $order)
    {
        // Validasi status yang diizinkan
        $request->validate([
            'status' => 'required|in:pending,paid,completed,canceled', // Validasi status yang diizinkan
        ]);

        // Memperbarui status pesanan
        $order->update([
            'status' => $request->status, // Mengubah status pesanan sesuai input
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diperbarui');
    }

    // Memverifikasi pembayaran pesanan
    public function verifyPayment(Order $order)
    {
        // Pastikan pesanan belum diverifikasi sebelumnya
        if ($order->payment_verified) {
            return redirect()->route('admin.orders.index')->with('error', 'Pembayaran sudah diverifikasi');
        }

        // Verifikasi pembayaran
        $order->update([
            'payment_verified' => true, // Tandai pembayaran sebagai terverifikasi
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Pembayaran pesanan berhasil diverifikasi');
    }
}
