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
    private $step = 1;
    
    public function mount()
    {
       
        if (!is_numeric($this->offset) || intval($this->offset) < 0) {
            $this->offset = '0';
        }
        $this->words = Word::limit($this->step)->offset(intval($this->offset)*$this->step)->get();
    }
    
    public function render()
    {
        return view('livewire.cards.cardsindex');
    }
}
