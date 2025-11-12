<?php

namespace App\Livewire\Forms\LessonModule;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\LessonModule;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class LessonModuleForm extends Form

{
    public ?LessonModule $lessonmodule;
    public $type = null;
    public $lesson_id = null;
    public $character_id = null;
    public $audio = null;
    public $image = null;
    public $question = null;
    public $answer_key = null;
    public $weight = null; 
    public $note = '';
    private $validationRule = null;

    private function setRule() {
        $this->validationRule = [
            'type' => 'required|in:'.implode(',', array_keys(LessonModule::VALID_LESSON_MODULE_TYPES)),
            'lesson_id' => 'required|exists:lessons,id',
            'character_id' => [
                'nullable',
                Rule::requiredIf(function () {
                    return in_array($this->type, ['fill-in-blank-x', 'match-x']);
                }),
                'exists:characters,id',
            ],
            'audio' => 'nullable|mimes:mp3|max:1024',
            'image' => 'nullable|image|max:1024', // 1MB Max
            'question' => [
                'nullable',
                Rule::requiredIf(function () {
                    return !in_array($this->type, ['match-x']);
                }),
                'string',
                'max:255',
            ],
            'answer_key' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:255',
            'weight' => 'required|integer'
        ];
    }

    public function setLessonModule(LessonModule $lessonmodule) {
        //dd($lessonmodule);
        $this->lessonmodule = $lessonmodule;
        $this->type = $lessonmodule->type;
        $this->lesson_id = $lessonmodule->lesson_id;
        $this->character_id = $lessonmodule->character_id;
        $this->question = $lessonmodule->question;
        $this->answer_key = $lessonmodule->answer_key;
        $this->weight = $lessonmodule->weight;
        $this->note = $lessonmodule->note;
        // do not set audio or image here.
    }

    public function store() {
        $this->setRule();
        $data = $this->validate($this->validationRule);

        if ($this->audio) {
            $data['audio'] = $this->audio->store('lesson_modules', 'public');
        }

        if ($this->image) {
            $data['image'] = $this->image->store('lesson_modules', 'public');
        }

        LessonModule::create($data);
        $this->reset();
    }

    public function update() {
        $this->setRule();
        $data = $this->validate($this->validationRule);

        $data['audio'] = $this->lessonmodule->audio; // Keep existing audio if no new audio is uploaded

        if ($this->audio) {
            if ($this->lessonmodule->audio) {
                Storage::disk('public')->delete($this->lessonmodule->audio); // Delete old audio
            }
            $data['audio'] = $this->audio->store('lesson_modules', 'public');
        }

        $data['image'] = $this->lessonmodule->image; // keep existing image if no new image is uploaded

        if ($this->image) {
            if ($this->lessonmodule->image) {
                Storage::disk('public')->delete($this->lessonmodule->image); // delete old image
            }
            $data['image'] = $this->image->store('lesson_modules', 'public');
        }

        $this->lessonmodule->update($data);
        $this->reset();
    }
}
