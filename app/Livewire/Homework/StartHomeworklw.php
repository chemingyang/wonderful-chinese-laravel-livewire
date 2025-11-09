<?php

namespace App\Livewire\Homework;

use Livewire\Component;
use App\Models\Lesson;
use App\Models\LessonModule;
use App\Models\Homework;
use App\Livewire\Forms\Homework\HomeworkForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StartHomeworklw extends Component
{
    public $lesson;
    public $lesson_id;
    public $lesson_title;
    public $student;
    public $student_id;
    public $student_name;
    public $lessonmodules;
    public $index;
    public $maxindex;
    public HomeworkForm $form;
    public ?Homework $homework;

    public function mount($lesson_id)
    {
        $this->lesson = Lesson::find($lesson_id);
        $this->lesson_id = $lesson_id;
        $this->lesson_title = $this->lesson->title;
        $this->student = Auth::user();
        $this->student_id = $this->student->id;
        $this->student_name = $this->student->name;
        $this->lessonmodules =
            DB::table('lesson_modules as lm')
            ->join('lessons as l','lm.lesson_id','=','l.id')
            ->leftJoin('characters as c','lm.character_id','=','c.id')
            ->where('l.id','=', $lesson_id)
            ->where('l.scheduled_at','<',now())
            ->where('l.completed_at','>',now())
            ->orderBy('lm.weight','ASC')
            ->select('lm.id', 'lm.type', 'lm.lesson_id', 'lm.question', 'lm.answer_key', 'lm.weight', 'lm.audio', 'c.chinese_phrase', 'c.zhuyin', 'c.pinyin', 'c.audio as wordaudio')
            ->get();
        $this->maxindex = count($this->lessonmodules);
        $this->homework = Homework::where('lesson_id', $lesson_id)->where('student_id', Auth::id())->first() ?? null;
        if (!empty($this->homework)) {
            //if (!empty($this->homework->graded_at)) {
            //    session()->flash('message', 'Homework already graded.');
            //    return redirect()->route('homeworks.homework-index');
            //} else {
                $this->form->setHomework($this->homework);
                $this->index = 0;
            //}
        } else {
            $this->form->lesson_id = $lesson_id;
            $this->form->student_id = Auth::id();
            $this->index = -1;
        }
    }

    public function store() { 
        //$this->form->answers = !empty($this->form->answers) ? json_encode($this->form->answers) : null;
        //$this->form->gradings = !empty($this->form->gradings) ? json_encode($this->form->gradings) : null;
        
        if (empty($this->homework)) {
            $this->homework = $this->form->store();
            $this->form->setHomework($this->homework);
        } else {
            $this->form->update();
        }
    }

    public function saveStep($increment)
    {
        if ($this->index == $this->maxindex){
            $this->form->submitted_at = date('Y-m-d H:i:s');
            $this->store();
            session()->flash('message', 'Homework stored successfully.');
            return redirect()->route('homeworks.homework-index');
        } else if ($this->index >= -1){
            //dd(okay);
            if (empty($this->form->started_at)) {
                $this->form->started_at = date('Y-m-d H:i:s');
                session()->flash('message', 'Homework started successfully.');
            }
            $this->store();
            $this->index+=$increment; 
        } 
    }

    public function render()
    {
        //dd($this->homework);
        //prepare lessonmodules for display
        //$lms = null;
        foreach ($this->lessonmodules as $lm) {
            $lm->prompt = LessonModule::VALID_LESSON_MODULE_TYPES[$lm->type];
            //$lms[] = $lm;
        }
        return view('livewire.homework.start-homework-lw');
    }

    //public function updateWordOrder($val)
    //{
    //    $this->wordorder = $val;
    //}
}
