<html>

<head>
    <meta charset="utf-8" />
    <!--<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> -->
    <!--<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet"> -->
    <!-- <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"> -->
    <!-- Use local compiled CSS for PDF rendering; DomPDF can load local files via file:// -->
    <!--<link href="file://{{ base_path('resources/css/app.css') }}" rel="stylesheet" type="text/css"> -->

    <style>
        .body {
            background-color: #fff;
        }

        .front {

            border: 1px solid #bbb;
            border-radius: 10px;
            padding: 10px;
            /* reduced padding for more usable area */
            margin: 10px;
            /* reduced margin so more cards fit per row */
            width: 180px;
            height: 305px;
        }

        .back {
            border: 1px solid #bbb;
            border-radius: 10px;
            padding: 10px;
            /* reduced padding */
            margin: 10px;
            /* reduced margin */
            width: 180px;
            height: 305px;
        }

        .back img {
            object-fit: contain;
        }
    </style>
</head>

<body>
    @foreach ($words as $word)
        <div class="justify-end mr-6 pb-4">
            <flux:badge class="space-y-6 front inline-block">
                <div
                    style="margin-bottom:0px; font-size: 18px; font-family: 'Noto Sans TC'; display:inline-block; width:100%; text-align:center;">
                    <span>
                        {{ $word->level }}&nbsp;{{$word->subtype}}
                    </span>
                </div>
                <div style="min-height:66px; margin-bottom:0px;">
                    <span
                        style="font-family: 'Noto Sans TC'; font-size: 20px; display:inline-block; width:100%; text-align:center;">{{ explode('/', $word->pinyin)[0] }}
                    </span>
                </div>
                @php
                    // Scale up the traditional font a bit to make characters more readable in print
                    //preg_match('/^(\d+)(\w*)$/', trim((string) ($word->traditional_font_size ?? '96px')), $m);
                    //$tNum = 96;
                    $tUnit = 'px';
                    // tScaled = (int) max(12, round($tNum * 1.20));
                    $tScaled = '96';
                @endphp
                <div style="min-height:160px;">
                    <span
                        style="font-size: {{ $tScaled }}{{ $tUnit }}; 
                                padding: 6px 0px; 
                                line-height: 0.95; 
                                font-family: 'Noto Sans TC'; 
                                display:inline-block; 
                                width:100%; 
                                text-align:center;">
                        {{ $word->traditional_chars }}
                    </span>
                </div>
                <div>
                    <span
                        style="font-family: 'Noto Sans TC'; display:inline-block; width:100%; text-align:center;">
                        學華語向前走&nbsp;{{$word->book_id}}&nbsp;{{$word->lesson_id}}
                    </span>
                </div>
            </flux:badge>
            <flux:badge class="space-y-6 back inline-block">
                <div
                    style="height: 60px; margin:0px; padding: 0px; font-size: 16px; font-family: 'Noto Sans TC'; line-height: 1.15; white-space: normal; overflow-wrap: anywhere; word-break: break-word; display:inline-block; width:100%; text-align:center;">
                    <span>
                        {{ $word->category }}<br>{{ $word->sanitized_english }}
                    </span>
                </div>
                @if (!empty($word->stroke_code) && extension_loaded('gd'))
                    <div style="height: 200px; margin: 0px; padding: 0px; display:inline-block; width:100%; text-align:center;">
                        <span style="font-size: 5px; margin: 0px; padding: 1px;">
                            <img
                                src="{{ storage_path('app/public/stroke_code/' . $word->stroke_code . '.png') }}"
                                alt="{{ $word->stroke_code }}" 
                            />
                        </span>
                    </div>
                @else
                    <div style="height: 200px; margin: 0px; display:inline-block; width:100%; text-align:center;">
                        <span style="font-size: 45px; padding: 0px;">
                            &nbsp;
                        </span>
                    </div>
                @endif
                <div style="margin: 0px;">
                    <span
                        style="font-family: 'Noto Sans TC'; display:inline-block; width:100%; text-align:center;">
                        學華語向前走
                    </span>
                </div>
            </flux:badge>
        </div>
    @endforeach
</body>

</html>