<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            // Kolom WAJIB untuk membuat keranjang permanen: 
            // Mengaitkan item keranjang dengan pengguna yang sedang login.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Kolom untuk item yang disewa
            $table->unsignedBigInteger('product_id'); 
            $table->integer('quantity')->default(1);

            // Kolom untuk Durasi Sewa
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('duration')->default(1); 

            $table->timestamps();

            // Index untuk mempercepat pencarian.
            $table->index(['user_id', 'product_id']);

            // Batasan (Constraint): Mencegah satu user memiliki produk yang sama dua kali di keranjang.
            $table->unique(['user_id', 'product_id']);

            // Foreign key ke tabel products (asumsi Anda memiliki tabel 'products')
            // Jika tabel produk Anda memiliki nama yang berbeda (misal: 'items'), sesuaikan 'products' di bawah ini.
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};