<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationLog extends Model
{
    protected $fillable = [
        'ppdb_registration_id',
        'verifier_id',
        'status',
        'notes',
        'verified_at'
    ];

    protected $casts = [
        'verified_at' => 'datetime'
    ];

    public function registration()
    {
        return $this->belongsTo(PpdbRegistration::class, 'ppdb_registration_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verifier_id');
    }
}