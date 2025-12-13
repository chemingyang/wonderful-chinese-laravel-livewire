<?php

namespace App\Livewire\Cards;

use Livewire\Component;
use App\Models\Word;

class CardsIndex extends Component
{
    public $words;
    
    public function mount()
    {
        $this->words = Word::limit(10)->get();
    }
    
    public function render()
    {
        return view('livewire.cards.cardsindex');
    }
}
