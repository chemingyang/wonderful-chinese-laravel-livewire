<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson;

class LessonModule extends Model
{   
    protected $fillable = ['type', 'lesson_id', 'question', 'answer_key', 'weight', 'note'];

    const VALID_LESSON_MODULE_TYPES = ['fill-in-blank','sort'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    // --- IGNORE ----
    protected $hidden = ['created_at', 'updated_at'];
}
