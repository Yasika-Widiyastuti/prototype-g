<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            // Tambah kolom order_id jika belum ada
            if (!Schema::hasColumn('payments', 'order_id')) {
                $table->unsignedBigInteger('order_id')->nullable()->after('user_id');
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            }

            // Tambah kolom untuk verifikasi admin
            if (!Schema::hasColumn('payments', 'verified_by')) {
                $table->unsignedBigInteger('verified_by')->nullable()->after('status');
                $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            }

            if (!Schema::hasColumn('payments', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }

            // Tambah kolom notes untuk catatan admin
            if (!Schema::hasColumn('payments', 'notes')) {
                $table->text('notes')->nullable()->after('verified_at');
            }

            // Tambah kolom rejection_reason (alasan penolakan)
            if (!Schema::hasColumn('payments', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('notes');
            }

            // Update enum status untuk menambahkan 'rejected'
            // Note: Untuk Laravel, kita tidak bisa langsung modify enum
            // Jadi kita drop dan recreate atau ubah ke string
            $table->string('status', 20)->change(); // Ubah dari enum ke string
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            // Drop foreign keys dulu
            $table->dropForeign(['order_id']);
            $table->dropForeign(['verified_by']);
            
            // Drop columns
            $table->dropColumn([
                'order_id',
                'verified_by',
                'verified_at',
                'notes',
                'rejection_reason'
            ]);
        });
    }
};