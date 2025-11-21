<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentData extends Model
{
    use HasFactory;

    protected $fillable = [
        'pendaftar_id',
        'nama_ayah',
        'pekerjaan_ayah',
        'hp_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'hp_ibu',
        'wali_nama',
        'wali_hp'
    ];

    public function registration()
    {
        return $this->belongsTo(PpdbRegistration::class, 'pendaftar_id');
    }
}