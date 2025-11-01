<?php

namespace App\Livewire\LessonModule;

use Livewire\Component;
use App\Models\LessonModule;
use App\Models\Lesson;
use App\Models\Character;
use App\Livewire\Forms\LessonModule\LessonModuleForm;

class LessonModuleEdit extends Component
{
    public LessonModuleForm $form;
    public $lessons;
    public $weightSelect = null;
    
    public function mount(LessonModule $lessonmodule) {
        $this->form->setLessonModule($lessonmodule);
        $this->lessons = Lesson::all();
        // Set initial weightSelect based on current weight value
        if ($this->form->weight >= 1 && $this->form->weight <= 20) {
            $this->weightSelect = (string)$this->form->weight;
        } else {
            $this->weightSelect = 'other';
        }
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
        // Clear character_id when lesson changes if the character doesn't belong to the new lesson
        if ($this->form->character_id) {
            $character = Character::find($this->form->character_id);
            if (!$character || $character->lesson_id != $this->form->lesson_id) {
                $this->form->character_id = null;
            }
        }
    }

    public function update() {
        $this->form->update();
        session()->flash('message', 'Lesson module updated successfully.');
        return redirect()->route('lessonmodules.index');
    }
    
    public function render()
    {
        return view('livewire.lesson-module.lesson-module-edit')->with([
            'lessons' => $this->lessons,
            'characters' => $this->characters,
        ]);;
    }
}
