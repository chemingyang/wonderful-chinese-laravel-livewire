<?php

namespace App\Livewire\Course;

use Livewire\Component;
use App\Livewire\Forms\Course\CourseForm;
use App\Models\Course;

class CourseEdit extends Component
{
    public CourseForm $form;

    public function mount(Course $course) {
        $this->form->setCourse($course);
    }

    public function update() {
        $this->form->update();
        return redirect()->route('courses.index');
    }

    public function render()
    {
        return view('livewire.course.course-edit');
    }
}
