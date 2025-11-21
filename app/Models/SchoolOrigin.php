<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolOrigin extends Model
{
    use HasFactory;

    protected $fillable = [
        'pendaftar_id',
        'npsn',
        'nama_sekolah',
        'kabupaten',
        'nilai_rata'
    ];

    protected $casts = [
        'nilai_rata' => 'decimal:2'
    ];

    public function registration()
    {
        return $this->belongsTo(PpdbRegistration::class, 'pendaftar_id');
    }
}