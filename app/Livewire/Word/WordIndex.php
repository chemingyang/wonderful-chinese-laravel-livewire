<?php

namespace App\Livewire\Word;

use Livewire\Component;

class WordIndex extends Component
{
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
        $words = \App\Models\Word::all();

        return view('livewire.word.word-index', [
            'words' => $words,
        ]);
    }
}
