<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // USERS
        \App\Models\User::factory()->count(500)->create();

        // PRODUCTS
        \App\Models\Product::factory()->count(100)->create();

        // ORDERS
        \App\Models\Order::factory()->count(2000)->create();

        // ORDER ITEMS (biasanya 1–3 item per order)
        \App\Models\OrderItem::factory()->count(4000)->create();

        // PAYMENTS
        \App\Models\Payment::factory()->count(2000)->create();

        // REVIEWS
        \App\Models\Review::factory()->count(1000)->create();
    }
}
