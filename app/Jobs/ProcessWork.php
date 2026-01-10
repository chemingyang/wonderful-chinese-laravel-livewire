<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Word;

class ProcessWork implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $word;

    /**
     * Create a new job instance.
     */
    public function __construct(Word $word)
    {
        $this->word = $word;
    }

    private function createQRCode($stroke_code) 
    {
        $filename = $stroke_code.'.png';
        
        if (!Storage::disk('public')->exists('stroke_code/'.$filename)) {
            $url = "https://stroke-order.learningweb.moe.edu.tw/dictView.jsp?ID=" . $stroke_code;
            $renderer = new ImageRenderer(
                new RendererStyle(200),
                new ImagickImageBackEnd()
            );
            $writer = new Writer($renderer);
            $content = $writer->writeString($url);
            Storage::disk('public')->put('stroke_code/'.$filename, $content);
        } else {
            // Log that the QR code already exists
            Log::info("QR code already exists for stroke code: {$filename}");
        }
    }

    private function setStrokeCode($word) 
    {
        if ($word->traditional_no_bracket_unique_full_width_count === 1) {
            $lookedup = DB::table('code_lookup')->where('traditional', $word->traditional_no_bracket_unique_chars)->first();
            if (!empty($lookedup) && !empty($lookedup->unicode)) {
                $word->stroke_code = $lookedup->unicode;
                $word->save();
                $this->createQRCode($word->stroke_code);
            } else  {
                // log missing lookup
                Log::info("Missing stroke code lookup for word ID: {$word->id}, traditional: {$word->traditional_no_bracket_unique_chars}");
            }
        } else {
            // log ambiguous character count
            Log::info("Ambiguous character count for word ID: {$word->id}, traditional: {$word->traditional_no_bracket_unique_chars}, count: {$word->traditional_no_bracket_unique_full_width_count}");
        }
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Process the word
        $this->setStrokeCode($this->word);
    }
}
