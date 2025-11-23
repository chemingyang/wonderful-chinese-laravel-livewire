<?php
namespace App\Livewire\Word;

use Livewire\Component;
use App\Livewire\Forms\Word\WordForm;
use App\Models\Word;

class WordCreate extends Component
{
    public WordForm $form;
    public $levels = null;
    public $types = null;
    public $subtypes = null;
    public $book_ids = null;
    public $lesson_ids = null;

     public function mount(Word $word) {
        $this->levels = array_keys(Word::VALID_LEVELS); 
        $this->types = array_keys(Word::VALID_TYPES);
        $this->subtypes = array_keys(Word::VALID_SUBTYPES);
        $this->book_ids = array_keys(Word::VALID_BOOK_IDS);
        $this->lesson_ids = array_keys(Word::VALID_LESSON_IDS);
    }

    public function store() {
        $this->form->store();
        session()->flash('message', 'Word created successfully.');
        return redirect()->route('words.index');
    }

    public function render()
    {
        return view('livewire.word.word-create');
    }
}