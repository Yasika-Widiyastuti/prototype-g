<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'bank',
        'bukti_transfer',
        'status',
        'verified_at',
        'verified_by',
        'notes',
        'rejection_reason'
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // 🔥 KUNCI: Auto-update status order ketika payment status berubah
    protected static function boot()
    {
        parent::boot();

        // Event ketika payment di-update
        static::updated(function ($payment) {
            if ($payment->isDirty('status') && $payment->order) {
                // Mapping status payment ke status order
                $orderStatus = match($payment->status) {
                    'waiting' => 'waiting_verification',
                    'success', 'approved' => 'confirmed',
                    'failed', 'rejected' => 'cancelled',
                    default => 'pending'
                };

                // Update status order
                $payment->order->update([
                    'status' => $orderStatus,
                    'payment_verified_at' => $payment->status === 'success' ? now() : null
                ]);
            }
        });
    }

    // Helper methods
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'waiting' => 'Menunggu Verifikasi',
            'success', 'approved' => 'Pembayaran Diterima',
            'failed', 'rejected' => 'Pembayaran Ditolak',
            default => 'Pending'
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'waiting' => 'bg-yellow-100 text-yellow-800',
            'success', 'approved' => 'bg-green-100 text-green-800',
            'failed', 'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}