<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapSetting extends Model
{
    protected $fillable = [
        'school_name',
        'school_address',
        'latitude',
        'longitude',
        'zoom_level'
    ];

    public static function getSettings()
    {
        return self::first() ?? self::create([
            'school_name' => 'SMK Bakti Nusantara 666',
            'school_address' => 'Jl. Raya Percobaan No.65, Cileunyi Kulon, Kec. Cileunyi, Kabupaten Bandung, Jawa Barat 40622',
            'latitude' => -6.9389,
            'longitude' => 107.7186,
            'zoom_level' => 13
        ]);
    }
}