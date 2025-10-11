<?php

namespace App\Livewire\Lesson;

use Livewire\Component;
use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;

class LessonIndex extends Component
{
    // should include the delete function here
    public function delete($id)
    {
        $lesson = Lesson::find($id);
        if ($lesson) {
            $lesson->delete();
            session()->flash('message', 'Lesson deleted successfully.');
        } else {
            session()->flash('message', 'Lesson not found.');
        }
    }
    
    public function clearSessionMessage() {
        session()->forget('message');
    }
    
    public function render()
    {
        return view('livewire.lesson.lesson-index',[
            'lessons' => \App\Models\Lesson::with('course')->get()
        ]);
    }
}
