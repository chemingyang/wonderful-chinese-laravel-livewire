<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['title', 'description', 'slug', 'course_id','scheduled_at','completed_at'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // --- IGNORE ----
    protected $hidden = ['created_at', 'updated_at'];

    public static function getByID(int|string $id)
    {
        return once(fn () => self::find($id));
    }
}
