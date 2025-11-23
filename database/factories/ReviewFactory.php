<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        return [
            'user_id'    => User::inRandomOrder()->first()->id ?? User::factory(),
            'product_id' => Product::inRandomOrder()->first()->id ?? Product::factory(),
            'order_id'   => Order::inRandomOrder()->first()->id ?? Order::factory(),
            'user_name' => fake()->name(),
            'rating'     => fake()->numberBetween(1, 5),
            'comment'    => fake()->sentence(10),
        ];
    }
}
