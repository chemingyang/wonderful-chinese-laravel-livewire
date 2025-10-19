<?php

namespace App\Livewire\Course;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Livewire\Forms\Course\CourseForm;
use App\Models\Teacher;

class CourseCreate extends Component
{
    use WithFileUploads;
    public CourseForm $form;
    public $teachers;

    public function mount() {
        $this->teachers = Teacher::all();
    }
    
    public function store() {
        $this->form->store();
        session()->flash('message', 'Course created successfully.');
        return redirect()->route('courses.index');
    }

    public function render()
    {
        return view('livewire.course.course-create')->with([
            'teachers' => $this->teachers,
        ]);;
    }
}
