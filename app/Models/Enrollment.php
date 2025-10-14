<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = ['semester', 'course_id', 'user_id', 'note'];

    const SEMESTER = [
        'Fall 2025',
        'Spring 2026',
        'Fall 2026',
        'Spring 2027',
    ];

    public function Student()
    {
        return $this->belongsTo(Student::class);
    }

    public function Course()
    {
        return $this->belongsTo(Course::class);
    }

    // --- IGNORE ----
    protected $hidden = ['created_at', 'updated_at'];
}
