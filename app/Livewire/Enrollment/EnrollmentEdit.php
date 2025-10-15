<?php

namespace App\Livewire\Enrollment;

use Livewire\Component;
use App\Livewire\Forms\Enrollment\EnrollmentForm;
use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;

class EnrollmentEdit extends Component
{
    public EnrollmentForm $form;
    public $courses;
    public $students;

    public function mount(Enrollment $enrollment) {
        $this->form->setEnrollment($enrollment);
        $this->courses = Course::all();
        $this->students = Student::all();
    }

    public function update() {
        $this->form->update();
        session()->flash('message', 'Enrollment updated successfully.');
        return redirect()->route('enrollments.index');
    }
    
    public function render()
    {
        return view('livewire.enrollment.enrollment-edit');
    }
}
