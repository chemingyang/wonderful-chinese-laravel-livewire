<flux:fieldset>
    @if ($audio)
    <audio id="player{{$idx}}" src="{{ asset('storage/' . $audio) }}"></audio>
    <flux:button size="xs" id="playbutton{{$idx}}" onclick="document.getElementById('player{{$idx}}').play()" class="p-0 border-0 bg-transparent">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 0 1 0 .656l-5.603 3.113a.375.375 0 0 1-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112Z" />
        </svg>
    </flux:button>
    @endif
@if (@$type === 'fill-in-blank' || @$type === 'fill-in-blank-x')
    @php
        if ($type === 'fill-in-blank-x') {
            $charlength = mb_strlen($chinese_phrase);
            $offset = intval($question)-1; 
            $before = mb_substr($chinese_phrase, 0, $offset);
            $after = mb_substr($chinese_phrase, $offset + 1, $charlength - $offset - 1);
            $question = $before . '<>' . $after;
            $question = $zhuyin.' / '.$pinyin.' : '.$question;
        }        
    @endphp
    <div
        x-data="{
            words: $wire.form.answers[@js($rel)] ? $wire.form.answers[@js($rel)].split(',') : [],
            init() {}
        }"
        x-init="$nextTick(() => {
            insertTextInput(words, @js($idx));
            handleTextInput(@js($idx));
        })"
        id="q{{$idx}}"
    >
        <span>Q{{ ($idx+1) }}<span>
        {!! str_replace('<>','<input type="text" class="data-target inline border-1 border-color:#fff" style="width:80px; padding:5px; margin:5px" />',$question); !!}
    </div>
@elseif (@$type === 'answer-question')
    <span>Q{{ ($idx+1) }}. {{ $question }}</span>
    <div id="q{{$idx}}" data-rel="{{$rel}}"><flux:textarea rows="10" columns="35" />
@elseif (@$type === 'sort')
    @php
        $sortwords = explode('|',$question);
        $wordorders = [];
        $sorts = ['sort-'.$idx];
        //if (empty($answer)) {
        //    $wordorders = range(1, count($sortwords));
        //} else {
        $wordorders = !empty($answer) ? explode(',',$answer) : [];
        //}
    @endphp
    <span>Q{{ ($idx+1) }}.</span>
    <div x-data="{
            wordorders: $wire.form.answers[@js($rel)] ? $wire.form.answers[@js($rel)].split(',') : [],
            init() {}
        }"
        x-init="$nextTick(() => {
            insertWordBlocks(@js($sortwords), wordorders, @js($sorts[0]));
            makeSortable(@js($sorts), @js($idx), @js($sorts[0]));
        })"
        id="{{$sorts[0]}}"
        data-rel="{{$rel}}"
        class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 mt-2 min-h-18"
    >
    </div>
@elseif (@$type === 'drop')
    @php
        $dropparts = explode(':',$question);
        $dropprompt = $dropparts[0];
        $dropwords = explode('|',$dropparts[1]);
        $drops = ['sort-'.$idx.'-left','sort-'.$idx.'-right'];
    @endphp
    <span>Q{{ ($idx+1) }}.</span>
    <div 
        x-data="{
            wordorders: $wire.form.answers[@js($rel)] ? $wire.form.answers[@js($rel)].split(',') : [],
            init() {}
        }"
        x-init="$nextTick(() => {
            insertWordBlocks(@js($dropwords), wordorders, @js($drops[0]), @js($drops[1]));
            makeSortable(@js($drops), @js($idx), @js($drops[1]));
        })"
        id="{{$drops[0]}}" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 justify-left min-h-18 mt-2" 
    >
    </div>
    <div class="flex flex-col mr-2 mt-3 w-full">
        <span class="px-0 py-0 opacity-50 text-left">{{$dropprompt}}</span>
        <div id="{{$drops[1]}}" data-rel="{{$rel}}" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 h-full w-full space-x-1 justify-center min-h-18 mt-2">
    </div>
@elseif (@$type === 'match' || @$type === 'match-x')
    @php
        if ($type === 'match-x') {
            $chinese_characters = mb_str_split($chinese_phrase) ?? [];
            $zhuyin_characters = explode(' ',$zhuyin) ?? [];
            $pinyin_characters = explode(' ',$pinyin) ?? [];
            $boxes = [];
            foreach ($zhuyin_characters as $i => $zhuyin_character) {
                $boxes[] = $zhuyin_character . ' ' . ($pinyin_characters[$i] ?? '');
            }
            shuffle($boxes);
            shuffle($chinese_characters);
            $question = implode('|', $boxes) . ':' . implode('|', $chinese_characters);
        }
        $matchparts = explode(':',$question);
        $matchwords = explode('|',$matchparts[1]);
        $matchboxes = explode('|',$matchparts[0]);
        $sortsleft = ['sort-'.$idx.'-left'];
        $sortsright = [];
        foreach ($matchboxes as $i => $box) {
            $sortsright[] = 'sort-'.$idx.'-right'.$i;
        }
        $sortsrightgroup = 'sort-'.$idx.'-rightgroup';
        //$wordorders = [];
        //if (empty($answer)) {
        //    $wordorders = range(1, $matchwords.length);
        //} else {
        //    $wordorders = explode(',',$answer);
        //}
    @endphp
    <span>Q{{ ($idx+1) }}.</span>
    <div>
        <div 
            x-data="{
                wordorders: $wire.form.answers[@js($rel)] ? $wire.form.answers[@js($rel)].split(',') : [],
                init() {}
            }"
            x-init="$nextTick(() => {
                //console.log(@js($matchboxes));
                //console.log(@js($sortsright));
                insertWordBlocks(@js($matchwords), wordorders, @js($sortsleft[0]), @js($sortsrightgroup));
                makeSortable(@js($sortsleft), @js($idx), @js($sortsrightgroup));
                makeSortable(@js($sortsright), @js($idx), @js($sortsrightgroup), true);
            })"
            id="{{$sortsleft[0]}}" 
            class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 justify-left min-h-18 mt-2"
        >
        </div>
    </div>
    <div id="{{$sortsrightgroup}}" class="flex justify-right list-parent-group">
        @foreach($matchboxes as $i => $box)
            <!-- Move span above the sortable container -->
            <div class="flex flex-col mr-1 w-full h-full">
                @php
                    $boxpart = explode(' ',$box);
                @endphp
                <span class="flex px-1 pt-1 opacity-50 text-center justify-center">{{$boxpart[0]}}</span>
                <span class="flex px-1 pt-1 opacity-50 text-center justify-center">{{$boxpart[1] ?? ''}}</span>
                <div id="{{$sortsright[$i]}}" data-rel="{{$rel}}" class="flex list-group border border-gray-200 rounded-lg cursor-pointer h-full w-full space-x-1 justify-bottom justify-center min-h-18">
                    <!-- <div style="visibility: hidden; height: 0;"></div> --> <!-- hack to ensure swap does not inhibit drop behavior -->
                </div>
            </div>
        @endforeach
    </div>
    <style>
        .sortable-swap-highlight {
            background-color: rgba(125, 125, 125, 0.3) !important;
        }
        .sortable-list.empty-list {
            min-height: 8rem; /* Adjust the value as needed */
            /* Optional: add a border to visualize the drop area */
            border: 1px dashed #ccc; 
        }
    </style>
@else
    <span>invalid question type</span>
@endif
</flux:fieldset>