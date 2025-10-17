<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;
use App\Models\Course;

class Teacher extends User
{
    use HasParent;

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
