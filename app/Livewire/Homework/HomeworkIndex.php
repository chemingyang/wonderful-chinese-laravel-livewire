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
    // public $state = '';

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
            $cols[] = 'h.answers';
            $cols[] = 'h.gradings';
            $cols[] = 'h.started_at';
            $cols[] = 'h.submitted_at';
            $cols[] = 'h.graded_at';
            $cols[] = 'h.reviewed_at';
        }
        $this->uniqs = $this->uniqs->select($cols)->get();
        
        // turn json_encoded columns into array
        foreach ($this->uniqs as $index => $uniq) {
            $answers = json_decode($uniq->answers);
            $gradings = json_decode($uniq->gradings);
            $uniq->answers = $answers;
            $uniq->gradings = $gradings;
            $this->uniqs[$index] = $uniq;
        }
        // $this->status = $this->getState($this->uniqs);
    }
    /*
    function getState($uniqs): string  {
        if (empty($uniqs->gradings)) {
            if (empty($uniqs->answers)) {
                return 'new';
            } else {
                return 'submitted';
            }
        } else {
            if (empty($uniqs->reviewed_at)) {
                return 'graded';
            } else {
                return 'reviewed';
            }
        }
    }
    */
    public function render()
    { 
        // dd($this->uniqs);
        return view('livewire.homework.homework-index')->with([
            // 'homeworks' => $this->homeworks,
            'uniqs' => $this->uniqs,
            //'state' => $this->state,
        ]);
    }

    public function clearSessionMessage() {
        session()->forget('message');
    }
}
