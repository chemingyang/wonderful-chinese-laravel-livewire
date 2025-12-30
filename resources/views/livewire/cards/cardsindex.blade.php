<section>
    <div class="flex justify-end mr-6 pb-4">
        @if ($offset > 0)
        <a href="{{ route('cards.index', ['offset' => $offset-1]) }}" wire:click.prevent="previous" class="text-indigo-500 hover:text-indigo-700 font-medium">
        <span class="inline-flex mr-1">    
            <label>Previous Card</label>
        </span>
        </a>&nbsp;|&nbsp;
         @endif
        <a href="{{ route('cards.index', ['offset' => $offset+1]) }}" wire:click.prevent="next" class="text-indigo-500 hover:text-indigo-700 font-medium">
        <span class="inline-flex mr-1">    
            <label>Next Card</label>
        </span>
        </a>
    </div>
    @foreach ($words as $word)
    <div class="flex">
        <flux:badge class="space-y-6 front inline-block">
            <div style="margin-bottom:0px;"><span>{{ $word->level }}&nbsp;{{$word->subtype}}</span></div>
            <div style="min-height:86px; margin-bottom:0px; display:flex; align-items:center; justify-content:center;"><span style="font-size: 20px; display:inline-block; width:100%; text-align:center;">{{ explode('/',$word->pinyin)[0] }}</span></div>
            <div style="min-height:80px;"><span style="font-size: {{ $word->traditional_font_size }}; padding: 8px 0px;">{{ $word->traditional_chars }}</span></div>
            <div><span>學華語向前走&nbsp;{{$word->book_id}}&nbsp;{{$word->lesson_id}}</span></div>
        </flux:badge>
        <flux:badge class="space-y-6 back inline-block">
            <div style="margin-bottom:0px;"><span>{{ $word->category }}</span></div>
            <div style="min-height:86px; margin-bottom:0px; display:flex; align-items:center; justify-content:center;"><span style="font-size: {{ $word->english_font_size }}; line-height: 1.0; white-space: normal; overflow-wrap: anywhere; word-break: break-word; display:inline-block; width:100%; max-width:100%; text-align:center;">{{ $word->sanitized_english }}</span></div>
            @if (!empty($word->stroke_code))
            <div style="margin-bottom: 10px;"><span style="font-size: 56px; padding: 0px;"><img src="{{ asset('storage/stroke_code/' . $word->stroke_code.'.png') }}" alt="{{ $word->traditional }} stroke code" class="h-24 w-24 object-fit"></span></div>
            @else
            <div style="margin-bottom: 24px;"><span style="font-size: 56px; padding: 0px;">&nbsp;</span></div>
            @endif
            <div><span>學華語向前走&nbsp;{{$word->book_id}}&nbsp;{{$word->lesson_id}}</span></div>
        </flux:badge>
    </div>
    @endforeach
    <style>
        .front {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            width: 160px;
            height: 240px;

        }
        .back {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            width: 160px;
            height: 240px;
        }
    </style>
</section>