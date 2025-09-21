<?php
namespace App\Services;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function notifyOrderStatusChange(Order $order, $oldStatus, $newStatus)
    {
        try {
            $user = $order->user;
            
            Log::info("Order {$order->order_number} status changed from {$oldStatus} to {$newStatus} for user {$user->email}");
            
            // Di sini bisa ditambahkan email notification
            // Mail::to($user->email)->send(new OrderStatusChanged($order, $oldStatus, $newStatus));
            
        } catch (\Exception $e) {
            Log::error("Failed to send order status notification: " . $e->getMessage());
        }
    }

    public function notifyPaymentStatusChange($payment, $oldStatus, $newStatus, $order = null)
    {
        try {
            $user = $payment->user;
            
            Log::info("Payment {$payment->id} status changed from {$oldStatus} to {$newStatus} for user {$user->email}");
            
            // Di sini bisa ditambahkan email notification
            
        } catch (\Exception $e) {
            Log::error("Failed to send payment status notification: " . $e->getMessage());
        }
    }

    public function notifyAccountStatusChange(User $user, $isActive)
    {
        try {
            $status = $isActive ? 'activated' : 'deactivated';
            Log::info("User {$user->email} account has been {$status}");
            
            // Di sini bisa ditambahkan email notification
            
        } catch (\Exception $e) {
            Log::error("Failed to send account status notification: " . $e->getMessage());
        }
    }
}