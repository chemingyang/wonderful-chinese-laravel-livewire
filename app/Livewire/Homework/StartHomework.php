<?php

namespace App\Livewire\Homework;

use Livewire\Component;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\Homework\HomeworkForm;

class StartHomework extends Component
{
    public $lesson;
    public $lessonmodules;
    public $answers = [];
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
        return redirect()->route('homeworks.do-homework');
    }

    public function render()
    {
        //dd($this->homework);
        return view('livewire.homework.start-homework')->with([
            'lesson' => $this->lesson,
            'student_id' => Auth::id(),
            'lessonmodules' => $this->lessonmodules,
        ]);
    }
}
