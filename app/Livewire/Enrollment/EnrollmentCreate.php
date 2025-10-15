<?php

namespace App\Livewire\Enrollment;

use Livewire\Component;
use App\Models\Course;
use App\Models\Student;
use App\Livewire\Forms\Enrollment\EnrollmentForm;

class EnrollmentCreate extends Component
{
    public $courses;
    public $students;
    public EnrollmentForm $form;

    public function mount() {
        $this->courses = Course::all();
        $this->students = Student::all();
    }

    public function store() {
        $this->form->store();
        session()->flash('message', 'Student enrolled successfully.');
        return redirect()->route('enrollments.index');
    }
    
    public function render()
    {
        return view('livewire.enrollment.enrollment-create')->with([
            'courses' => $this->courses,
            'students' => $this->students,
        ]);
    }
}
