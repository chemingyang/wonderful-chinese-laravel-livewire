<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Student extends User
{
    use HasParent;
}
