<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address',
        'aksi',
        'objek',
        'objek_data',
        'waktu',
        'ip'
    ];

    protected $casts = [
        'objek_data' => 'array',
        'waktu' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}