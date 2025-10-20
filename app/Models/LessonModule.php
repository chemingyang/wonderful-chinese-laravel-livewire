<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson;

class LessonModule extends Model
{   
    protected $fillable = ['type', 'lesson_id', 'question', 'answer_key', 'weight', 'note'];

    const VALID_LESSON_MODULE_TYPES = [
        'fill-in-blank' => '請輸入空格',
        'answer-question' => '請回答問題',
        'sort' => '請重新排序',
        'drop' => '請挑選副合的項目',
        'match' => '請放至正確的格子',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    // --- IGNORE ----
    protected $hidden = ['created_at', 'updated_at'];
}
