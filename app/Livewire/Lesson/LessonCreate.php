<?php

namespace App\Livewire\Lesson;

use Livewire\Component;
use App\Models\Course;
use App\Livewire\Forms\Lesson\LessonForm;

class LessonCreate extends Component
{
    public $courses;
    public LessonForm $form;

    public function mount() {
        $this->courses = Course::all();
    }

    public function store() {
        
        $this->form->store();
        session()->flash('message', 'Lesson created successfully.');
        return redirect()->route('lessons.index');
    }
    
    public function render()
    {
        return view('livewire.lesson.lesson-create')->with([
            'courses' => $this->courses,
        ]);
    }
}
