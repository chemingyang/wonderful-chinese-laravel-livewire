<?php

namespace App\Livewire\LessonModule;

use Livewire\Component;

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
            'lessonmodules' => \App\Models\LessonModule::with('lesson')->get()
        ]);
    }

    public function clearSessionMessage() {
        session()->forget('message');
    }
}
