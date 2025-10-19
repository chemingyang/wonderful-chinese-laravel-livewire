<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'description', 'slug', 'image', 'teacher_id'];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    // --- IGNORE ----
    protected $hidden = ['created_at', 'updated_at'];
}
