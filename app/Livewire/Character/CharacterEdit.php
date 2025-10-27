<?php

namespace App\Livewire\Character;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Livewire\Forms\Character\CharacterForm;
use App\Models\Lesson;
use App\Models\Character;

class CharacterEdit extends Component
{
    use WithFileUploads;
    public CharacterForm $form;
    public $lessons;

    public function mount(Character $character) {
        $this->lessons = Lesson::all();
        $this->form->setCharacter($character);
    }

    public function update() {
        $this->form->update();
        session()->flash('message', 'Character updated successfully.');
        return redirect()->route('characters.index');
    }

    public function render()
    {
        return view('livewire.character.character-edit');
    }
}
