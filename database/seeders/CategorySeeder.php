<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Web Design', 'icon' => 'fa-code', 'description' => 'Learn modern web design techniques'],
            ['name' => 'Graphic Design', 'icon' => 'fa-paint-brush', 'description' => 'Master graphic design fundamentals'],
            ['name' => 'Video Editing', 'icon' => 'fa-video', 'description' => 'Professional video editing skills'],
            ['name' => 'Online Marketing', 'icon' => 'fa-bullhorn', 'description' => 'Digital marketing strategies']
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
