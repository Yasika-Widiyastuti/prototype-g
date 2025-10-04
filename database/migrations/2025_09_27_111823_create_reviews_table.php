<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('product_id'); // relasi ke produk
        $table->string('user_name'); // kalau belum ada sistem login
        $table->tinyInteger('rating'); // 1 - 5
        $table->text('comment');
        $table->timestamps();

        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    });
}


    public function down(): void {
        Schema::dropIfExists('reviews');
    }
};