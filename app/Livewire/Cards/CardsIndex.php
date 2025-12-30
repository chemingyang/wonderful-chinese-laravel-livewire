<?php

namespace App\Livewire\Cards;

use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\Word;
use Illuminate\Support\Facades\Cache;

class CardsIndex extends Component
{
    public $words;
    public $totalWords;

    #[Url]
    public $offset = '0';
    private $step = 1;
    
    public function mount()
    {
        // Allow a bit more execution time for slow environments
        @set_time_limit(30);

        if (!is_numeric($this->offset) || intval($this->offset) < 0) {
            $this->offset = '0';
        }

        $this->totalWords = Word::count();
        $this->loadWords();
    }

    protected function loadWords(): void
    {
        $offsetInt = max(0, intval($this->offset));

        // Ensure offset is within bounds
        if ($this->totalWords > 0) {
            $maxPage = intdiv($this->totalWords - 1, $this->step);
            if ($offsetInt > $maxPage) {
                $offsetInt = 0;
                $this->offset = '0';
            }
        }

        $cacheKey = "cards_words_{$offsetInt}_{$this->step}";

        // Cache short-lived to reduce DB pressure on rapid navigation
        $this->words = Cache::remember($cacheKey, 10, fn() => Word::limit($this->step)->offset($offsetInt * $this->step)->get());
    }

    public function next(): void
    {
        $this->offset = (string)(intval($this->offset) + 1);
        $this->loadWords();
    }

    public function previous(): void
    {
        $this->offset = (string)max(0, intval($this->offset) - 1);
        $this->loadWords();
    }
    
    public function render()
    {
        return view('livewire.cards.cardsindex');
    }
}
