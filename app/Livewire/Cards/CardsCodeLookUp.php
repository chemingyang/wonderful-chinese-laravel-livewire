<?php

namespace App\Livewire\Cards;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Word;
use App\Jobs\ProcessWork;

class CardsCodeLookUp extends Component
{
    public $from_id = null;
    public $to_id = null;
    public $words = [];

    public function enqueue(): void
    {
        $validated = $this->validate([
            'from_id' => ['required', 'string', 'max:255'],
            'to_id'   => ['required', 'string', 'max:255']
        ]);

        $this->from_id = $validated['from_id']; 
        $this->to_id   = $validated['to_id'];
        $this->words   =
            Word::from('words as w')
            ->whereBetween('w.id', [$this->from_id, $this->to_id])
            ->orderBy('w.id','ASC')
            ->get();
        
        foreach ($this->words as $word) {
            // Dispatch a job for each word
            ProcessWork::dispatch($word);
        }
    }
    
    public function render()
    {
        return view('livewire.cards.cards-code-look-up');
    }
}
