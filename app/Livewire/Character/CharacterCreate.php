<?php
namespace App\Livewire\Character;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Livewire\Forms\Character\CharacterForm;
use App\Models\Lesson;
use App\Models\Character;

class CharacterCreate extends Component
{
    use WithFileUploads;
    public CharacterForm $form;
    public $lessons;

    public function mount(Character $character) {
        $this->lessons = Lesson::all();
    }

    public function store() {
        $this->form->store();
        session()->flash('message', 'Character created successfully.');
        return redirect()->route('characters.index');
    }

    public function render()
    {
        return view('livewire.character.character-create');
    }
}
