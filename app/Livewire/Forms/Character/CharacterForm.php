<?php

namespace App\Livewire\Forms\Character;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Character;
use Illuminate\Support\Facades\Storage;

class CharacterForm extends Form
{
    public ?Character $character;
    public $chinese_phrase = '';
    public $pinyin = '';
    public $zhuyin = '';
    public $english_translation = '';
    public $lesson_id;
    public $audio = null; 
    private $validation_rule = [
            'chinese_phrase' => 'required|string|max:255',
            'pinyin' => 'required|string|max:255',
            'zhuyin' => 'required|string|max:255',
            'english_translation' => 'nullable|string|max:255',
            'lesson_id' => 'required|exists:lessons,id', // TBD make sure it's a teacher
            'audio' => 'nullable|mimes:mp3|max:1024', // 1MB Max
        ];

    public function setCharacter(Character $character) {
        $this->character = $character;
        $this->chinese_phrase = $character->chinese_phrase;
        $this->pinyin = $character->pinyin;
        $this->zhuyin = $character->zhuyin;
        $this->english_translation = $character->english_translation;
        $this->lesson_id = $character->lesson_id;
        // $this->audio = $character->audio; // audio is not set here TBD some handling reqiured for later
    }

    public function store() {
        $data = $this->validate($this->validation_rule);

        if ($this->audio) {
            $data['audio'] = $this->audio->store('characters', 'public');
        }
        // see function update
        $data['slug'] = str()->slug($data['title']);
        if (empty($data['slug'])) $data['slug'] = str()->slug($data['description']);

        Character::create($data);
        $this->reset();
    }

    public function update() {
        $data = $this->validate($this->validation_rule);

        $data['audio'] = $this->character->audio; // keep existing audio if no new audio is uploaded

        // tried handled through middleware convertemptystringtonull but no good
        if (empty($data['teacher_id'])) $data['teacher_id'] = null;

        if ($this->audio) {
            if ($this->character->audio) {
                Storage::disk('public')->delete($this->character->audio); // delete old audio
            }
            $data['audio'] = $this->audio->store('characters', 'public');
        }

        $this->character->update($data);
        $this->reset();
    }

}
