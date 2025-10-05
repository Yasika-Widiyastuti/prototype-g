<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// MODEL YANG BENAR: Product
// Dikonfirmasi dari ProductController Anda.
use App\Models\Product; 

class Cart extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'start_date',
        'end_date',
        'duration',
    ];

    /**
     * Relasi ke Model Produk (Barang yang disewa)
     */
    public function product()
    {
        // Relasi sudah diperbaiki, menggunakan Product::class
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    /**
     * Relasi ke Model User (Pengguna yang memiliki keranjang)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}