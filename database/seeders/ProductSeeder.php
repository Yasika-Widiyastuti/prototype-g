<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'Smartphone flagship terbaru dari Apple dengan kamera pro dan performa tinggi. Cocok untuk konten kreator dan fotografer profesional.',
                'category' => 'handphone',
                'price' => 150000,
                'image_url' => 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=500',
                'stock' => 5,
                'is_available' => true,
                'features' => ['48MP Camera', '5G Network', 'Face ID', 'Wireless Charging', 'A17 Pro Chip']
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Android flagship dengan S Pen dan kamera zoom 100x. Perfect untuk productivity dan creative work.',
                'category' => 'handphone',
                'price' => 140000,
                'image_url' => 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=500',
                'stock' => 3,
                'is_available' => true,
                'features' => ['200MP Camera', '100x Zoom', 'S Pen', '5G Network', 'AI Features']
            ],
            [
                'name' => 'BTS Official Army Bomb Ver.4',
                'description' => 'Official lightstick BTS untuk konser dan fan meeting. Dilengkapi dengan Bluetooth connectivity dan berbagai mode cahaya.',
                'category' => 'lightstick',
                'price' => 75000,
                'image_url' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=500',
                'stock' => 10,
                'is_available' => true,
                'features' => ['Bluetooth Connectivity', 'Multiple Light Modes', 'Official Merchandise', 'Rechargeable Battery']
            ],
            [
                'name' => 'BLACKPINK Official Light Stick',
                'description' => 'Official lightstick BLACKPINK dengan desain hammer dan LED RGB yang cantik.',
                'category' => 'lightstick',
                'price' => 70000,
                'image_url' => 'https://images.unsplash.com/photo-1571330735066-03aaa9429d89?w=500',
                'stock' => 8,
                'is_available' => true,
                'features' => ['RGB LED', 'Hammer Design', 'Official License', 'App Control']
            ],
            [
                'name' => 'TWICE Official Candybong Z',
                'description' => 'Lightstick resmi TWICE generasi terbaru dengan teknologi canggih dan desain yang eye-catching.',
                'category' => 'lightstick',
                'price' => 65000,
                'image_url' => 'https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?w=500',
                'stock' => 6,
                'is_available' => true,
                'features' => ['Smart Control', 'Colorful LED', 'Official Product', 'Long Battery Life']
            ],
            [
                'name' => 'Powerbank Xiaomi 20000mAh',
                'description' => 'Powerbank berkualitas tinggi dengan kapasitas besar dan fast charging support.',
                'category' => 'powerbank',
                'price' => 25000,
                'image_url' => 'https://images.unsplash.com/photo-1609592807019-8efabd5c09c7?w=500',
                'stock' => 15,
                'is_available' => true,
                'features' => ['20000mAh Capacity', 'Fast Charging', 'Dual USB Output', 'LED Indicator', 'Safety Protection']
            ],
            [
                'name' => 'Anker PowerCore 26800mAh',
                'description' => 'Premium powerbank dengan kapasitas super besar dan teknologi PowerIQ untuk charging optimal.',
                'category' => 'powerbank',
                'price' => 35000,
                'image_url' => 'https://images.unsplash.com/photo-1625744881949-5b5af3c8d7d7?w=500',
                'stock' => 12,
                'is_available' => true,
                'features' => ['26800mAh Ultra High Capacity', 'PowerIQ Technology', 'Triple USB Output', 'Premium Build Quality']
            ],
            [
                'name' => 'Powerbank Solar 50000mAh',
                'description' => 'Powerbank dengan panel solar untuk charging outdoor. Ideal untuk camping dan event outdoor.',
                'category' => 'powerbank',
                'price' => 45000,
                'image_url' => 'https://images.unsplash.com/photo-1601524909162-ae8725290836?w=500',
                'stock' => 8,
                'is_available' => true,
                'features' => ['Solar Panel', '50000mAh', 'Waterproof', 'LED Flashlight', 'Wireless Charging']
            ],
            [
                'name' => 'iPhone 14 Pro',
                'description' => 'iPhone generasi sebelumnya yang masih powerful dengan kamera pro dan Dynamic Island.',
                'category' => 'handphone',
                'price' => 120000,
                'image_url' => 'https://images.unsplash.com/photo-1663499482523-1c0c1bae1bfa?w=500',
                'stock' => 2,
                'is_available' => true,
                'features' => ['48MP Camera', 'Dynamic Island', 'A16 Bionic', 'ProRAW', 'Cinematic Mode']
            ],
            [
                'name' => 'SEVENTEEN Carat Bong Ver.2',
                'description' => 'Official lightstick SEVENTEEN dengan bentuk diamond yang unik dan fitur Bluetooth.',
                'category' => 'lightstick',
                'price' => 68000,
                'image_url' => 'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?w=500',
                'stock' => 7,
                'is_available' => true,
                'features' => ['Diamond Shape', 'Bluetooth Sync', 'Official Merchandise', 'Multi Color LED']
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}