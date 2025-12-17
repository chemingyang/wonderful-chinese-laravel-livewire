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

    private function createQRCode($stroke_code) {
        if (!File::exists(public_path('stroke_code/'.$stroke_code.'.png'))) {
            $url = "https://stroke-order.learningweb.moe.edu.tw/dictView.jsp?ID=" . $stroke_code;
            $renderer = new ImageRenderer(
                new RendererStyle(200),
                new ImagickImageBackEnd()
            );
            $writer = new Writer($renderer);
            $content = $writer->writeString($url);
            Storage::disk('public')->put('stroke_code/' . $stroke_code . '.png', $content);
        }
    }

    private function setStrokeCode($word) {
        //if (empty($word->stroke_code)) {
        $lookedup = DB::table('code_lookup')->where('traditional', $word->traditional)->first();
        if (!empty($lookedup) && !empty($lookedup->unicode)) {
            $word->stroke_code = $lookedup->unicode;
            $word->save();
            $this->createQRCode($word->stroke_code);
        }
        //}
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
