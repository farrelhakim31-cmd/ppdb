<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPembayaran extends Model
{
    protected $table = 'jenis_pembayaran';
    
    protected $fillable = [
        'nama',
        'deskripsi',
        'nominal',
        'kategori',
        'is_active'
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'is_active' => 'boolean'
    ];
}