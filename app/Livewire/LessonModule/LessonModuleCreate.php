<?php

namespace App\Livewire\LessonModule;

use Livewire\Component;
use App\Models\Lesson;
use App\Models\Character;
use App\Models\LessonModule;
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
        
        // Initialize weight to the smallest integer greater than all other lessonmodules with the same lesson_id
        if ($this->form->lesson_id) {
            $maxWeight = LessonModule::where('lesson_id', $this->form->lesson_id)->max('weight') ?? 0;
            $nextWeight = $maxWeight + 1;
            
            // If weight is not already set or is 0/null, set it to nextWeight
            if (empty($this->form->weight) || $this->form->weight == 0) {
                $this->form->weight = $nextWeight;
                
                // Set weightSelect based on the weight value
                if ($nextWeight >= 1 && $nextWeight <= 20) {
                    $this->weightSelect = (string)$nextWeight;
                } else {
                    $this->weightSelect = 'other';
                }
            }
        }
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
