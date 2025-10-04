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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            
            // Jenis event: login, logout, password_reset, profile_update, payment, booking, dll
            $table->string('event_type', 50);
            
            // Deskripsi event lebih detail
            $table->text('description')->nullable();
            
            // Info tambahan untuk keamanan & audit
            $table->string('ip_address', 45)->nullable(); // IPv4 & IPv6
            $table->text('user_agent')->nullable();
            
            // Metadata fleksibel untuk menampung data spesifik, misal token email reset
            $table->json('metadata')->nullable();

            $table->timestamps();

            // Index untuk performa query
            $table->index('user_id');
            $table->index('event_type');
            $table->index('created_at');
            $table->index(['user_id', 'event_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
