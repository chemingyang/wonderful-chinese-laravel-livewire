<?php

namespace App\Livewire\Word;

use Livewire\Component;
use App\Models\Word;

class WordIndex extends Component
{
    public $levels = null;
    public $words = null;
    public $selected_level = null;

    public function mount() {
        $this->levels = array_keys(Word::VALID_LEVELS);
        $this->words = Word::all();
    }

    public function delete($id) {
        $word = Word::findByID($id);
        if ($word) {
            $word->delete();
            session()->flash('message', 'Word deleted successfully.');
        } else {
            session()->flash('message', 'Word not found.');
        }
    }

    public function render()
    {
        return view('livewire.word.word-index');
    }
}
