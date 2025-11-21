<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PpdbRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gelombang_id',
        'jurusan_id',
        'no_pendaftaran',
        'registration_number',
        'name',
        'email',
        'phone',
        'birth_date',
        'birth_place',
        'gender',
        'address',
        'school_origin',
        'major',
        'parent_name',
        'parent_phone',
        'parent_job',
        'status',
        'payment_status',
        'verification_status',
        'verification_notes',
        'verified_at',
        'verified_by'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'verified_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function studentData()
    {
        return $this->hasOne(Student::class, 'pendaftar_id');
    }

    public function parentData()
    {
        return $this->hasOne(ParentData::class, 'pendaftar_id');
    }

    public function schoolOrigin()
    {
        return $this->hasOne(SchoolOrigin::class, 'pendaftar_id');
    }

    public function documents()
    {
        return $this->hasMany(RegistrationDocument::class, 'pendaftar_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'ppdb_registration_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function verificationLogs()
    {
        return $this->hasMany(VerificationLog::class, 'ppdb_registration_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'user_id');
    }

    public function getRequirementsCompletion()
    {
        $requirements = [
            !empty($this->name) && !empty($this->email) && !empty($this->phone) && !empty($this->birth_date) && !empty($this->birth_place) && !empty($this->gender) && !empty($this->address),
            !empty($this->parent_name) && !empty($this->parent_phone) && !empty($this->parent_job),
            !empty($this->school_origin),
            $this->birth_date ? $this->birth_date->diffInYears(now()) >= 15 : false,
            $this->documents()->count() >= 3,
            $this->payment_status === 'paid'
        ];
        
        $completed = collect($requirements)->where(true)->count();
        $total = count($requirements);
        
        return [
            'completed' => $completed,
            'total' => $total,
            'percentage' => $total > 0 ? round(($completed / $total) * 100) : 0
        ];
    }

    public static function generateRegistrationNumber()
    {
        $year = date('Y');
        $count = self::whereYear('created_at', $year)->count() + 1;
        
        // Pastikan nomor registrasi unik
        do {
            $registrationNumber = 'PPDB' . $year . str_pad($count, 4, '0', STR_PAD_LEFT);
            $exists = self::where('registration_number', $registrationNumber)->exists();
            if ($exists) {
                $count++;
            }
        } while ($exists);
        
        return $registrationNumber;
    }
}