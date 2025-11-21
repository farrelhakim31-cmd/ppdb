<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterData extends Model
{
    protected $fillable = [
        'type',
        'key',
        'value',
        'description'
    ];

    protected $casts = [
        'value' => 'json'
    ];
}