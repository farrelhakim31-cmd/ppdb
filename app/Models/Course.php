<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title', 'description', 'image', 'price', 'duration', 
        'students', 'rating', 'category_id', 'instructor_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
