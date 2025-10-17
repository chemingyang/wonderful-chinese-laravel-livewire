<?php

namespace App\Livewire\Homework;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// student do to carry out multi step submit to the homeworks table based on form to be created through lesson and lesson modules
class HomeworkIndex extends Component
{
    // public $homeworks;
    public $uniqs;
    public $user;
    public $student_id = null;

    public function mount()
    {
        // get the logged in student
        $this->user = Auth::user();
        if ($this->user->type == 'student') {
            $this->student_id = Auth::id();
        } 
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
        $cols = ["c.title as course_title","l.title as lesson_title","l.id as lesson_id"];
        $this->uniqs = 
        DB::table('lessons as l')
            ->Join('courses as c','l.course_id','=','c.id')
            ->where('l.scheduled_at','<',now())
            ->where('l.completed_at','>',now());

        if (!empty($this->student_id)) {
            $this->uniqs
                ->Join('enrollments as e', function ($join) {
                    $join->on('c.id', '=', 'e.course_id')
                    ->where('e.student_id', '=', $this->student_id);
                })
                ->leftJoin('homework as h', function ($join) {
                    $join->on('l.id', '=', 'h.lesson_id')
                    ->where('h.student_id', '=', $this->student_id);
                });
            $cols[] = 'e.id as enroll_id';
            $cols[] = 'h.id as homework_id';
        }
        $this->uniqs = $this->uniqs->select($cols)->get();

        // dd($this->uniqs);
        // $this->uniqs = $this->homeworks->unique('lesson_title')->select('course_title','lesson_title','lesson_id');
        // dd($this->uniqs);
    }
    
    public function render()
    { 
        return view('livewire.homework.homework-index')->with([
            // 'homeworks' => $this->homeworks,
            'uniqs' => $this->uniqs
        ]);
    }

    public function clearSessionMessage() {
        session()->forget('message');
    }
}
