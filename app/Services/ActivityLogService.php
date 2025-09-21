<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityLogService
{
    public function log($action, $description, $relatedModel = null, $relatedId = null)
    {
        try {
            DB::table('activity_logs')->insert([
                'admin_id' => Auth::id(),
                'action' => $action,
                'description' => $description,
                'related_model' => $relatedModel,
                'related_id' => $relatedId,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            \Log::error("Failed to log activity: " . $e->getMessage());
        }
    }

    public function logOrderStatusChange($order, $oldStatus, $newStatus)
    {
        $this->log(
            'order_status_update',
            "Changed order {$order->order_number} status from {$oldStatus} to {$newStatus} for user {$order->user->name}",
            'Order',
            $order->id
        );
    }

    public function logPaymentVerification($payment, $status)
    {
        $this->log(
            'payment_verification',
            "Set payment verification status to {$status} for user {$payment->user->name}",
            'Payment',
            $payment->id
        );
    }

    public function logUserStatusChange($user, $isActive)
    {
        $status = $isActive ? 'activated' : 'deactivated';
        $this->log(
            'user_status_update',
            "User {$user->name} ({$user->email}) has been {$status}",
            'User',
            $user->id
        );
    }
}