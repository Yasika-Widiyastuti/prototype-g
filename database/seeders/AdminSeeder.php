<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        \Log::info('AdminSeeder running...');
        echo ">>> Running AdminSeeder\n";
        User::updateOrCreate(
            ['email' => 'admin@sewakonser.com'], // cek berdasarkan email
            [
                'name' => 'Admin System',
                'phone' => '081234567890',
                'address' => 'Kantor Pusat Sewa Konser',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

    }
}