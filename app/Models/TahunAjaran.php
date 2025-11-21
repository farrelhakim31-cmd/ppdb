<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';
    
    protected $fillable = [
        'nama',
        'tahun_mulai',
        'tahun_selesai',
        'is_active'
    ];

    protected $casts = [
        'tahun_mulai' => 'integer',
        'tahun_selesai' => 'integer',
        'is_active' => 'boolean'
    ];
}