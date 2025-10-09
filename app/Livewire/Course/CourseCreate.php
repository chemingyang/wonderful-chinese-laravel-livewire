<?php

namespace App\Livewire\Course;

use Livewire\Component;
use App\Livewire\Forms\Course\CourseForm;

class CourseCreate extends Component
{
    public CourseForm $form;

    public function store() {
        $this->form->store();
        return redirect()->route('courses.index');
    }

    public function render()
    {
        return view('livewire.course.course-create');
    }
}
