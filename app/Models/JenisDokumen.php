<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisDokumen extends Model
{
    protected $table = 'jenis_dokumen';
    
    protected $fillable = [
        'nama',
        'deskripsi',
        'is_required',
        'format_file',
        'max_size_kb',
        'is_active'
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'max_size_kb' => 'integer',
        'is_active' => 'boolean'
    ];
}