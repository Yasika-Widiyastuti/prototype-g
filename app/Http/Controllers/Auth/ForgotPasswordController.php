<?php
// =============================================================================
// ForgotPasswordController.php - Clean & Secure Version
// =============================================================================

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Handle sending reset password token (secure, rate-limited, audit)
     */

    public function showLinkRequestForm()
    {
        // Tampilkan form untuk user memasukkan email
        return view('auth.passwords.email'); 
        // Pastikan file view ini ada: resources/views/auth/passwords/email.blade.php
    }


    public function sendResetLinkEmail(Request $request)
    {
        // Validasi email
        $request->validate(['email' => 'required|email']);

        $email = $request->email;
        $ip = $request->ip();

        // Rate limiting per IP + email
        $key = 'forgot-password:' . $ip . ':' . $email;
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => 'Terlalu banyak percobaan. Coba lagi dalam ' . ceil($seconds / 60) . ' menit.'
            ]);
        }

        // Cek apakah user ada
        $user = User::where('email', $email)->first();

        // Jika user tidak ada, tetap hit rate limiter tapi jangan beri tahu
        if (!$user) {
            RateLimiter::hit($key, 60 * 15);
            return back()->with('status', 'Jika email terdaftar, Anda dapat melanjutkan proses reset password.');
        }

        // Hapus token lama untuk email ini
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // Generate token dan hash untuk database
        $token = Str::random(64);
        $tokenHash = Hash::make($token);

        // Simpan token di database
        // Pastikan kolom ip_address dan user_agent ada di tabel jika ingin menyimpan audit
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $tokenHash,
            'created_at' => Carbon::now(),
            'ip_address' => $ip,             // Hanya jika kolom ada
            'user_agent' => $request->userAgent() // Hanya jika kolom ada
        ]);

        // Simpan token plaintext di session (tidak di URL)
        session([
            'reset_token_plain' => $token,
            'reset_email' => $email,
            'reset_expires' => Carbon::now()->addMinutes(15)->timestamp
        ]);

        // Hit rate limiter
        RateLimiter::hit($key, 60 * 15);

        // Log aktivitas untuk audit
        Log::info('Password reset token created', [
            'email' => $email,
            'ip' => $ip,
            'user_agent' => $request->userAgent()
        ]);

        // Redirect ke form reset password
        return redirect()->route('password.reset-session-form')
            ->with('status', 'Token reset password telah dibuat. Silakan lanjutkan untuk mengubah password.');
    }
}
