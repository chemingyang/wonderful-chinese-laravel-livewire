<?php

namespace App\Livewire\Forms\Homework;

use Livewire\Attributes\Validate;
use App\Models\Homework;
use Livewire\Form;

class HomeworkForm extends Form
{
    public $answers = [];
    public ?Homework $homework;
    public $lesson_id = null;
    public $student_id = null;
    public $gradings = []; 
    public $started_at = null;
    public $submitted_at = null;
    public $graded_at = null;
    public $reviewed_at = null;


    public function store() {
        //dd($this);
        $data = $this->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'student_id' => 'required|exists:users,id', // could this be students.id?
            'answers' => 'nullable|json',
            'answers.*' => 'nullable|string|max:225',
            'gradings' => 'nullable|json',
            'gradings.*' => 'nullable|string|max:225',
            'started_at' => 'nullable|date',
            'submitted_at' => 'nullable|date',
            'graded_at' => 'nullable|date',
            'reviewed_at' => 'nullable|date',
        ]);
        Homework::updateOrCreate(['lesson_id' => $this->lesson_id, 'student_id' => $this->student_id], $data);
        $this->reset();
    }

    public function setHomework(Homework $homework) {
        $this->homework = $homework;
        $this->lesson_id = $homework->lesson_id;
        $this->student_id = $homework->student_id;
        $this->answers = $homework->answers ? json_decode($homework->answers) : [];
        $this->gradings = $homework->gradings ? json_decode($homework->gradings) : [];
        //$this->answers = $homework->answers;
        //$this->gradings = $homework->gradings;
        $this->started_at = $homework->started_at;
        $this->submitted_at = $homework->submitted_at;
        $this->graded_at = $homework->graded_at;
        $this->reviewed_at = $homework->reviewed_at;
    }

    public function update() {
        $data = $this->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'student_id' => 'required|exists:users,id', // could this be students.id?
            'answers' => 'nullable|json',
            'answers.*' => 'nullable|string|max:225',
            'gradings' => 'nullable|json',
            'gradings.*' => 'nullable|string|max:225',
            'started_at' => 'nullable|date',
            'submitted_at' => 'nullable|date',
            'graded_at' => 'nullable|date',
            'reviewed_at' => 'nullable|date',
        ]);
        $this->homework->update($data);
        $this->reset();
    }

}
