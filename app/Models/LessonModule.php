<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonModule extends Model
{   
    protected $fillable = ['type', 'lesson_id', 'question', 'answer_key', 'node'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    // --- IGNORE ----
    protected $hidden = ['created_at', 'updated_at'];
}
