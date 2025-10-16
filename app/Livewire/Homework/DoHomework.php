<?php

namespace App\Livewire\Homework;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// student do to carry out multi step submit to the homeworks table based on form to be created through lesson and lesson modules
class DoHomework extends Component
{
    // public $homeworks;
    public $uniqs;
    public $student;
    public $student_id;

    public function mount()
    {
        // get the logged in student
        $this->student = Auth::user();
        $this->student_id = Auth::id();
        // get this week's homework
        /* $this->homeworks = 
            DB::table('lesson_modules as lm')
            ->leftJoin('lessons as l','lm.lesson_id','=','l.id')
            ->leftJoin('courses as c','l.course_id','=','c.id')
            ->leftJoin('enrollments as e', 'e.course_id','=','c.id')
            ->where('e.student_id','=',$this->student_id)
            ->where('l.scheduled_at','<',now())
            ->where('l.completed_at','>',now())
            ->orderBy('lm.weight','DESC')
            ->select('lm.id', 'lm.type', 'lm.lesson_id', 'lm.question', 'lm.answer_key', 'lm.weight', 'c.title as course_title', 'l.title as lesson_title')
            ->get();
        */
        $this->uniqs =
        DB::table('lessons as l')
            ->leftJoin('courses as c','l.course_id','=','c.id')
            ->leftJoin('enrollments as e', 'e.course_id','=','c.id')
            ->where('e.student_id','=',$this->student_id)
            ->where('l.scheduled_at','<',now())
            ->where('l.completed_at','>',now())
            ->select('c.title as course_title', 'l.title as lesson_title', 'l.id as lesson_id')
            ->get();


        // $this->uniqs = $this->homeworks->unique('lesson_title')->select('course_title','lesson_title','lesson_id');
        //dd($this->uniqs);
    }
    
    public function render()
    { 
        return view('livewire.homework.do-homework')->with([
            // 'homeworks' => $this->homeworks,
            'uniqs' => $this->uniqs,
            'student' => $this->student,
        ]);
    }
}
