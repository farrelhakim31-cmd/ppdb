<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentUserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user siswa untuk testing OTP
        User::create([
            'name' => 'Siswa Test',
            'email' => 'siswa@test.com',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
        ]);
    }
}