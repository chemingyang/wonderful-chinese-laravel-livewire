<?php

namespace App\Livewire\LessonModule;

use Livewire\Component;
use App\Models\Lesson;
use App\Models\Character;
use App\Livewire\Forms\LessonModule\LessonModuleForm;

class LessonModuleCreate extends Component
{
    public $lessons;
    public $weightSelect = null;
    public LessonModuleForm $form;
    
    public function mount() {
        $this->lessons = Lesson::all();
    }

    public function updatedWeightSelect($value)
    {
        if ($value === 'other') {
            // If current weight is 1-20, clear it for custom input
            // Otherwise, keep the existing custom value
            if (is_numeric($this->form->weight) && $this->form->weight >= 1 && $this->form->weight <= 20) {
                $this->form->weight = '';
            }
        } else {
            // Set weight to selected value (1-20)
            $this->form->weight = $value;
        }
    }

    public function getCharactersProperty()
    {
        if ($this->form->lesson_id) {
            return Character::where('lesson_id', $this->form->lesson_id)->get();
        }
        return collect();
    }

    public function updatedFormLessonId()
    {
        // Clear character_id when lesson changes
        $this->form->character_id = null;
    }

    public function store() {
        
        $this->form->store();
        session()->flash('message', 'Lesson module created successfully.');
        return redirect()->route('lessonmodules.index');
    }

    public function render()
    {
        return view('livewire.lesson-module.lesson-module-create', [
            'lessons' => $this->lessons,
            'characters' => $this->characters
        ]);
    }
}
