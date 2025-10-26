<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $fillable = ['chinese_phrase', 'zhuyin', 'pinyin', 'lesson_id', 'audio', 'english translation'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
    // --- IGNORE ----
    protected $hidden = ['created_at', 'updated_at'];
}
