<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class NewUsersSeeder extends Seeder
{
    public function run()
    {
        // Kepala Sekolah
        User::firstOrCreate(
            ['email' => 'kepala@test.com'],
            [
                'name' => 'Kepala Sekolah',
                'password' => Hash::make('password'),
                'role' => 'kepala_sekolah'
            ]
        );

        // Verifikator
        User::firstOrCreate(
            ['email' => 'verifikator@test.com'],
            [
                'name' => 'Verifikator Administrasi',
                'password' => Hash::make('password'),
                'role' => 'verifikator'
            ]
        );
    }
}