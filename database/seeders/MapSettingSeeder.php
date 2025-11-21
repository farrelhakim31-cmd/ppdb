<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MapSetting;

class MapSettingSeeder extends Seeder
{
    public function run(): void
    {
        MapSetting::create([
            'school_name' => 'SMK Bakti Nusantara 666',
            'school_address' => 'Jl. Raya Percobaan No.65, Cileunyi Kulon, Kec. Cileunyi, Kabupaten Bandung, Jawa Barat 40622',
            'latitude' => -6.9389,
            'longitude' => 107.7186,
            'zoom_level' => 13
        ]);
    }
}