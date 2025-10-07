<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'phone', 
        'address',
        'birth_date',
        'gender',
        'role', 
        'is_active',
        'ktp_path',
        'kk_path',
        'verification_status',
        'verified_at',
        'verification_notes',
        'verified_by', // FIXED: Sesuaikan dengan migration
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'verified_at' => 'datetime',
        'birth_date' => 'date',
    ];

    // Relationships
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function verifier()
    {
        // FIXED: Gunakan verifier_id yang sesuai dengan migration
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Helper Methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    public function isVerified()
    {
        return $this->verification_status === 'approved';
    }

    public function isPending()
    {
        return $this->verification_status === 'pending';
    }

    public function sssscted()
    {
        return $this->verification_status === 'rejected';
    }

    public function canCheckout()
    {
        return $this->is_active && $this->isVerified();
    }

    public function hasActiveOrders()
    {
        return $this->orders()->whereIn('status', ['pending', 'paid', 'confirmed'])->exists();
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        return $this->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
    }

    public function getStatusTextAttribute()
    {
        return $this->is_active ? 'Aktif' : 'Nonaktif';
    }

    public function getVerificationBadgeAttribute()
    {
        return match($this->verification_status) {
            'approved' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getVerificationTextAttribute()
    {
        return match($this->verification_status) {
            'approved' => 'Terverifikasi',
            'pending' => 'Menunggu Verifikasi',
            'rejected' => 'Ditolak',
            default => 'Belum Verifikasi',
        };
    }

    public function getTotalSpentAttribute()
    {
        return $this->orders()->where('status', 'completed')->sum('total_amount');
    }

    public function getFormattedTotalSpentAttribute()
    {
        return 'Rp ' . number_format($this->total_spent, 0, ',', '.');
    }

    public function getKtpUrlAttribute()
    {
        return $this->ktp_path ? Storage::url($this->ktp_path) : null;
    }

    public function getKkUrlAttribute()
    {
        return $this->kk_path ? Storage::url($this->kk_path) : null;
    }

    public function hasUploadedDocuments()
    {
        return !empty($this->ktp_path) && !empty($this->kk_path);
    }
}