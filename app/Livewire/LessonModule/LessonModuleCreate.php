<?php

namespace App\Livewire\LessonModule;

use Livewire\Component;
use App\Models\Lesson;
use App\Livewire\Forms\LessonModule\LessonModuleForm;

class LessonModuleCreate extends Component
{
    public $lessons;
    public LessonModuleForm $form;
    
    public function mount() {
        $this->lessons = Lesson::all();
    }

    public function store() {
        
        $this->form->store();
        session()->flash('message', 'Lesson module created successfully.');
        return redirect()->route('lessonmodules.index');
    }

    public function render()
    {
        return view('livewire.lesson-module.lesson-module-create', [
            'lessons' => $this->lessons
        ]);
    }
}
