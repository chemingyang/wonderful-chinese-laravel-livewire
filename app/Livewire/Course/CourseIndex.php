<?php

namespace App\Livewire\Course;

use Livewire\Component;

class CourseIndex extends Component
{
    public function render()
    {
        return view('livewire.course.course-index', [
            'courses' => \App\Models\Course::all()
        ]);
    }
}
