<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'bio', 'image', 'specialization'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
