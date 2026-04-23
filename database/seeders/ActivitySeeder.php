<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            [
                'name' => 'Dromedary Ride through Dunes',
                'slug' => 'dromedary-ride-through-dunes',
                'price_per_person' => 50,
                'description' => 'Experience the tranquility of the desert on a dromedary ride through the dunes. These majestic creatures are perfectly adapted to the harsh desert environment. Watch the sun set over the dunes as you ride into the heart of the Sahara.',
                'duration' => '1-2 hours',
                'image' => 'activities/camel-trek.png',
            ],
            [
                'name' => 'Buggy Adrenaline',
                'slug' => 'buggy-adrenaline',
                'price_per_person' => 120,
                'description' => 'For those seeking an adrenaline rush, a desert buggy ride is an absolute must. These powerful vehicles are perfectly suited for navigating the challenging terrain of the Sahara, allowing you to experience the thrill of speeding across the dunes.',
                'duration' => '1-3 hours',
                'image' => 'activities/quad-biking.png',
            ],
            [
                'name' => 'Dunes Board',
                'slug' => 'dunes-board',
                'price_per_person' => 30,
                'description' => 'For a unique and adventurous experience, try dunes boarding. This exciting activity involves sliding down the steep slopes of the dunes on a specially designed board, similar to snowboarding. Feel the rush of adrenaline as you carve your way down.',
                'duration' => '1-2 hours',
                'image' => 'activities/sunrise-yoga.png',
            ],
            [
                'name' => 'Drums Rhythm Show',
                'slug' => 'drums-rhythm-show',
                'price_per_person' => 40,
                'description' => 'Enjoy a captivating evening of traditional music and dance at a drums rhythm show. Lose yourself in the rhythmic beats and vibrant energy as local musicians and dancers showcase their skills under the starry night sky.',
                'duration' => 'Evening',
                'image' => 'activities/berber-music.png',
            ],
            [
                'name' => 'Deep Desert Villages Day Tour',
                'slug' => 'deep-desert-villages-day-tour',
                'price_per_person' => 80,
                'description' => 'Venture off the beaten path and discover the hidden gems of the Sahara Desert. Immerse yourself in the local culture as you visit traditional Berber villages, interact with friendly locals, and learn about their way of life.',
                'duration' => 'Half or Full Day',
                'image' => 'activities/dining-stars.png',
            ],
        ];

        foreach ($activities as $activity) {
            \App\Models\Activity::create($activity);
        }
    }
}
