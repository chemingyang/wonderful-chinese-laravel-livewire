<?php

namespace App\Livewire\Course;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Livewire\Forms\Course\CourseForm;

class CourseCreate extends Component
{
    use WithFileUploads;
    public CourseForm $form;

    public function store() {
        $this->form->store();
        session()->flash('message', 'Course created successfully.');
        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.course.course-create');
    }
}
