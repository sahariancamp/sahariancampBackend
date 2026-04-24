<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviews = [
            // Google Reviews
            [
                'customer_name' => 'Giovanna Lastrucci',
                'rating' => 5,
                'comment' => 'Such an amazing place to stay! The camp is so so beautiful, well taken care of and clean. The staff is friendly and accommodating. The food is delicious and they always try to cook something different every day.',
                'is_published' => true,
                'stay_date' => '2024-05-15',
                'source' => 'google',
            ],
            [
                'customer_name' => 'Sherif Zaidan',
                'rating' => 5,
                'comment' => 'The location is amazing, at night when the lights are out, you can see all the stars. The food was really good, the tent very spacious with a nice bathroom and a table outside. The staff is very friendly and accommodating.',
                'is_published' => true,
                'stay_date' => '2024-06-10',
                'source' => 'google',
            ],
            [
                'customer_name' => 'Natalia Dhenin',
                'rating' => 5,
                'comment' => "If you're looking for an authentic camp experience in the Sahara desert, we can only recommend the Saharian Luxury Camp! Highly recommended.",
                'is_published' => true,
                'stay_date' => '2024-07-20',
                'source' => 'google',
            ],
            [
                'customer_name' => 'Lucas',
                'rating' => 5,
                'comment' => 'Simply my best experience. Reasonable price for incredible comfort and service. The tent is immense and the bed top, the bathroom same, the setting crazy, the staff is exceptionally warm. The luxury and the adventure.',
                'is_published' => true,
                'stay_date' => '2023-11-20',
                'source' => 'google',
            ],
            [
                'customer_name' => 'Luca Granitto',
                'rating' => 5,
                'comment' => 'We are 3 couple .. the tend are beautyful with bathroom and air conditioning .. king size bed. Dinner was fantastic and the people very helpful .. perfect place to visit the desert.',
                'is_published' => true,
                'stay_date' => '2026-04-18',
                'source' => 'google',
            ],

            // TripAdvisor Reviews
            [
                'customer_name' => 'Florian H',
                'rating' => 5,
                'comment' => 'A dream from a thousand and one nights. After a long trip, we arrived at the Saharian Luxury Camp at sunset. What awaited us there exceeded our expectations. The camp is lovingly furnished and offers a very special atmosphere. The tents are spacious and cozy.',
                'is_published' => true,
                'stay_date' => '2024-09-27',
                'source' => 'tripadvisor',
            ],
            [
                'customer_name' => 'Carlotta',
                'rating' => 5,
                'comment' => 'You cannot miss it! We spent one night at the Saharian Luxury Camp and we were immediately fascinated by the beauty and the comfort we found in the middle of the desert. The tents are fully furnished, better than a hotel room.',
                'is_published' => true,
                'stay_date' => '2024-04-15',
                'source' => 'tripadvisor',
            ],
            [
                'customer_name' => 'Martin L',
                'rating' => 5,
                'comment' => 'Fantastic Experience! We had a fantastic time at Saharian Camp. Haddou and Ahmed are great and take good care of the guests. Food is excellent, the ladies who do the cooking take very good care of you.',
                'is_published' => true,
                'stay_date' => '2023-04-10',
                'source' => 'tripadvisor',
            ],
            [
                'customer_name' => 'Danica C',
                'rating' => 5,
                'comment' => 'Perfect experience. My husband and I truly enjoyed our 3 night stay here. We were greeted with mint tea and enjoyed a lovely dinner. The rooms were clean, spacious and really comfortable. Beautiful sunsets right from camp.',
                'is_published' => true,
                'stay_date' => '2023-03-20',
                'source' => 'tripadvisor',
            ],
            [
                'customer_name' => 'Ji Yoon K',
                'rating' => 5,
                'comment' => "Funniest guys ever! My friend and I had the most amusing time at the desert. Providing the best service, in particular barbeque chicken was the best we've had in Morocco. I will never forget these guys.",
                'is_published' => true,
                'stay_date' => '2020-01-15',
                'source' => 'tripadvisor',
            ],
        ];

        foreach ($reviews as $review) {
            Review::updateOrCreate(
                ['customer_name' => $review['customer_name']],
                $review
            );
        }
    }
}
