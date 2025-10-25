<?php

namespace App\Livewire\Homework;

use Livewire\Component;
use App\Models\Homework; 
use App\Models\LessonModule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\Homework\HomeworkForm;

class GradeHomework extends Component
{
    public HomeworkForm $form;
    public $lessonmodules = [];
    public Homework $homework;    

    public function mount($homework_id)
    {
        $this->homework = Homework::find($homework_id);
        $this->form->setHomework($this->homework);
        $lms = LessonModule::where('lesson_id', '=', $this->homework->lesson_id)->get();
        foreach($lms as $lm) {
            $this->lessonmodules[$lm->id] = $lm;
        }
    }

    public function update() {
        $this->form->answers = !empty($this->form->answers) ? json_encode($this->form->answers) : null;
        $this->form->gradings = !empty($this->form->gradings) ? json_encode($this->form->gradings) : null;
        $this->form->update();
        session()->flash('message', 'Homework graded updated successfully.');
        return redirect()->route('homeworks.homework-index');
    }

    public function render()
    {
        //dd($this->lessonmodules);
        return view('livewire.homework.grade-homework')->with([
            'lessonmodules' => $this->lessonmodules,
        ]);
    }
}
