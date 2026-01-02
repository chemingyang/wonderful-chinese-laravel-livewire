<html> 
<head>
    <meta charset="utf-8" />    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">

    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">
    <!-- Use local compiled CSS for PDF rendering; DomPDF can load local files via file:// -->
    <link href="file://{{ base_path('resources/css/app.css') }}" rel="stylesheet" type="text/css">

    <style>
   

    body {
        font-family: 'Noto Sans TC', sans-serif;
    }

    .front {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border: 1px solid #bbb;
        border-radius: 5px;
        padding: 6px; /* reduced padding for more usable area */
        margin: 6px;  /* reduced margin so more cards fit per row */
        width: 160px;
        height: 240px;
    }
    .back {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border: 1px solid #bbb;
        border-radius: 5px;
        padding: 6px; /* reduced padding */
        margin: 6px;  /* reduced margin */
        width: 160px;
        height: 240px;
    }
    .flex {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 8px; /* space between cards */
    }
    </style>
</head>
<body> 
    @foreach ($words as $word)
    <div class="flex justify-end mr-6 pb-4">
        <flux:badge class="space-y-6 front inline-block">
            <div style="margin-bottom:0px;"><span>{{ $word->level }}&nbsp;{{$word->subtype}}</span></div>
            <div style="min-height:86px; margin-bottom:0px; display:flex; align-items:center; justify-content:center;"><span style="font-size: 20px; display:inline-block; width:100%; text-align:center;">{{ explode('/',$word->pinyin)[0] }}</span></div>
            @php
                // Scale up the traditional font a bit to make characters more readable in print
                preg_match('/^(\d+)(\w*)$/', trim((string) ($word->traditional_font_size ?? '48px')), $m);
                $tNum = isset($m[1]) ? (int) $m[1] : 48;
                $tUnit = isset($m[2]) && $m[2] !== '' ? $m[2] : 'px';
                $tScaled = (int) max(12, round($tNum * 1.20));
            @endphp
            <div style="min-height:80px;"><span style="font-size: {{ $tScaled }}{{ $tUnit }}; padding: 6px 0px; line-height: 0.95; font-family: 'DroidSansFallback', 'Droid Sans Fallback', 'Noto Sans CJK TC', 'Noto Sans TC', sans-serif;">{{ $word->traditional_chars }}</span></div>
            <div><span>學華語向前走&nbsp;{{$word->book_id}}&nbsp;{{$word->lesson_id}}</span></div>
        </flux:badge>
        <flux:badge class="space-y-6 back inline-block">
            <div style="margin-bottom:0px;"><span>{{ $word->category }}</span></div>
            @php
                // Slightly increase English font size and tighten line-height for printing
                preg_match('/^(\d+)(\w*)$/', trim((string) ($word->english_font_size ?? '14px')), $em);
                $eNum = isset($em[1]) ? (int) $em[1] : 14;
                $eUnit = isset($em[2]) && $em[2] !== '' ? $em[2] : 'px';
                $eScaled = (int) max(10, round($eNum * 1.15));
            @endphp
            <div style="min-height:86px; margin-bottom:0px; display:flex; align-items:center; justify-content:center;"><span style="font-size: {{ $eScaled }}{{ $eUnit }}; line-height: 0.95; white-space: normal; overflow-wrap: anywhere; word-break: break-word; display:inline-block; width:100%; max-width:100%; text-align:center;">{{ $word->sanitized_english }}</span></div>
            @if (!empty($word->stroke_code) && extension_loaded('gd'))
            <div style="margin-bottom: 10px;"><span style="font-size: 8px; padding: 0px;"><img src="{{ storage_path('app/public/stroke_code/' . $word->stroke_code .'.png') }}" alt="{{ storage_path('app/public/stroke_code/' . $word->stroke_code .'.png') }}" class="h-24 w-24 object-fit"></span></div>
            @else
            <div style="margin-bottom: 24px;"><span style="font-size: 56px; padding: 0px;">&nbsp;</span></div>
            @endif
            <div><span>學華語向前走&nbsp;{{$word->book_id}}&nbsp;{{$word->lesson_id}}</span></div>
        </flux:badge>
    </div>
    @endforeach
</body>
</html>