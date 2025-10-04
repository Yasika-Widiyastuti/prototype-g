
<?php
// =============================================================================
// 1. MIGRATION - create_password_reset_tokens_table.php
// =============================================================================
// Run: php artisan make:migration create_password_reset_tokens_table

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('password_reset_tokens')) {
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token_hash');
                $table->timestamp('created_at')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();

                $table->index(['email', 'created_at']);
            });
        }
    }


    public function down()
    {
        Schema::dropIfExists('password_reset_tokens');
    }
};