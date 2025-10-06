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
        $orders = Order::with(['user', 'orderItems.product'])
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    // Menampilkan detail pesanan
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }

    // Memperbarui status pesanan (pending, paid, completed, canceled)
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,completed,canceled',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diperbarui');
    }

    // Memverifikasi pembayaran pesanan
    public function verifyPayment(Order $order)
    {
        if ($order->payment_verified) {
            return redirect()->route('admin.orders.index')->with('error', 'Pembayaran sudah diverifikasi');
        }

        $order->update([
            'payment_verified' => true,
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Pembayaran pesanan berhasil diverifikasi');
    }

    // Konfirmasi barang sudah diambil customer (ubah ke 'rented')
    public function confirmPickup(Order $order)
    {
        if ($order->status !== 'confirmed') {
            return redirect()->back()->with('error', 'Status order tidak valid untuk pickup.');
        }

        $order->update([
            'status' => 'rented',
            'pickup_date' => now(),
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Barang sudah diambil customer. Status diubah ke "Sedang Disewa".');
    }

    // Konfirmasi barang sudah dikembalikan (ubah ke 'completed')
    public function confirmReturn(Request $request, Order $order)
    {
        if ($order->status !== 'rented') {
            return redirect()->back()->with('error', 'Barang belum dalam status disewa.');
        }

        $request->validate([
            'admin_return_notes' => 'nullable|string|max:500',
        ]);

        // Kembalikan stok produk
        foreach ($order->orderItems as $item) {
            if ($item->product) {
                $item->product->increment('stock', $item->quantity);
            }
        }

        $order->update([
            'status' => 'completed',
            'return_date' => now(),
#            'admin_return_notes' => $request->admin_return_notes,
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Pengembalian barang dikonfirmasi. Transaksi selesai & stok dikembalikan.');
    }
}
