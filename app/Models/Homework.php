<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    protected $fillable = ['student_id', 'lesson_id', 'answers', 'gradings', 'started_at', 'graded_at', 'reviewed_at'];
    protected $casts = ['answers' => 'json','gradings' => 'json'];
    // --- IGNORE ----
    protected $hidden = ['created_at', 'updated_at'];
}
