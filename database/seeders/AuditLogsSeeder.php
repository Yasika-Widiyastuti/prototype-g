<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;

class AuditLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada user untuk testing
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UsersSeeder first.');
            return;
        }

        $eventTypes = [
            'login' => 'User login ke sistem',
            'logout' => 'User logout dari sistem',
            'password_reset' => 'User mereset password melalui email reset link',
            'profile_update' => 'User mengupdate profil',
            'payment' => 'User melakukan pembayaran',
            'booking' => 'User membuat booking baru',
        ];

        $browsers = ['Chrome', 'Firefox', 'Safari', 'Edge', 'Opera'];
        $os = ['Windows', 'macOS', 'Linux', 'Android', 'iOS'];
        $ips = ['192.168.1.', '10.0.0.', '172.16.0.'];

        $this->command->info('Creating sample audit logs...');

        // Create 100 sample logs
        for ($i = 0; $i < 100; $i++) {
            $user = $users->random();
            $eventType = array_rand($eventTypes);
            $browser = $browsers[array_rand($browsers)];
            $userOs = $os[array_rand($os)];
            $ipPrefix = $ips[array_rand($ips)];
            $ipAddress = $ipPrefix . rand(1, 254);
            
            // Random date dalam 30 hari terakhir
            $createdAt = Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59));

            $metadata = [
                'user_name' => $user->name,
                'email' => $user->email,
                'browser' => $browser,
                'os' => $userOs,
                'timestamp' => $createdAt->toDateTimeString(),
            ];

            // Tambahkan metadata khusus untuk password reset
            if ($eventType === 'password_reset') {
                $metadata['reset_method'] = 'email_link';
                $metadata['old_password_partial'] = '$2y$12$' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 20) . '...';
            }

            // Tambahkan metadata khusus untuk payment
            if ($eventType === 'payment') {
                $metadata['transaction_id'] = 'TRX-' . strtoupper(substr(md5(uniqid()), 0, 12));
                $metadata['amount'] = rand(50000, 500000);
                $metadata['status'] = ['pending', 'success', 'failed'][rand(0, 2)];
            }

            // Tambahkan metadata khusus untuk booking
            if ($eventType === 'booking') {
                $metadata['booking_id'] = 'BKG-' . strtoupper(substr(md5(uniqid()), 0, 12));
                $metadata['item'] = 'Sound System ' . rand(1, 10);
                $metadata['rental_date'] = Carbon::now()->addDays(rand(1, 30))->format('Y-m-d');
            }

            DB::table('audit_logs')->insert([
                'user_id' => $user->id,
                'event_type' => $eventType,
                'description' => $eventTypes[$eventType],
                'ip_address' => $ipAddress,
                'user_agent' => "Mozilla/5.0 ({$userOs}) AppleWebKit/537.36 (KHTML, like Gecko) {$browser}/100.0",
                'metadata' => json_encode($metadata),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }

        $this->command->info('✅ Successfully created 100 sample audit logs!');
    }
}