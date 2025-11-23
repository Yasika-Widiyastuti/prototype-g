<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'total_amount' => 0,
            'rental_date' => $this->faker->dateTime(),
            'status' => $this->faker->randomElement(['pending', 'paid', 'cancelled']),
            'order_number' => 'ORD-' . fake()->unique()->randomNumber(7),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
