<?php

namespace App\Livewire\Homework;

use Livewire\Component;
use App\Models\Lesson;
use App\Models\LessonModule;
use App\Models\Homework;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\Homework\HomeworkForm;

class StartHomework extends Component
{
    public $lesson;
    public $lessonmodules;
    public $currentindex;
    //public $wordorder = null;
    public HomeworkForm $form;
    public ?Homework $homework;

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

        // this is fine but maybe the start homework link on homework-index should not have been there
        if (count($this->lessonmodules) === 0) {
            session()->flash('message', 'homework is not available.');
            return redirect()->route('homeworks.homework-index');
        }

        // try to get ongoing homework, one that is not submitted
        $this->homework = Homework::where('lesson_id', $lesson_id)->where('student_id', Auth::id())->first();
        if (!empty($this->homework)) {
            if (!empty($this->homework->graded_at)) {
                session()->flash('message', 'Homework already graded.');
                return redirect()->route('homeworks.homework-index');
            } else {
                $this->form->setHomework($this->homework);
                $this->currentindex = 0;
            }
        } else {
            $this->form->lesson_id = $lesson_id;
            $this->form->student_id = Auth::id();
            $this->currentindex = -1;
        }
    }

    public function store() { 
        $backToIndex = true;
        $this->form->answers = !empty($this->form->answers) ? json_encode($this->form->answers) : null;
        $this->form->gradings = !empty($this->form->gradings) ? json_encode($this->form->gradings) : null;
        if ($this->form->answers == null && $this->form->gradings == null) {
            $this->form->started_at = date('Y-m-d H:i:s');
            $backToIndex = false;
        } else /*if ($this->form->answers != null && $this->form->gradings == null)*/{
            $this->form->submitted_at = date('Y-m-d H:i:s');
        }
        $this->form->store();
        session()->flash('message', 'Homework submitted successfully.');
        //$this->currentindex++;
        if ($backToIndex) {
            return redirect()->route('homeworks.homework-index');
        } else {
            return redirect()->route('homeworks.start-homework',['lesson_id' => $this->lesson->id]);
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

        return view('livewire.homework.start-homework-flux')->with([
            'lesson_id' => $this->lesson->id,
            'lesson_title' => $this->lesson->title,
            'student_id' => Auth::id(),
            'lessonmodules' => $lms,
            'currentindex' => $this->currentindex,
        ]);
    }

    //public function updateWordOrder($val)
    //{
    //    $this->wordorder = $val;
    //}
}
