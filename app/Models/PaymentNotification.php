<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'amount',
        'due_date',
        'status',
        'is_read'
    ];

    protected $casts = [
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'is_read' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}