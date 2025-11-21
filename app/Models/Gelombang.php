<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gelombang extends Model
{
    protected $table = 'gelombang';
    
    protected $fillable = [
        'nama',
        'tanggal_mulai',
        'tanggal_selesai',
        'biaya_pendaftaran',
        'is_active'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'biaya_pendaftaran' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function ppdbRegistrations(): HasMany
    {
        return $this->hasMany(PpdbRegistration::class, 'gelombang_id');
    }
}