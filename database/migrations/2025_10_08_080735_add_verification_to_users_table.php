<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Dokumen identitas
            $table->string('ktp_path')->nullable()->after('address');
            $table->string('kk_path')->nullable()->after('ktp_path');
            
            // Status verifikasi
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])
                  ->default('pending')
                  ->after('kk_path');
            
            $table->timestamp('verified_at')->nullable()->after('verification_status');
            $table->text('verification_notes')->nullable()->after('verified_at');
            $table->unsignedBigInteger('verified_by')->nullable()->after('verification_notes');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'ktp_path',
                'kk_path',
                'verification_status',
                'verified_at',
                'verification_notes',
                'verified_by'
            ]);
        });
    }
};