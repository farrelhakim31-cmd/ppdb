<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'title' => 'Complete Web Development Bootcamp',
                'description' => 'Learn HTML, CSS, JavaScript, and modern frameworks from scratch',
                'image' => 'img/course-1.jpg',
                'price' => 199.99,
                'duration' => 3600, // 60 hours
                'students' => 150,
                'rating' => 4.8,
                'category_id' => 1,
                'instructor_id' => 1
            ],
            [
                'title' => 'Advanced Graphic Design Masterclass',
                'description' => 'Master Adobe Creative Suite and design principles',
                'image' => 'img/course-2.jpg',
                'price' => 149.99,
                'duration' => 2400, // 40 hours
                'students' => 89,
                'rating' => 4.7,
                'category_id' => 2,
                'instructor_id' => 2
            ],
            [
                'title' => 'Professional Video Editing Course',
                'description' => 'Learn video editing with industry-standard software',
                'image' => 'img/course-3.jpg',
                'price' => 179.99,
                'duration' => 3000, // 50 hours
                'students' => 67,
                'rating' => 4.9,
                'category_id' => 3,
                'instructor_id' => 3
            ]
        ];

        foreach ($courses as $course) {
            \App\Models\Course::create($course);
        }
    }
}
