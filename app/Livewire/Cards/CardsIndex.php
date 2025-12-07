<?php

namespace App\Livewire\Cards;

use Livewire\Component;
use App\Models\Word;
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer;

class CardsIndex extends Component
{
    public $words;
    
    public function mount()
    {
        $this->words = Word::limit(10)->get();
    }
    
    public function render()
    {
        foreach ($this->words as $word) {
            if (!empty($word->stroke_code)) {
                $url = "https://stroke-order.learningweb.moe.edu.tw/dictView.jsp?ID=" . $word->stroke_code;
                $renderer = new Png(); // Or use GDLibRenderer/ImagickImageBackEnd
                $renderer->setHeight(128);
                $renderer->setWidth(128);

                $writer = new Writer($renderer);
                $writer->write($url, 'storage/stroke_codes/' . $word->traditional . '.png');


            } else {
                $word->stroke_code = 'N/A';
            }   
        }
        
        
        return view('livewire.cards.cardsindex');
    }
}
