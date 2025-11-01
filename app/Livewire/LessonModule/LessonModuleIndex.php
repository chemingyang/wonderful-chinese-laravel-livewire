<?php

namespace App\Livewire\LessonModule;

use Livewire\Component;
use App\Models\LessonModule;

class LessonModuleIndex extends Component
{
    public function delete($id)
    {
        $lessonmodule = LessonModule::find($id);
        if ($lessonmodule) {
            $lessonmodule->delete();
            session()->flash('message', 'Lesson deleted successfully.');
        } else {
            session()->flash('message', 'Lesson not found.');
        }
    }
    
    public function render()
    {
        return view('livewire.lesson-module.lesson-module-index', [
            'lessonmodules' => LessonModule::with(['lesson', 'character'])->get()
        ]);
    }

    public function clearSessionMessage() {
        session()->forget('message');
    }
}
