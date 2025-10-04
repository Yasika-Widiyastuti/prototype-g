<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    /**
     * Show reset form menggunakan session instead of URL token
     */
    public function showResetForm(Request $request, $token = null)
    {
        // SECURITY: Prioritize session-based token over URL token
        $sessionToken = session('reset_token_plain');
        $sessionEmail = session('reset_email');
        $sessionExpires = session('reset_expires');
        
        // Jika ada session, gunakan itu (lebih aman)
        if ($sessionToken && $sessionEmail) {
            // Check expiry dari session
            if ($sessionExpires && Carbon::now()->timestamp > $sessionExpires) {
                session()->forget(['reset_token_plain', 'reset_email', 'reset_expires']);
                return redirect()->route('password.request')
                    ->withErrors(['token' => 'Token reset sudah kedaluwarsa. Silakan minta reset password baru.']);
            }

            return view('auth.passwords.reset', [
                'email' => $sessionEmail,
                'uses_session' => true
            ]);
        }
        
        // Fallback ke method lama jika tidak ada session (backward compatibility)
        if ($token) {
            return $this->showResetFormWithToken($token);
        }
        
        return redirect()->route('password.request')
            ->withErrors(['token' => 'Akses reset tidak valid. Silakan mulai proses reset password.']);
    }

    /**
     * Fallback method untuk URL-based token (backward compatibility)
     */
    private function showResetFormWithToken($token)
    {
        // Cari berdasarkan hash token
        $resetRecord = DB::table('password_reset_tokens')
                        ->where('email', function($query) use ($token) {
                            // Cari record yang hash-nya cocok dengan token
                            $records = DB::table('password_reset_tokens')->get();
                            foreach ($records as $record) {
                                if (Hash::check($token, $record->token)) {
                                    return $query->where('email', $record->email);
                                }
                            }
                        })
                        ->first();

        if (!$resetRecord) {
            return redirect()->route('password.request')
                           ->withErrors(['token' => 'Token reset tidak valid atau sudah kedaluwarsa.']);
        }

        // Cek expiry (15 menit untuk keamanan lebih ketat)
        if (Carbon::parse($resetRecord->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $resetRecord->email)->delete();
            return redirect()->route('password.request')
                           ->withErrors(['token' => 'Token reset sudah kedaluwarsa. Silakan minta reset password baru.']);
        }

        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $resetRecord->email,
            'uses_session' => false
        ]);
    }

    /**
     * Reset password dengan security improvements dan validasi password lama
     */
    public function reset(Request $request)
    {
        // SECURITY: Enhanced password validation
        $request->validate([
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(), // Cek jika password pernah bocor
            ],
        ], [
            'password.min' => 'Password minimal 8 karakter.',
            'password.mixed_case' => 'Password harus mengandung huruf besar dan kecil.',
            'password.numbers' => 'Password harus mengandung minimal 1 angka.',
            'password.symbols' => 'Password harus mengandung minimal 1 simbol (!@#$%^&*).',
            'password.uncompromised' => 'Password ini tidak aman karena pernah bocor dalam kebocoran data. Silakan gunakan password lain.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $email = $request->email;
        $sessionToken = session('reset_token_plain');
        $urlToken = $request->token;

        // SECURITY: Prioritas validasi dari session
        if ($sessionToken && session('reset_email') === $email) {
            $isValid = $this->validateSessionToken($email, $sessionToken);
        } elseif ($urlToken) {
            $isValid = $this->validateUrlToken($email, $urlToken);
        } else {
            return back()->withErrors(['token' => 'Token reset tidak valid.']);
        }

        if (!$isValid) {
            // SECURITY: Log failed attempt
            Log::warning('Invalid password reset attempt', [
                'email' => $email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            return back()->withErrors(['token' => 'Token reset tidak valid atau sudah kedaluwarsa.']);
        }

        // Cari user
        $user = User::where('email', $email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'User tidak ditemukan.']);
        }

        // VALIDASI: Password baru tidak boleh sama dengan password lama
        if (Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Password baru tidak boleh sama dengan password lama Anda. Silakan gunakan password yang berbeda untuk keamanan.'],
            ]);
        }

        // Simpan password lama untuk audit log
        $oldPasswordHash = $user->password;

        // Update password user
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // AUDIT LOG: Catat aktivitas reset password
        $this->logPasswordResetActivity($user, $request, $oldPasswordHash);

        // SECURITY: Cleanup - hapus token dan session
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        session()->forget(['reset_token_plain', 'reset_email', 'reset_expires']);

        // SECURITY: Invalidate all user sessions (logout from all devices)
        $this->invalidateAllUserSessions($user->id);

        // SECURITY: Log successful reset
        Log::info('Password reset successful', [
            'user_id' => $user->id,
            'email' => $email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // NOTIFICATION: Kirim notifikasi ke user (opsional, uncomment jika perlu)
        // $this->sendPasswordResetNotification($user, $request);

        return redirect()->route('signIn')
                        ->with('status', 'Password berhasil direset! Semua sesi telah dilogout untuk keamanan. Silakan login dengan password baru Anda.');
    }

    /**
     * SECURITY: Validate session-based token
     */
    private function validateSessionToken($email, $sessionToken)
    {
        // Check session expiry
        $sessionExpires = session('reset_expires');
        if ($sessionExpires && Carbon::now()->timestamp > $sessionExpires) {
            return false;
        }

        // Find record with matching email
        $resetRecord = DB::table('password_reset_tokens')
                        ->where('email', $email)
                        ->first();

        if (!$resetRecord) {
            return false;
        }

        // Check database expiry (double check)
        if (Carbon::parse($resetRecord->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return false;
        }

        // Verify token hash
        return Hash::check($sessionToken, $resetRecord->token);
    }

    /**
     * SECURITY: Validate URL-based token (fallback)
     */
    private function validateUrlToken($email, $urlToken)
    {
        $resetRecord = DB::table('password_reset_tokens')
                        ->where('email', $email)
                        ->first();

        if (!$resetRecord) {
            return false;
        }

        // Check expiry
        if (Carbon::parse($resetRecord->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return false;
        }

        // For backward compatibility, check both hashed and plain token
        return Hash::check($urlToken, $resetRecord->token) || $urlToken === $resetRecord->token;
    }

    /**
     * SECURITY: Invalidate all user sessions
     */
    private function invalidateAllUserSessions($userId)
    {
        if (config('session.driver') === 'database') {
            DB::table('sessions')->where('user_id', $userId)->delete();
        }
        
        // If using Redis sessions, add Redis cleanup here
        // Redis::del("laravel_session:user:$userId:*");
    }

    /**
     * AUDIT LOG: Log password reset activity untuk admin dashboard
     */
    private function logPasswordResetActivity($user, $request, $oldPasswordHash)
    {
        // Pastikan tabel audit_logs sudah ada (lihat migration di bawah)
        try {
            DB::table('audit_logs')->insert([
                'user_id' => $user->id,
                'event_type' => 'password_reset',
                'description' => 'User mereset password melalui email reset link',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'metadata' => json_encode([
                    'user_name' => $user->name,
                    'email' => $user->email,
                    'reset_method' => 'email_link',
                    'old_password_partial' => substr($oldPasswordHash, 0, 20) . '...', // Hanya simpan sebagian untuk referensi
                    'timestamp' => now()->toDateTimeString(),
                    'browser' => $this->getBrowser($request->userAgent()),
                    'os' => $this->getOS($request->userAgent()),
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Log error jika tabel belum ada
            Log::error('Failed to log password reset activity: ' . $e->getMessage());
        }
    }

    /**
     * NOTIFICATION: Kirim notifikasi ke user tentang password reset
     */
    private function sendPasswordResetNotification($user, $request)
    {
        // Simpan ke user_notifications table
        try {
            DB::table('user_notifications')->insert([
                'user_id' => $user->id,
                'type' => 'security_alert',
                'title' => 'Password Berhasil Direset',
                'message' => 'Password akun Anda telah berhasil direset pada ' . now()->format('d M Y H:i') . ' dari IP: ' . $request->ip() . '. Jika ini bukan Anda, segera hubungi admin.',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send password reset notification: ' . $e->getMessage());
        }
    }

    /**
     * Helper: Get browser name from user agent
     */
    private function getBrowser($userAgent)
    {
        if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (strpos($userAgent, 'Safari') !== false) return 'Safari';
        if (strpos($userAgent, 'Edge') !== false) return 'Edge';
        if (strpos($userAgent, 'Opera') !== false) return 'Opera';
        return 'Unknown';
    }

    /**
     * Helper: Get OS from user agent
     */
    private function getOS($userAgent)
    {
        if (strpos($userAgent, 'Windows') !== false) return 'Windows';
        if (strpos($userAgent, 'Mac') !== false) return 'macOS';
        if (strpos($userAgent, 'Linux') !== false) return 'Linux';
        if (strpos($userAgent, 'Android') !== false) return 'Android';
        if (strpos($userAgent, 'iOS') !== false) return 'iOS';
        return 'Unknown';
    }

    /**
     * Route untuk session-based reset form
     */
    public function showSessionResetForm()
    {
        $token = session('reset_token_plain');
        $email = session('reset_email');
        $expires = session('reset_expires');

        if (!$token || !$email || !$expires || now()->timestamp > $expires) {
            return redirect()->route('password.request')->with('error', 'Token reset password sudah kadaluwarsa.');
        }

        return view('auth.passwords.reset-session', [
            'email' => $email,
            'token' => $token
        ]);
    }

    /**
     * Reset password via session
     */
    public function resetSessionPassword(Request $request)
    {
        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ]
        ]);

        $email = session('reset_email');
        $token = session('reset_token_plain');
        $expires = session('reset_expires');

        if (!$token || !$email || now()->timestamp > $expires) {
            return redirect()->route('password.request')->with('error', 'Token reset password sudah kadaluwarsa.');
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('password.request')->with('error', 'User tidak ditemukan.');
        }

        // Validasi password baru tidak sama dengan password lama
        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password baru tidak boleh sama dengan password lama.']);
        }

        $oldPasswordHash = $user->password;
        $user->password = Hash::make($request->password);
        $user->save();

        // Log activity
        $this->logPasswordResetActivity($user, $request, $oldPasswordHash);

        // Hapus token session
        session()->forget(['reset_token_plain', 'reset_email', 'reset_expires']);

        // Invalidate sessions
        $this->invalidateAllUserSessions($user->id);

        return redirect()->route('signIn')->with('success', 'Password berhasil diubah. Silakan login dengan password baru.');
    }
}