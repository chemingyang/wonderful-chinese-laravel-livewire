<?php

namespace App\Livewire\Homework;

use Livewire\Component;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\Homework\HomeworkForm;

class GradeHomework extends Component
{
    public function render()
    {
        return view('livewire.homework.grade-homework');
    }
}
