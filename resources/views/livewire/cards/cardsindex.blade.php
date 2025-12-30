<section>
    <div class="flex justify-end mr-6 pb-4">
        @if ($offset > 0)
        <a href="{{ route('cards.index', ['offset' => $offset-1]) }}" class="text-indigo-500 hover:text-indigo-700 font-medium">
        <span class="inline-flex mr-1">    
            <label>Previous Card</label>
        </span>
        </a>&nbsp;|&nbsp;
         @endif
        <a href="{{ route('cards.index', ['offset' => $offset+1]) }}" class="text-indigo-500 hover:text-indigo-700 font-medium">
        <span class="inline-flex mr-1">    
            <label>Next Card</label>
        </span>
        </a>
    </div>
    @foreach ($words as $word)
    <div class="flex">
        <flux:badge class="space-y-6 front inline-block">
            <div><span>{{ $word->level }}&nbsp;{{$word->type}}&nbsp;{{$word->subtype}}</span></div>
            <div><span style="font-size: 20px;">{{ $word->pinyin }}</span></div>
            <div><span style="font-size: 64px;">{{ $word->traditional }}</span></div>
            <div><span>學華語向前走&nbsp;{{$word->book_id}}&nbsp;{{$word->lesson_id}}</span></div>
        </flux:badge>
        <flux:badge class="space-y-6 back inline-block">
            <div><span>{{ $word->category }}</span></div>
            <div><span style="font-size: 20px;">{{ $word->english }}</span></div>
            @if (!empty($word->stroke_code))
            <div><span style="font-size: 64px;"><img src="{{ asset('storage/stroke_code/' . $word->stroke_code.'.png') }}" alt="{{ $word->traditional }} stroke code" class="h-24 w-24 object-fit"></span></div>
            @else
            <div><span style="font-size: 64px;">&nbsp;</span></div>
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
            width: 150px;
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
            width: 150px;
            height: 240px;
        }
    </style>
</section>