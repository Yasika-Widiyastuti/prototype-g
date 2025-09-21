<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('status');
            $table->foreignId('verified_by')->nullable()->constrained('users')->after('notes');
            $table->timestamp('verified_at')->nullable()->after('verified_by');
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['notes', 'verified_by', 'verified_at']);
        });
    }
};