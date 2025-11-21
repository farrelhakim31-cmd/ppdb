<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'registration_id',
        'type',
        'description',
        'amount',
        'status',
        'due_date',
        'paid_at'
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2'
    ];

    public function registration()
    {
        return $this->belongsTo(\App\Models\PpdbRegistration::class, 'registration_id');
    }

    public function isOverdue()
    {
        return $this->status === 'unpaid' && $this->due_date < now();
    }

    public function getDaysUntilDueAttribute()
    {
        return $this->due_date->diffInDays(now(), false);
    }

    public static function generateInvoiceNumber()
    {
        $prefix = 'INV';
        $date = now()->format('Ymd');
        $count = self::whereDate('created_at', now())->count() + 1;
        return $prefix . $date . str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}