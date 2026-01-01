<?php

namespace App\Livewire\Cards;

use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\Word;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

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
    

    public function pdf(): void
    {
        $pdf = Pdf::loadView('pdf.cards', ['words' => $this->words]);

        $filename = "cards_{$this->offset}.pdf";

        try {
            // Ensure the pdf directory exists on the public disk
            Storage::disk('public')->makeDirectory('pdf');

            $written = Storage::disk('public')->put('pdf/' . $filename, $pdf->output());

            if (! $written) {
                Log::error('CardsIndex PDF write failed', ['filename' => $filename, 'offset' => $this->offset]);
                $this->dispatch('cards-pdf-error', message: 'Failed to save PDF');
                return;
            }

            $publicUrl = asset("storage/pdf/{$filename}");

            Log::info('CardsIndex PDF saved', ['filename' => $filename, 'url' => $publicUrl]);

            // Notify the browser to download the file
            $this->dispatch('cards-pdf-ready', url: $publicUrl, filename: $filename);

        } catch (\Throwable $e) {
            Log::error('CardsIndex PDF error', ['exception' => $e]);
            $this->dispatch('cards-pdf-error', message: 'Failed to generate PDF');
        }
    }
    
    public function render()
    {
        return view('livewire.cards.cardsindex');
    }
}
