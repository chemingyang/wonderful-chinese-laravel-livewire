<?php

namespace App\Livewire\Course;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Livewire\Forms\Course\CourseForm;
use App\Models\Course;
use App\Models\Teacher;

class CourseEdit extends Component
{
    use WithFileUploads;
    public CourseForm $form;
    public $teachers;

    public function mount(Course $course) {
        $this->teachers = Teacher::all();
        $this->form->setCourse($course);
    }

    public function update() {
        $this->form->update();
        session()->flash('message', 'Course updated successfully.');
        return redirect()->route('courses.index');
    }

    public function render()
    {
        return view('livewire.course.course-edit')->with([
            'teachers' => $this->teachers
        ]);
    }
}
