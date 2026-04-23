<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            ['title' => 'Royal Suite Sanctuary', 'category' => 'Sanctuaries', 'image_path' => 'gallery/luxury-bedroom-view.jpg', 'sort_order' => 1],
            ['title' => 'Family Triple Suite', 'category' => 'Sanctuaries', 'image_path' => 'gallery/family-triple-tent.jpg', 'sort_order' => 2],
            ['title' => 'Deluxe Twin Room', 'category' => 'Sanctuaries', 'image_path' => 'gallery/twin-deluxe-tent.jpg', 'sort_order' => 3],
            ['title' => 'Berber Traditional Suite', 'category' => 'Sanctuaries', 'image_path' => 'gallery/traditional-twin-tent.jpg', 'sort_order' => 4],
            ['title' => 'Sahara Family Lodge', 'category' => 'Sanctuaries', 'image_path' => 'gallery/quadruple-family-suite.jpg', 'sort_order' => 5],
            ['title' => 'Luxury Private Bath', 'category' => 'Sanctuaries', 'image_path' => 'gallery/private-bathroom-tent.jpg', 'sort_order' => 6],
            ['title' => 'Modern Bath Amenities', 'category' => 'Sanctuaries', 'image_path' => 'gallery/modern-bathroom-interior.jpg', 'sort_order' => 7],
            ['title' => 'Tent Vanity Space', 'category' => 'Sanctuaries', 'image_path' => 'gallery/vanity-mirror-tent.jpg', 'sort_order' => 8],
            ['title' => 'Artisan Bath Design', 'category' => 'Sanctuaries', 'image_path' => 'gallery/luxury-bathroom-detail.jpg', 'sort_order' => 9],
            ['title' => 'Luxury Desert Shower', 'category' => 'Sanctuaries', 'image_path' => 'gallery/luxury-shower-unit.jpg', 'sort_order' => 10],
            ['title' => 'Handcrafted Amenities', 'category' => 'Sanctuaries', 'image_path' => 'gallery/luxury-toiletries-setup.jpg', 'sort_order' => 11],
            ['title' => 'Welcome Refreshments', 'category' => 'Experiences', 'image_path' => 'gallery/welcome-drinks-tray.jpg', 'sort_order' => 12],
            ['title' => 'Moroccan Gastronomy', 'category' => 'Experiences', 'image_path' => 'gallery/authentic-moroccan-dinner.jpg', 'sort_order' => 13],
            ['title' => 'Communal Dining', 'category' => 'Experiences', 'image_path' => 'gallery/family-dining-experience.jpg', 'sort_order' => 14],
            ['title' => 'Saharian Camp Estate', 'category' => 'Camp Life', 'image_path' => 'gallery/camp-aerial-layout.jpg', 'sort_order' => 15],
            ['title' => 'Sunset Relaxation Lounge', 'category' => 'Camp Life', 'image_path' => 'gallery/sunset-lounge-area.jpg', 'sort_order' => 16],
        ];

        foreach ($images as $image) {
            \App\Models\GalleryItem::create($image);
        }
    }
}
