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
            'answers' => 'nullable|array',
            'answers.*' => 'nullable|string|max:225',
            'gradings' => 'nullable|array',
            'gradings.*' => 'nullable|string|max:225',
            'started_at' => 'nullable|date',
            'submitted_at' => 'nullable|date',
            'graded_at' => 'nullable|date',
            'reviewed_at' => 'nullable|date',
        ]);
        $data['answers'] = !empty($data['answers']) ? json_encode($data['answers']) : null;
        $data['gradings'] = !empty($data['gradings']) ? json_encode($data['gradings']) : null;
        Homework::create($data);
        $this->reset();
    }

    public function setHomework(Homework $homework) {
        $this->homework = $homework;
        $this->lesson_id = $homework->lesson_id;
        $this->student_id = $homework->student_id;
        $this->answers = $homework->answers ?? null;
        $this->gradings = $homework->gradings ?? null;
        //$this->answers = !empty($homework->answers) ? json_encode($homework->answers) : [];
        //$this->gradings = !empty($homework->gradings) ? json_encode($homework->gradings) : [];
        $this->started_at = $homework->started_at;
        $this->submitted_at = $homework->submitted_at;
        $this->graded_at = $homework->graded_at;
        $this->reviewed_at = $homework->reviewed_at;
    }

    public function update() {
        $data = $this->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'student_id' => 'required|exists:users,id', // could this be students.id?
            'answers' => 'nullable|array',
            'answers.*' => 'nullable|string|max:225',
            'gradings' => 'nullable|array',
            'gradings.*' => 'nullable|string|max:225',
            'started_at' => 'nullable|date',
            'submitted_at' => 'nullable|date',
            'graded_at' => 'nullable|date',
            'reviewed_at' => 'nullable|date',
        ]);
        $data['answers'] = !empty($data['answers']) ? json_encode($data['answers']) : null;
        $data['gradings'] = !empty($data['gradings']) ? json_encode($data['gradings']) : null;
        //dd($data);
        
        $this->homework->update($data);
        $this->reset();
    }

}
