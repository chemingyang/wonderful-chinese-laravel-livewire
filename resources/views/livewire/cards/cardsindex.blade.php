<section>
    @foreach ($words as $word)
    <div class="flex">
        <flux:badge class="space-y-6 front inline-block">
            <div><span>{{ $word->level }}&nbsp;{{$word->type}}&nbsp;{{$word->subtype}}</span></div>
            <div><span style="font-size: 20px;">{{ $word->pinyin }}</span></div>
            <div><span style="font-size: 48px;">{{ $word->traditional }}</span></div>
            <div><span>學華語向前走&nbsp;{{$word->book_id}}&nbsp;{{$word->lesson_id}}</span></div>
        </flux:badge>
        <flux:badge class="space-y-6 back inline-block">
            <div><span>{{ $word->category }}</span></div>
            <div><span>{{ $word->english }}</span></div>
            <div><span>{{ $word->qrcode }}</span></div>
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