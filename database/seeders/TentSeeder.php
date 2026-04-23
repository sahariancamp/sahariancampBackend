<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tents = [
            [
                'name' => 'Quadruple Deluxe Tent',
                'slug' => 'quadruple-deluxe-tent',
                'type' => 'family',
                'price_per_night' => 250,
                'capacity' => 4,
                'description' => 'Every Tent is widely separated from the others with a big space in the middle to provide the best privacy. Every tent has selected bed linen and a wide ensuite private bathroom with everything you need for the highest comfortable stay including electricity and WiFi.',
                'features' => json_encode(['Selected bed linen', 'Ensuite private bathroom', 'Air Conditioner', 'Free WiFi', 'Tea/Coffee making facilities', 'Dunes views']),
                'image' => 'tents/hero-desert.png',
            ],
            [
                'name' => 'Family Deluxe Tent',
                'slug' => 'family-deluxe-tent',
                'type' => 'family',
                'price_per_night' => 300,
                'capacity' => 5,
                'description' => 'Designed for families seeking adventure without compromise. Enjoy the desert life from the highest comfort with a spacious setup that accommodates the whole family while ensuring privacy and relaxation.',
                'features' => json_encode(['Large family bed setup', 'Ensuite private bathroom', 'Air Conditioner', 'Free WiFi', 'Tea/Coffee making facilities', 'Dunes views']),
                'image' => 'tents/camp-tent.png',
            ],
            [
                'name' => 'Triple Deluxe Tent',
                'slug' => 'triple-deluxe-tent',
                'type' => 'suite',
                'price_per_night' => 200,
                'capacity' => 3,
                'description' => 'A spacious and luxurious tent perfect for a group of three. Wake up to stunning dune views, refreshed by desert air and golden light. Features premium bedding and an authentic Moroccan atmosphere.',
                'features' => json_encode(['3 Comfortable beds', 'Ensuite private bathroom', 'Air Conditioner', 'Free WiFi', 'Moroccan décor', 'Dunes views']),
                'image' => 'tents/tent-interior.png',
            ],
            [
                'name' => 'Double Deluxe Tent',
                'slug' => 'double-deluxe-tent',
                'type' => 'luxury',
                'price_per_night' => 150,
                'capacity' => 2,
                'description' => 'An intimate retreat for couples. The Double Deluxe offers a perfect balance of comfort and authenticity, with hand-crafted furnishings, uninterrupted views, and a romantic atmosphere.',
                'features' => json_encode(['Queen/King bed', 'Ensuite private bathroom', 'Air Conditioner', 'Free WiFi', 'Romantic setup', 'Dunes views']),
                'image' => 'tents/camp-tent.png',
            ],
            [
                'name' => 'Single Deluxe Tent',
                'slug' => 'single-deluxe-tent',
                'type' => 'standard',
                'price_per_night' => 100,
                'capacity' => 1,
                'description' => 'Perfect for the solo traveler seeking peace and reflection in the Sahara. Enjoy all the luxury amenities in a cozy, private setting overlooking the majestic dunes.',
                'features' => json_encode(['Comfortable single bed', 'Ensuite private bathroom', 'Air Conditioner', 'Free WiFi', 'Tea/Coffee making facilities', 'Dunes views']),
                'image' => 'tents/tent-interior.png',
            ],
        ];

        foreach ($tents as $tent) {
            \App\Models\Tent::create($tent);
        }
    }
}
