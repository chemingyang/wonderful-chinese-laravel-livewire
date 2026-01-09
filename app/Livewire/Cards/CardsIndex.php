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
    private $step = 4;

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
        $this->offset = (string) (intval($this->offset) + 1);
        $this->loadWords();
    }

    public function previous(): void
    {
        $this->offset = (string) max(0, intval($this->offset) - 1);
        $this->loadWords();
    }


    public function pdf(): void
    {
        // Initialize DomPDF options (enable remote assets & HTML5 parser)
        $options = Pdf::getDomPDF()->getOptions();
        $options->set('isFontSubsettingEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $pdf = Pdf::setPaper('a4', 'landscape');
        $pdf->getDomPDF()->setOptions($options);
        //}
        /*
        try {
            $html = view('pdf.cards', ['words' => $this->words])->render();
        } catch (\Throwable $e) {
            // Minimal inline HTML as a fallback to avoid requiring Blade compiled view writes
            $cssPath = base_path('resources/css/app.css');
            $html = '<html><head><meta charset="utf-8" />';
            $html .= '<link href="file://'.addslashes($cssPath).'" rel="stylesheet" type="text/css">';
            $html .= '<style>@font-face{font-family:"DroidSansFallback";src:url("file:///usr/share/fonts/truetype/droid/DroidSansFallbackFull.ttf") format("truetype");font-weight:normal;font-style:normal;}body{font-family: "DroidSansFallback", "Droid Sans Fallback", "Noto Sans CJK TC", "Noto Sans TC", sans-serif;} .front{display:flex;flex-direction:column;justify-content:center;align-items:center;border:1px solid #ccc;border-radius:5px;padding:10px;margin:10px;width:160px;height:240px;} .back{display:flex;flex-direction:column;justify-content:center;align-items:center;border:1px solid #ccc;border-radius:5px;padding:10px;margin:10px;width:160px;height:240px;} .flex{display:flex;flex-wrap:wrap;justify-content:center;align-items:center;}</style>';
            $html .= '</head><body>';
            foreach ($this->words as $word) {
                $html .= '<div class="flex justify-end mr-6 pb-4">';
                $html .= '<div class="space-y-6 front inline-block">';
                $html .= '<div style="margin-bottom:0px;"><span>'.htmlspecialchars($word->level.' '.$word->subtype, ENT_QUOTES, 'UTF-8').'</span></div>';
                $html .= '<div style="min-height:86px; margin-bottom:0px; display:flex; align-items:center; justify-content:center;"><span style="font-size:20px; display:inline-block; width:100%; text-align:center;">'.htmlspecialchars(explode('/', $word->pinyin)[0], ENT_QUOTES, 'UTF-8').'</span></div>';
                $html .= '<div style="min-height:80px;"><span style="font-size: '.htmlspecialchars($word->traditional_font_size, ENT_QUOTES, 'UTF-8').'; padding: 8px 0px; font-family: \"DroidSansFallback\", \"Droid Sans Fallback\", \"Noto Sans CJK TC\", \"Noto Sans TC\", sans-serif;">'.htmlspecialchars($word->traditional_chars, ENT_QUOTES, 'UTF-8').'</span></div>';
                $html .= '<div><span>學華語向前走&nbsp;'.htmlspecialchars($word->book_id, ENT_QUOTES, 'UTF-8').'&nbsp;'.htmlspecialchars($word->lesson_id, ENT_QUOTES, 'UTF-8').'</span></div>';
                $html .= '</div>';

                $html .= '<div class="space-y-6 back inline-block">';
                $html .= '<div style="margin-bottom:0px;"><span>'.htmlspecialchars($word->category, ENT_QUOTES, 'UTF-8').'</span></div>';
                $html .= '<div style="min-height:86px; margin-bottom:0px; display:flex; align-items:center; justify-content:center;"><span style="font-size: '.htmlspecialchars($word->english_font_size, ENT_QUOTES, 'UTF-8').'; line-height:1.0; white-space:normal; overflow-wrap:anywhere; word-break:break-word; display:inline-block; width:100%; max-width:100%; text-align:center;">'.htmlspecialchars($word->sanitized_english, ENT_QUOTES, 'UTF-8').'</span></div>';

                // Only include stroke image if GD extension is available
                if (! empty($word->stroke_code) && extension_loaded('gd')) {
                    $imgPath = storage_path('app/public/stroke_code/'.$word->stroke_code.'.png');
                    if (file_exists($imgPath)) {
                        $html .= '<div style="margin-bottom:10px;"><span style="font-size:8px; padding:0px;"><img src="'.addslashes($imgPath).'" alt="stroke" style="height:96px;width:96px;object-fit:contain;"></span></div>';
                    } else {
                        $html .= '<div style="margin-bottom:24px;"><span style="font-size:56px; padding:0px;">&nbsp;</span></div>';
                    }
                } else {
                    $html .= '<div style="margin-bottom:24px;"><span style="font-size:56px; padding:0px;">&nbsp;</span></div>';
                }

                $html .= '<div><span>學華語向前走&nbsp;'.htmlspecialchars($word->book_id, ENT_QUOTES, 'UTF-8').'&nbsp;'.htmlspecialchars($word->lesson_id, ENT_QUOTES, 'UTF-8').'</span></div>';

                $html .= '</div>'; // .back
                $html .= '</div>'; // .flex
            }
            $html .= '</body></html>';
        }
        */


        $pdf->loadView('pdf.cards', ['words' => $this->words]);

        $filename = "cards_{$this->offset}.pdf";

        try {
            // Ensure the pdf directory exists on the public disk
            Storage::disk('public')->makeDirectory('pdf');

            $written = Storage::disk('public')->put("pdf/{$filename}", $pdf->output());

            if (!$written) {
                Log::error('CardsIndex PDF write failed', ['filename' => $filename, 'offset' => $this->offset]);
                $this->dispatch('cards-pdf-error', message: 'Failed to save PDF');
                return;
            }

            $publicUrl = asset("storage/pdf/{$filename}");

            Log::info('CardsIndex PDF saved', ['filename' => $filename, 'url' => $publicUrl]);

            // Notify the browser to download the file
            $this->dispatch('cards-pdf-ready', url: $publicUrl, filename: $filename);

        } catch (\Exception $e) {
            Log::error("Failed to create PDF file: " . $e->getMessage());
            $this->dispatch('cards-pdf-error', message: 'Failed to generate PDF');
        } finally {
            Log::info("PDF generation attempted for offset {$this->offset}, filename: {$filename}");
        }


        // Storage::disk('public')->put("pdf/{$filename}", $output);
    }

    public function render()
    {
        return view('livewire.cards.cardsindex');
    }
}
