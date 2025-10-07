<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use App\Services\NotificationService;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $notificationService;
    protected $activityLogService;

    public function __construct(NotificationService $notificationService, ActivityLogService $activityLogService)
    {
        $this->notificationService = $notificationService;
        $this->activityLogService = $activityLogService;
    }

    public function index(Request $request)
    {
        $query = Payment::with(['user', 'order']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('bank', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('name', 'like', '%' . $request->search . '%')
                               ->orWhere('email', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('order', function($orderQuery) use ($request) {
                      $orderQuery->where('order_number', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $payments = $query->latest()->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        // Load relasi
        $payment->load(['user', 'order.orderItems.product', 'verifier']);
        
        // Ambil order yang terkait dengan payment ini
        $relatedOrders = [];
        if ($payment->order_id) {
            $relatedOrders = Order::where('id', $payment->order_id)
                ->with('orderItems.product')
                ->get();
        } else {
            // Fallback: cari order pending dari user yang sama
            $relatedOrders = Order::where('user_id', $payment->user_id)
                ->whereIn('status', ['pending', 'waiting_verification'])
                ->with('orderItems.product')
                ->latest()
                ->get();
        }

        return view('admin.payments.show', compact('payment', 'relatedOrders'));
    }

    /**
     * ✅ UPDATE STATUS PAYMENT (Auto-update Order via Model Event)
     */
    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:waiting,success,failed',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $oldStatus = $payment->status;

        DB::beginTransaction();
        try {
            // Update payment
            $updateData = [
                'status' => $request->status,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ];

            // Jika ada notes admin
            if ($request->filled('admin_notes')) {
                $updateData['notes'] = $request->admin_notes;
                
                // Jika status failed, simpan juga di rejection_reason
                if ($request->status === 'failed') {
                    $updateData['rejection_reason'] = $request->admin_notes;
                }
            }

            $payment->update($updateData);

            // 🔥 Order akan otomatis terupdate melalui Payment::boot() event
            // Tapi kita pastikan order ada dan log aktifitasnya
            if ($payment->order) {
                $newOrderStatus = match($request->status) {
                    'success' => 'confirmed',
                    'failed' => 'cancelled',
                    default => $payment->order->status
                };

                // Activity log untuk order
                if ($payment->order->status !== $newOrderStatus) {
                    $this->activityLogService->logOrderStatusChange(
                        $payment->order, 
                        $payment->order->status, 
                        $newOrderStatus
                    );
                }

                // Notifikasi order
                $this->notificationService->notifyOrderStatusChange(
                    $payment->order,
                    $payment->order->status,
                    $newOrderStatus
                );
            }

            // Activity log untuk payment
            $this->activityLogService->logPaymentVerification($payment, $request->status);

            // Notifikasi payment ke user
            $this->notificationService->notifyPaymentStatusChange(
                $payment,
                $oldStatus,
                $request->status,
                $payment->order
            );

            DB::commit();

            $message = match($request->status) {
                'success' => 'Pembayaran berhasil disetujui dan order telah dikonfirmasi',
                'failed' => 'Pembayaran ditolak dan order telah dibatalkan',
                default => 'Status pembayaran berhasil diupdate'
            };

            return redirect()->route('admin.payments.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * ✅ APPROVE Payment (shortcut method)
     */
    public function approve(Payment $payment)
    {
        DB::beginTransaction();
        try {
            $oldStatus = $payment->status;

            $payment->update([
                'status' => 'success',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            // Order otomatis terupdate via model event
            if ($payment->order) {
                $this->activityLogService->logOrderStatusChange(
                    $payment->order,
                    $payment->order->status,
                    'confirmed'
                );

                $this->notificationService->notifyOrderStatusChange(
                    $payment->order,
                    $payment->order->status,
                    'confirmed'
                );
            }

            $this->activityLogService->logPaymentVerification($payment, 'success');
            $this->notificationService->notifyPaymentStatusChange(
                $payment,
                $oldStatus,
                'success',
                $payment->order
            );

            DB::commit();

            return redirect()->route('admin.payments.index')
                ->with('success', 'Pembayaran berhasil disetujui!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment approval error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * ✅ REJECT Payment (dengan alasan)
     */
    public function reject(Request $request, Payment $payment)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            $oldStatus = $payment->status;

            $payment->update([
                'status' => 'failed',
                'rejection_reason' => $request->rejection_reason,
                'notes' => $request->rejection_reason,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            // Order otomatis terupdate via model event
            if ($payment->order) {
                $this->activityLogService->logOrderStatusChange(
                    $payment->order,
                    $payment->order->status,
                    'cancelled'
                );

                $this->notificationService->notifyOrderStatusChange(
                    $payment->order,
                    $payment->order->status,
                    'cancelled'
                );
            }

            $this->activityLogService->logPaymentVerification($payment, 'failed');
            $this->notificationService->notifyPaymentStatusChange(
                $payment,
                $oldStatus,
                'failed',
                $payment->order
            );

            DB::commit();

            return redirect()->route('admin.payments.index')
                ->with('success', 'Pembayaran ditolak dan customer telah diberitahu.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment rejection error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}