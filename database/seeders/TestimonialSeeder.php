<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Alex Johnson',
                'profession' => 'Web Developer',
                'message' => 'The courses here are amazing! I learned so much and got my dream job.',
                'image' => 'img/testimonial-1.jpg',
                'rating' => 5
            ],
            [
                'name' => 'Maria Garcia',
                'profession' => 'Graphic Designer',
                'message' => 'Excellent instructors and well-structured curriculum. Highly recommended!',
                'image' => 'img/testimonial-2.jpg',
                'rating' => 5
            ],
            [
                'name' => 'David Chen',
                'profession' => 'Video Editor',
                'message' => 'Professional quality education at an affordable price. Great experience!',
                'image' => 'img/testimonial-3.jpg',
                'rating' => 5
            ],
            [
                'name' => 'Lisa Brown',
                'profession' => 'Marketing Specialist',
                'message' => 'The practical approach to learning helped me apply skills immediately.',
                'image' => 'img/testimonial-4.jpg',
                'rating' => 5
            ]
        ];

        foreach ($testimonials as $testimonial) {
            \App\Models\Testimonial::create($testimonial);
        }
    }
}
