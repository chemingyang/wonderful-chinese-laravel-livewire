<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Guardian extends User
{
    use HasParent;
}
