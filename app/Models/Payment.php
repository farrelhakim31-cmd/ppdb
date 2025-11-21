<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'ppdb_registration_id',
        'amount',
        'type',
        'payment_method',
        'payment_date',
        'status',
        'receipt_number',
        'payment_proof',
        'verified_by',
        'verified_at',
        'description'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'verified_at' => 'datetime'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function ppdbRegistration()
    {
        return $this->belongsTo(PpdbRegistration::class, 'ppdb_registration_id');
    }

    public function getPaymentTypeNameAttribute()
    {
        $types = [
            'registration' => 'Biaya Pendaftaran',
            'spp' => 'SPP',
            'uniform' => 'Seragam',
            'book' => 'Buku',
            'exam' => 'Ujian',
            'other' => 'Lainnya'
        ];
        
        return $types[$this->type] ?? ucfirst(str_replace('_', ' ', $this->type ?? 'Pembayaran'));
    }

    public function getStudentNameAttribute()
    {
        if ($this->student) {
            return $this->student->name;
        }
        
        if ($this->ppdbRegistration) {
            return $this->ppdbRegistration->user->name ?? $this->ppdbRegistration->nama_lengkap;
        }
        
        return 'Nama tidak tersedia';
    }
}