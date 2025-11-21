<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    protected $table = 'agama';
    
    protected $fillable = [
        'nama',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}