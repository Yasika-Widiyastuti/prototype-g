<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition()
    {
        return [
            'order_id' => Order::inRandomOrder()->first()->id ?? Order::factory()->create()->id,
            'product_id' => Product::inRandomOrder()->first()->id ?? Product::factory()->create()->id,
            'quantity' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->numberBetween(50000, 300000),
            'subtotal' => function (array $attributes) {
                return $attributes['quantity'] * $attributes['price'];
            },
            'created_at' => $this->faker->dateTimeBetween('2020-01-01', '2029-12-31'),
            'updated_at' => now(),
        ];
    }
}
