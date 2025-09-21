<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Tambahkan ini

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('products', 'stock')) {
                $table->integer('stock')->default(0);
            }
            if (!Schema::hasColumn('products', 'is_available')) {
                $table->boolean('is_available')->default(true);
            }
            if (!Schema::hasColumn('products', 'features')) {
                $table->json('features')->nullable();
            }
            if (!Schema::hasColumn('products', 'image_url')) {
                $table->string('image_url')->nullable();
            }
        });
        
        // Update existing image column if it exists (diluar Schema::table)
        if (Schema::hasColumn('products', 'image')) {
            DB::statement('UPDATE products SET image_url = image WHERE image_url IS NULL');
        }
    }
    
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['stock', 'is_available', 'features', 'image_url']);
        });
    }
};