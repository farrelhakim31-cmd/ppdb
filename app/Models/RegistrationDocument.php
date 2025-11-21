<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'pendaftar_id',
        'jenis',
        'nama_file',
        'url',
        'ukuran_kb',
        'valid',
        'catatan'
    ];

    protected $casts = [
        'valid' => 'boolean'
    ];

    public function registration()
    {
        return $this->belongsTo(PpdbRegistration::class, 'pendaftar_id');
    }
}