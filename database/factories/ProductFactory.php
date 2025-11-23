<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition()
    {
        $name = $this->faker->randomElement([
            'Lightstick Army Bomb',
            'Powerbank Anker 20k',
            'iPhone 14 Rental Unit',
            'Portable WiFi Modem',
            'Fan Meeting Camera Canon M10',
            'Lightstick Carat Bong'
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name . '-' . uniqid()),
            'description' => $this->faker->sentence(10),
            'category' => $this->faker->randomElement(['Tools', 'Gadget', 'Merch']),
            'price' => $this->faker->numberBetween(50000, 500000),
            'image_url' => 'https://picsum.photos/seed/' . rand(1,9999) . '/600/600',
            'stock' => $this->faker->numberBetween(1, 50),
            'is_available' => true,
            'features' => json_encode([
                'condition' => $this->faker->randomElement(['New', 'Good', 'Used']),
                'weight' => $this->faker->numberBetween(200, 2000) . "g",
            ]),
        ];
    }
}
