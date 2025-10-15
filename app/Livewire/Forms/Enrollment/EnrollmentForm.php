<?php

namespace App\Livewire\Forms\Enrollment;

use Livewire\Attributes\Validate;
use App\Models\Enrollment;
//use App\Models\Course;
//use App\Models\Student;
use Livewire\Form;

class EnrollmentForm extends Form
{
    public ?Enrollment $enrollment;
    public $course_id = null;
    public $student_id = null;
    public $status = null; 
    public $note = '';

    public function store() {
        //dd($this);
        $data = $this->validate([
            'course_id' => 'required|exists:courses,id',
            'student_id' => 'required|exists:users,id', // could this be students.id?
            'status' => 'required|in:'.implode(',', array_keys(Enrollment::VALID_STATUS)),
            'note' => 'nullable',
        ]);
        $data['semester'] = Enrollment::CURRENT_SEMESTER;
        Enrollment::create($data);
        $this->reset();
    }

    public function setEnrollment(Enrollment $enrollment) {
        $this->enrollment = $enrollment;
        $this->course_id = $enrollment->course_id;
        $this->student_id = $enrollment->student_id;
        $this->note = $enrollment->note;
        $this->status = $enrollment->status;
    }

    public function update() {
        $data = $this->validate([
            'course_id' => 'required|exists:courses,id',
            'student_id' => 'required|exists:users,id', // could this be students.id?
            'status' => 'required|in:'.implode(',', array_keys(Enrollment::VALID_STATUS)),
            'note' => 'nullable',
        ]);
        $this->enrollment->update($data);
        $this->reset();
    }
}
