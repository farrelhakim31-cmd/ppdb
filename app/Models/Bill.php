<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'amount',
        'due_date',
        'status',
        'description',
        'created_by'
    ];

    protected $casts = [
        'due_date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}