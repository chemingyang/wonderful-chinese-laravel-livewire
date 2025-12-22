<?php

namespace App\Livewire\Cards;

use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\Word;

class CardsIndex extends Component
{
    public $words;
    #[Url]
    public $offset = '0';
    
    public function mount()
    {
       
        if (!is_numeric($this->offset) || intval($this->offset) < 0) {
            $this->offset = '0';
        }
        $this->words = Word::limit(10)->offset(intval($this->offset)*10)->get();
    }
    
    public function render()
    {
        return view('livewire.cards.cardsindex');
    }
}
