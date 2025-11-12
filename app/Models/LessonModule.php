<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson;
use App\Models\Character;

class LessonModule extends Model
{   
    protected $fillable = ['type', 'lesson_id', 'character_id', 'audio', 'image', 'question', 'answer_key', 'weight', 'note'];

    const VALID_LESSON_MODULE_TYPES = [
        'fill-in-blank' => '請輸入空格',
        'answer-question' => '請根據提示回答',
        'sort' => '請重新排序',
        'drop' => '請挑選適合的項目',
        'match' => '請放至正確的格子',
        'fill-in-blank-x' => '請輸入空格',
        'match-x' => '請放至正確的格子',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public static function findByID(int|string $id)
    {
        return once(fn () => self::find($id));
    }

    // --- IGNORE ----
    protected $hidden = ['created_at', 'updated_at'];
}
