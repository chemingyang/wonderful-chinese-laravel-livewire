<?php

namespace App\Livewire\Word;

use Livewire\Component;
use App\Models\Word;
use App\Livewire\Forms\Word\WordForm;

class WordEdit extends Component
{
    public WordForm $form;
    public $levels = null;
    public $types = null;
    public $subtypes = null;
    public $book_ids = null;
    public $lesson_ids = null;

    public function mount(Word $word) {
        $this->form->setWord($word);
        $this->levels = array_keys(Word::VALID_LEVELS); 
        $this->types = array_keys(Word::VALID_TYPES);
        $this->subtypes = array_keys(Word::VALID_SUBTYPES);
        $this->book_ids = array_keys(Word::VALID_BOOK_IDS);
        $this->lesson_ids = array_keys(Word::VALID_LESSON_IDS);
    }

    public function update() {
        $this->form->update();
        session()->flash('message', 'word updated successfully.');
        return redirect()->route('words.index');
    }

    public function render()
    {
        return view('livewire.word.word-edit');
    }
}
