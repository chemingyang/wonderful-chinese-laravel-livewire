<?php

namespace App\Livewire\Homework;

use Livewire\Component;
use App\Models\Lesson;
use App\Models\LessonModule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\Homework\HomeworkForm;

class StartHomework extends Component
{
    public $lesson;
    public $lessonmodules;
    public $answers = [];
    public $wordorder = null;
    public HomeworkForm $form;

    public function mount($lesson_id)
    {
        $this->lesson = Lesson::find($lesson_id);
        $this->lessonmodules =
            DB::table('lesson_modules as lm')
            ->leftJoin('lessons as l','lm.lesson_id','=','l.id')
            ->where('l.id','=', $lesson_id)
            ->where('l.scheduled_at','<',now())
            ->where('l.completed_at','>',now())
            ->orderBy('lm.weight','ASC')
            ->select('lm.id', 'lm.type', 'lm.lesson_id', 'lm.question', 'lm.answer_key', 'lm.weight')
            ->get();
    }

    public function store() { 
        $this->form->store();
        session()->flash('message', 'Homework submitted successfully.');
        return redirect()->route('homeworks.homework-index');
    }

    public function render()
    {
        //dd($this->homework);
        //prepare lessonmodules for display
        $lms = null;
        foreach ($this->lessonmodules as $lm) {
            $lm->prompt = LessonModule::VALID_LESSON_MODULE_TYPES[$lm->type];
            $lms[] = $lm;
        }

        return view('livewire.homework.start-homework-flux')->with([
            'lesson_id' => $this->lesson->id,
            'lesson_title' => $this->lesson->title,
            'student_id' => Auth::id(),
            'lessonmodules' => $lms,
        ]);
    }

    public function updateWordOrder($val)
    {
        $this->wordorder = $val;
    }
}
