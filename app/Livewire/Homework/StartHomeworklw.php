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
    //public $wordorder = null;
    public HomeworkForm $form;
    public $index;
    public $maxindex;

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
        //$answers = [];
        //foreach ($this->lessonmodules as $lm) {
        //    $answers[$lm->id] = 'abc';
        //}
        $this->index = 0;
        $this->maxindex = count($this->lessonmodules);
        $this->form->lesson_id = $lesson_id;
        $this->form->student_id = Auth::id();
        $this->form->answers = json_decode('{"2":"a,b,c","3":"d,e,f","5":"okay"}',true);
    }

    public function store() { 
        $this->form->answers = !empty($this->form->answers) ? json_encode($this->form->answers) : null;
        $this->form->gradings = !empty($this->form->gradings) ? json_encode($this->form->gradings) : null;
        $this->form->store();
        session()->flash('message', 'Homework submitted successfully.');
        return redirect()->route('homeworks.homework-index');
    }

    public function clearSessionMessage() {
        session()->forget('message');
    }

    public function validateStep()
    {
        if($this->index === 0){
            $this->form->started_at = date('Y-m-d H:i:s');
            //$this->form->answers = !empty($this->form->answers) ? json_encode($this->form->answers) : null;
            //$this->form->gradings = !empty($this->form->gradings) ? json_encode($this->form->gradings) : null;

            $this->form->store();
            
        }elseif($this->index === 1){
            //if (!empty($this->form->answers)){
            //    dd($this->form->answers);
            //}

            //$this->form->answers = !empty($this->form->answers) ? json_encode($this->form->answers) : null;
            //$this->form->gradings = !empty($this->form->gradings) ? json_encode($this->form->gradings) : null;
            //dd($this->form->answers);
            $this->form->update();
        }elseif($this->index === 2){
            //$this->form->answers = !empty($this->form->answers) ? json_encode($this->form->answers) : null;
            //$this->form->gradings = !empty($this->form->gradings) ? json_encode($this->form->gradings) : null;
            $this->form->update();
           
        }elseif($this->index === 3){
            $this->form->submitted_at = date('Y-m-d H:i:s');
            $this->form->update();
        }
        session()->flash('message', 'Step '.$this->index.' saved');
    }    


    public function nextStep()
    {
        $this->validateStep();
        if($this->index <= $this->maxindex){
            $this->index++;
        }
    }
    public function prevStep()
    {
        if($this->index > 0){
            $this->index--;
        }
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

        return view('livewire.homework.start-homework-lw')->with([
            'lesson_title' => $this->lesson->title,
            'index'=> $this->index,
            'maxindex'=> $this->maxindex,
            'student_name' => Auth::user()->name,
            'lessonmodules' => $lms,
        ]);
    }

    //public function updateWordOrder($val)
    //{
    //    $this->wordorder = $val;
    //}
}
