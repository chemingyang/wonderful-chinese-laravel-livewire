<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = ['semester', 'course_id', 'student_id', 'note', 'status'];

    const VALID_STATUS = [
       0 =>'inactive',
       1 =>'active'
    ];

    const SEMESTER = [
        'fall 2025',
        'spring 2026',
        'fall 2026',
        'spring 2027',
    ];

    const CURRENT_SEMESTER = 'fall 2025';

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
