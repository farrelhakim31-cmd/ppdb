<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepala@test.com',
            'password' => Hash::make('password'),
            'role' => 'kepala'
        ]);

        User::create([
            'name' => 'Siswa',
            'email' => 'siswa@test.com',
            'password' => Hash::make('password'),
            'role' => 'siswa'
        ]);

        User::create([
            'name' => 'Staff Keuangan',
            'email' => 'keuangan@test.com',
            'password' => Hash::make('password'),
            'role' => 'keuangan'
        ]);

        User::create([
            'name' => 'Verifikator Administrasi',
            'email' => 'verifikator@test.com',
            'password' => Hash::make('password'),
            'role' => 'verifikator'
        ]);
    }
}