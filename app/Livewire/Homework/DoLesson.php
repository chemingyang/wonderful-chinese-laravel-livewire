<?php

namespace App\Livewire\Homework;

use Livewire\Component;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;

class DoLesson extends Component
{
    public $lesson;
    public $homework;
    
    public function mount($lesson_id)
    {
        $this->lesson = Lesson::find($lesson_id);
        $this->homework =
            DB::table('lesson_modules as lm')
            ->leftJoin('lessons as l','lm.lesson_id','=','l.id')
            ->where('l.id','=', $lesson_id)
            ->where('l.scheduled_at','<',now())
            ->where('l.completed_at','>',now())
            ->orderBy('lm.weight','DESC')
            ->select('lm.id', 'lm.type', 'lm.lesson_id', 'lm.question', 'lm.answer_key', 'lm.weight')
            ->get();
    }
    
    public function render()
    {
        //dd($this->homework);
        return view('livewire.homework.do-lesson')->with([
            'lesson' => $this->lesson,
            'homework' => $this->homework
        ]);
    }
}
