<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'pendaftar_id',
        'nik',
        'nisn',
        'name',
        'email',
        'phone',
        'nama_ayah',
        'nik_ayah',
        'jk',
        'tmp_lahir',
        'tgl_lahir',
        'alamat',
        'wilayah_id',
        'lat',
        'lng'
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
        'lat' => 'decimal:7',
        'lng' => 'decimal:7'
    ];

    public function registration()
    {
        return $this->belongsTo(PpdbRegistration::class, 'pendaftar_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}