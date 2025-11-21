<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class VerifikatorSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Verifikator Admin',
            'email' => 'verifikator@smk.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'verifikator',
            'phone' => '081234567890'
        ]);
    }
}