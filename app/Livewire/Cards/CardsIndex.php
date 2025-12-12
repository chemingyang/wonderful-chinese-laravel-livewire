<?php

namespace App\Livewire\Cards;

use Livewire\Component;
use App\Models\Word;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Storage;

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
                $renderer = new ImageRenderer(
                    new RendererStyle(400),
                    new ImagickImageBackEnd()
                );
                $writer = new Writer($renderer);
                $content = $writer->writeString($url);
                Storage::disk('public')->put('stroke_code/' . $word->id . '.png', $content);



            } else {
                $word->stroke_code = 'N/A';
            }   
        }
        
        
        return view('livewire.cards.cardsindex');
    }
}
