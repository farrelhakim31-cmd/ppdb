<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kelurahan extends Model
{
    protected $table = 'kelurahan';
    
    protected $fillable = [
        'kode',
        'nama',
        'kode_pos',
        'kecamatan_id'
    ];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }
}