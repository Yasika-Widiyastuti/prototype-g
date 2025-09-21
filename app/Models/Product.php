<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'price',
        'image_url',
        'stock',
        'is_available',
        'features',
    ];

    protected $casts = [
        'features' => 'array',
        'is_available' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)->where('stock', '>', 0);
    }

    // Scope untuk produk dengan stok rendah (untuk dashboard admin)
    public function scopeLowStock($query, $threshold = 2)
    {
        return $query->where('stock', '<=', $threshold)->where('is_available', true);
    }

    // Scope untuk filter berdasarkan search
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
    }

    // Accessor untuk format harga
    public function getPriceFormattedAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Accessor untuk status stok
    public function getStockStatusAttribute()
    {
        if ($this->stock == 0) {
            return [
                'label' => 'Habis',
                'class' => 'bg-red-100 text-red-800'
            ];
        } elseif ($this->stock <= 2) {
            return [
                'label' => 'Stok Menipis',
                'class' => 'bg-red-100 text-red-800'
            ];
        } elseif ($this->stock <= 5) {
            return [
                'label' => 'Stok Terbatas',
                'class' => 'bg-yellow-100 text-yellow-800'
            ];
        } else {
            return [
                'label' => 'Stok Aman',
                'class' => 'bg-green-100 text-green-800'
            ];
        }
    }

    // Accessor untuk category badge
    public function getCategoryBadgeAttribute()
    {
        $badges = [
            'handphone' => 'bg-blue-100 text-blue-800',
            'lightstick' => 'bg-yellow-100 text-yellow-800',
            'powerbank' => 'bg-green-100 text-green-800',
        ];

        return $badges[$this->category] ?? 'bg-gray-100 text-gray-800';
    }

    // Method untuk cek apakah bisa disewa
    public function canBeRented($quantity = 1)
    {
        return $this->is_available && $this->stock >= $quantity;
    }

    // Method untuk mengurangi stok
    public function reduceStock($quantity = 1)
    {
        if ($this->stock >= $quantity) {
            $this->decrement('stock', $quantity);
            return true;
        }
        return false;
    }

    // Method untuk menambah stok
    public function increaseStock($quantity = 1)
    {
        $this->increment('stock', $quantity);
        return true;
    }

    // Method untuk mendapatkan total pesanan produk ini
    public function getTotalOrdersAttribute()
    {
        return $this->orderItems()->sum('quantity');
    }

    // Method untuk mendapatkan revenue dari produk ini
    public function getTotalRevenueAttribute()
    {
        return $this->orderItems()->sum('total');
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            $product->slug = static::generateUniqueSlug($product->name);
        });
        
        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = static::generateUniqueSlug($product->name, $product->id);
            }
        });
    }

    // Method untuk generate slug yang unik
    private static function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)
                    ->when($ignoreId, function ($query, $ignoreId) {
                        return $query->where('id', '!=', $ignoreId);
                    })
                    ->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    // Method untuk mendapatkan kategori yang tersedia
    public static function getAvailableCategories()
    {
        return [
            'handphone' => 'Handphone',
            'lightstick' => 'Lightstick',
            'powerbank' => 'Powerbank',
        ];
    }

    // Method untuk validasi image URL
    public function isValidImageUrl($url)
    {
        $headers = @get_headers($url);
        return $headers && strpos($headers[0], '200') !== false;
    }
}