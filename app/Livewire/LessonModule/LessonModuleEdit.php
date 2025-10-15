<?php

namespace App\Livewire\LessonModule;

use Livewire\Component;
use App\Models\LessonModule;
use App\Models\Lesson;
use App\Livewire\Forms\LessonModule\LessonModuleForm;

class LessonModuleEdit extends Component
{
    public LessonModuleForm $form;
    public $lessons;
    
    public function mount(LessonModule $lessonmodule) {
        $this->form->setLessonModule($lessonmodule);
        $this->lessons = Lesson::all();
    }

    public function update() {
        $this->form->update();
        session()->flash('message', 'Lesson module updated successfully.');
        return redirect()->route('lessonmodules.index');
    }
    
    public function render()
    {
        return view('livewire.lesson-module.lesson-module-edit')->with([
            'lessons' => $this->lessons,
        ]);;
    }
}
