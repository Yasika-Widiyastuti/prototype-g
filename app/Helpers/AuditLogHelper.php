<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuditLogHelper
{
    /**
     * Log user activity to audit logs table
     *
     * @param int|null $userId
     * @param string $eventType
     * @param string $description
     * @param array $metadata
     * @return bool
     */
    public static function log($userId, string $eventType, string $description, array $metadata = []): bool
    {
        try {
            $request = request();
            
            // Tambahkan metadata default
            $defaultMetadata = [
                'timestamp' => now()->toDateTimeString(),
                'browser' => self::getBrowser($request->userAgent()),
                'os' => self::getOS($request->userAgent()),
            ];
            
            // Merge dengan metadata yang diberikan
            $metadata = array_merge($defaultMetadata, $metadata);
            
            // Insert ke database
            DB::table('audit_logs')->insert([
                'user_id' => $userId,
                'event_type' => $eventType,
                'description' => $description,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'metadata' => json_encode($metadata),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to log audit activity: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Log user login
     */
    public static function logLogin($userId, bool $success = true, array $additionalData = []): bool
    {
        $metadata = array_merge([
            'success' => $success,
            'login_method' => 'email_password',
        ], $additionalData);
        
        return self::log(
            $userId,
            $success ? 'login' : 'login_failed',
            $success ? 'User berhasil login' : 'Percobaan login gagal',
            $metadata
        );
    }
    
    /**
     * Log user logout
     */
    public static function logLogout($userId): bool
    {
        return self::log(
            $userId,
            'logout',
            'User logout dari sistem',
            []
        );
    }
    
    /**
     * Log profile update
     */
    public static function logProfileUpdate($userId, array $changedFields = []): bool
    {
        return self::log(
            $userId,
            'profile_update',
            'User mengupdate profil',
            [
                'changed_fields' => $changedFields,
            ]
        );
    }
    
    /**
     * Log payment activity
     */
    public static function logPayment($userId, string $transactionId, float $amount, string $status, array $additionalData = []): bool
    {
        $metadata = array_merge([
            'transaction_id' => $transactionId,
            'amount' => $amount,
            'status' => $status,
        ], $additionalData);
        
        return self::log(
            $userId,
            'payment',
            'User melakukan pembayaran',
            $metadata
        );
    }
    
    /**
     * Log booking activity
     */
    public static function logBooking($userId, string $bookingId, array $bookingData = []): bool
    {
        $metadata = array_merge([
            'booking_id' => $bookingId,
        ], $bookingData);
        
        return self::log(
            $userId,
            'booking',
            'User membuat booking baru',
            $metadata
        );
    }
    
    /**
     * Log password reset
     */
    public static function logPasswordReset($userId, string $resetMethod = 'email_link', array $additionalData = []): bool
    {
        $metadata = array_merge([
            'reset_method' => $resetMethod,
        ], $additionalData);
        
        return self::log(
            $userId,
            'password_reset',
            'User mereset password melalui ' . $resetMethod,
            $metadata
        );
    }
    
    /**
     * Log suspicious activity
     */
    public static function logSuspiciousActivity($userId, string $activityType, string $description, array $additionalData = []): bool
    {
        $metadata = array_merge([
            'activity_type' => $activityType,
            'severity' => 'high',
        ], $additionalData);
        
        // Also log to Laravel log for immediate attention
        Log::warning('Suspicious activity detected', [
            'user_id' => $userId,
            'activity_type' => $activityType,
            'description' => $description,
            'ip' => request()->ip(),
        ]);
        
        return self::log(
            $userId,
            'suspicious_activity',
            $description,
            $metadata
        );
    }
    
    /**
     * Get browser name from user agent
     */
    private static function getBrowser($userAgent): string
    {
        if (empty($userAgent)) return 'Unknown';
        
        if (stripos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (stripos($userAgent, 'Edg') !== false) return 'Edge';
        if (stripos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (stripos($userAgent, 'Safari') !== false) return 'Safari';
        if (stripos($userAgent, 'Opera') !== false || stripos($userAgent, 'OPR') !== false) return 'Opera';
        
        return 'Unknown';
    }
    
    /**
     * Get OS from user agent
     */
    private static function getOS($userAgent): string
    {
        if (empty($userAgent)) return 'Unknown';
        
        if (stripos($userAgent, 'Windows NT 10') !== false) return 'Windows 10';
        if (stripos($userAgent, 'Windows NT 11') !== false) return 'Windows 11';
        if (stripos($userAgent, 'Windows') !== false) return 'Windows';
        if (stripos($userAgent, 'Mac OS X') !== false) return 'macOS';
        if (stripos($userAgent, 'Linux') !== false) return 'Linux';
        if (stripos($userAgent, 'Android') !== false) return 'Android';
        if (stripos($userAgent, 'iOS') !== false || stripos($userAgent, 'iPhone') !== false) return 'iOS';
        
        return 'Unknown';
    }
    
    /**
     * Clean old audit logs (untuk maintenance)
     * 
     * @param int $days Number of days to keep
     * @return int Number of deleted records
     */
    public static function cleanOldLogs(int $days = 90): int
    {
        try {
            return DB::table('audit_logs')
                ->where('created_at', '<', now()->subDays($days))
                ->delete();
        } catch (\Exception $e) {
            Log::error('Failed to clean old audit logs: ' . $e->getMessage());
            return 0;
        }
    }
}