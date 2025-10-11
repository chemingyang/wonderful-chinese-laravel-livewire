<?php

namespace App\Livewire\Lesson;

use Livewire\Component;
use App\Livewire\Forms\Lesson\LessonForm;
use App\Models\Lesson;
use App\Models\Course;

class LessonEdit extends Component
{
    public LessonForm $form;
    public $courses;

    public function mount(Lesson $lesson) {
        $this->form->setLesson($lesson);
        $this->courses = Course::all();
    }

    public function update() {
        $this->form->update();
        session()->flash('message', 'Lesson updated successfully.');
        return redirect()->route('lessons.index');
    }
    
    public function render()
    {
        return view('livewire.lesson.lesson-edit')->with([
            'courses' => $this->courses,
        ]);
    }
}
