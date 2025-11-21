<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    protected $table = 'jurusan';
    
    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'kuota',
        'is_active'
    ];

    protected $casts = [
        'kuota' => 'integer',
        'is_active' => 'boolean'
    ];

    public function ppdbRegistrations(): HasMany
    {
        return $this->hasMany(PpdbRegistration::class, 'jurusan_id');
    }
}