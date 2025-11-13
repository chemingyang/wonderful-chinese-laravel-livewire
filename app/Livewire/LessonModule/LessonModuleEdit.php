<?php

namespace App\Livewire\LessonModule;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Confirm;
use App\Models\LessonModule;
use App\Models\Lesson;
use App\Models\Character;
use App\Livewire\Forms\LessonModule\LessonModuleForm;

class LessonModuleEdit extends Component
{
    use WithFileUploads;

    public LessonModuleForm $form;
    public $lessons;
    public $weightSelect = null;
    public $others = false;
    public $othermodules = null;
    
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

    public function getOtherModules()
    {
        if ($this->others && $this->form->lesson_id && in_array($this->form->type, ['fill-in-blank','answer-question'])) {
            $this->othermodules = LessonModule::where('lesson_id', $this->form->lesson_id)
                ->whereIn('type', ['fill-in-blank','answer-question'])
                ->whereNotNull('image')
                ->get(['id','question']);
        } else {
            $this->othermodules = null;
        }
    }

    public function setFormImage() 
    {
        if (empty($this->otherid)) {
            $this->form->image = null;
            return;
        }
        $lm = LessonModule::findByID($this->otherid);
        if (!empty($lm) && !empty($lm->image)) {
            $this->form->image = $lm->image;
        } else {
            session()->flash('warning', 'Cannot set the image.');
        }
    }

    public function deleteAudio($id)
    {
        $lessonmodule = LessonModule::findByID($id);
        if ($lessonmodule && $lessonmodule->audio) {
            @Storage::disk('public')->delete($lessonmodule->audio);
            $lessonmodule->audio = null;
            $lessonmodule->update(['audio' => null]);
            $this->form->lessonmodule = $lessonmodule;
            session()->flash('message', 'Audio deleted successfully.');
        }
    }

    public function deleteImage($id)
    {
        $lessonmodule = LessonModule::findByID($id);
        if ($lessonmodule && $lessonmodule->image) {
            //need to make sure no other lesson module is using this image
            if (LessonModule::where('image', $lessonmodule->image)->count() > 1) {
                session()->flash('warning', 'other module references this image');
                return;
            }
            Storage::disk('public')->delete($lessonmodule->image);
            $lessonmodule->image = null;
            $lessonmodule->update(['image' => null]);
            $this->form->lessonmodule = $lessonmodule;
            session()->flash('message', 'Image deleted successfully.');
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
