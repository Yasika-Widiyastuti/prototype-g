<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition()
    {
        // Ambil user random
        $user = User::inRandomOrder()->first();

        // Ambil order random (harus ada!)
        $order = Order::inRandomOrder()->first();

        // Kalau belum ada order, buat dulu
        if (!$order) {
            $order = Order::factory()->create();
        }

        return [
            'user_id'        => $user->id,
            'order_id'       => $order->id,
            'bank'           => $this->faker->randomElement(['bca', 'bni', 'bri', 'mandiri', 'qris']),
            'bukti_transfer' => 'uploads/payments/dummy.jpg',
            'amount'         => $this->faker->numberBetween(50000, 500000),
            'status'         => $this->faker->randomElement(['waiting', 'success', 'failed']),
            'created_at'     => now(),
            'updated_at'     => now(),
        ];
    }
}
