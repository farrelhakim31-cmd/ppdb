<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructors = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '+1234567890',
                'bio' => 'Experienced web developer with 10+ years in the industry',
                'image' => 'img/team-1.jpg',
                'specialization' => 'Web Development'
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '+1234567891',
                'bio' => 'Creative graphic designer and UI/UX expert',
                'image' => 'img/team-2.jpg',
                'specialization' => 'Graphic Design'
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@example.com',
                'phone' => '+1234567892',
                'bio' => 'Professional video editor and motion graphics artist',
                'image' => 'img/team-3.jpg',
                'specialization' => 'Video Production'
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah@example.com',
                'phone' => '+1234567893',
                'bio' => 'Digital marketing strategist and SEO specialist',
                'image' => 'img/team-4.jpg',
                'specialization' => 'Digital Marketing'
            ]
        ];

        foreach ($instructors as $instructor) {
            \App\Models\Instructor::create($instructor);
        }
    }
}
