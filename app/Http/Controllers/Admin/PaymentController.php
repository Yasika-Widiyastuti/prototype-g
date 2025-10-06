<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use App\Services\NotificationService;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $query = Payment::with('user');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('bank', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('name', 'like', '%' . $request->search . '%')
                               ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $payments = $query->latest()->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load('user');
        
        $relatedOrders = Order::where('user_id', $payment->user_id)
            ->where('status', 'pending')
            ->with('orderItems.product')
            ->latest()
            ->get();

        return view('admin.payments.show', compact('payment', 'relatedOrders'));
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:waiting,success,failed',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $oldStatus = $payment->status;

        // Update payment
        $payment->update([
            'status' => $request->status,
            'notes' => $request->admin_notes,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        // ✅ UPDATE ORDER OTOMATIS (tidak perlu pilih manual)
        if ($request->status === 'success' && $payment->order) {
            $payment->order->update([
                'status' => 'confirmed', // atau 'paid', sesuai kebutuhan
                'payment_verified_at' => now(),
            ]);

            // Activity log & notifikasi
            $this->activityLogService->logOrderStatusChange($payment->order, 'waiting_verification', 'confirmed');
            $this->notificationService->notifyOrderStatusChange($payment->order, 'waiting_verification', 'confirmed');
        }

        // Activity log & notifikasi payment
        $this->activityLogService->logPaymentVerification($payment, $request->status);
        $this->notificationService->notifyPaymentStatusChange(
            $payment,
            $oldStatus,
            $request->status,
            $payment->order
        );

        $message = $request->status === 'success' ? 'Pembayaran berhasil disetujui' : 'Pembayaran ditolak';
        return redirect()->route('admin.payments.index')->with('success', $message);
    }
}