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
    <div id="q{{$idx}}">Q{{ ($idx+1) }}.{!! str_replace('<>','<input type="text" class="data-target inline border-1 border-color:#fff" style="width:80px; padding:5px; margin:5px" />',$question); !!}</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // console.log('abc');
        let idx = "{{$idx}}";
        let data_rel = document.getElementById('q'+idx);
        // console.log(data_rel);
        data_rel.addEventListener('keyup', function(event) {
            //console.log('in f-i-b keyup');
            let childs = this.children;
            let vals = [];
            for (const child of childs) {
                vals.push(child.value);
            }
            // console.log(vals);
            let inputElem = document.getElementById('a'+idx);
            inputElem.value = vals.join(',');
            inputElem.dispatchEvent(new Event('input'));
        }); 
    });
</script>
@elseif (@$type === 'answer-question')
    <span>Q{{ ($idx+1) }}. {{ $question }}</span>
    <div id="q{{$idx}}" data-rel="{{$rel}}"><flux:textarea rows="10" columns="35" />
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let rel = "{{$rel}}";
        let idx = "{{$idx}}";
        let data_rel = document.getElementById('q'+idx);
        data_rel.addEventListener('change', function(event) {
            let inputElem = document.getElementById('a'+idx);
            inputElem.value = event.target.value;
            inputElem.dispatchEvent(new Event('input'));
        });
    });
</script>
@elseif (@$type === 'sort')
    @php
        $sortwords = explode('|',$question);
        $sorts = ['sort-'.$idx];
    @endphp
    <span>Q{{ ($idx+1) }}.</span>
    <div id="{{$sorts[0]}}" data-rel="{{$rel}}" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 mt-2 min-h-18">
    @foreach ($sortwords as $i => $word)
        <div data-val="{{($i+1)}}" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" style="z-index:1; opacity:75%;"><span>{{($i+1)}}. {{$word}}</span></div>
    @endforeach
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            let elemIDArr = @json($sorts);
            elemIDArr.forEach(function(elemID, i) {
                let el = document.getElementById(elemID);
                new Sortable(el, {
                    animation: 150,
                    group: {
                        name: 'shared'
                    },
                    onEnd: function (evt) { 
                        let parent = document.getElementById(elemIDArr[0]);
                        let childs = parent.getElementsByTagName('div');
                        let idx = "{{$idx}}";
                        let vals = [];
                        for (const child of childs) {
                            vals.push(child.getAttribute('data-val'));
                        }
                        let inputElem = document.getElementById('a'+idx);
                        inputElem.value = vals.join(',');
                        inputElem.dispatchEvent(new Event('input')); 
                    },
                    ghostClass: 'blue-background-class'
                });
            });
        }); 
    </script>
@elseif (@$type === 'drop')
    @php
        $dropparts = explode(':',$question);
        $dropprompt = $dropparts[0];
        $dropwords = explode('|',$dropparts[1]);
        $drops = ['sort-'.$idx.'-left','sort-'.$idx.'-right'];
    @endphp
        <span>Q{{ ($idx+1) }}.</span>
    <!--<div class="grid w-full gap-6 md:grid-cols-2"> -->
        <div id="{{$drops[0]}}" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 justify-left min-h-18 mt-2" >
        @foreach ($dropwords as $i => $word)
            <div data-val="{{($i+1)}}" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" style="z-index:1; opacity:75%;"><span class="p-1">{{($i+1)}}. {{$word}}</span></div>
        @endforeach
        </div>
        <div id="{{$drops[1]}}" data-rel="{{$rel}}" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 h-full w-full space-x-1 justify-center min-h-18 mt-2">
            <span style="position:absolute; opacity: 50%;" class="px-6 py-0 filtered">{{$dropprompt}}</span>
        </div>
    <!-- </div> -->
    <script> 
        document.addEventListener('alpine:init', () => {
            let elemIDArr = @json($drops);
            
            elemIDArr.forEach(function(elemID, i) {
                let el = document.getElementById(elemID);
                let settings = {
                    animation: 150,
                    group: {
                        name: 'shared'
                    },
                    onEnd: function (evt) { 
                        let parent = document.getElementById(elemIDArr[1]);
                        let childs = parent.getElementsByTagName('div');
                        let idx = "{{$idx}}";
                        let vals = [];
                        for (const child of childs) {
                            vals.push(child.getAttribute('data-val'));
                        }
                        let inputElem = document.getElementById('a'+idx);
                        inputElem.value = vals.join(',');
                        inputElem.dispatchEvent(new Event('input'));
                    },
                    ghostClass: 'blue-background-class'
                };
                //this doesn't work :( ensure the dropped items are always sorted
                new Sortable(el, settings);
            });
        }); 
    </script>
@elseif (@$type === 'match' || @$type === 'match-x')
    @php
        if ($type === 'match-x') {
            $chinese_characters = mb_str_split($chinese_phrase) ?? [];
            $zhuyin_characters = explode(' ',$zhuyin) ?? [];
            $pinyin_characters = explode(' ',$pinyin) ?? [];
            $boxes = [];
            foreach ($zhuyin_characters as $i => $zhuyin_character) {
                $boxes[] = $zhuyin_character . '/' . ($pinyin_characters[$i] ?? '');
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
        $sortsrightgroup = 'sort-'.$idx.'-rightgroup';
    @endphp
        <span>Q{{ ($idx+1) }}.</span>
    <!--<div class="grid w-full gap-6 md:grid-cols-2"> -->
        <div>
            <div id="{{$sortsleft[0]}}" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 justify-left min-h-18 mt-2">
            @foreach($matchwords as $i => $word)
                <div data-val="{{($i+1)}}" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" style="z-index:1; opacity:75%;"><span>{{($i+1)}}. {{$word}}</span></div>
            @endforeach
            </div>
        </div>
        <div id="{{$sortsrightgroup}}" class="flex justify-right">
            @foreach($matchboxes as $i => $box)
            @php
                $sortsright[] = 'sort-'.$idx.'-right'.$i;
            @endphp
                <div id="{{$sortsright[$i]}}" data-rel="{{$rel}}" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 mr-2 h-full w-full space-x-1 justify-center min-h-18 mt-2"><span style="position:absolute; opacity: 50%;" class="px-6 py-0 filtered">{{$box}}</span></div>
            @endforeach
        </div>
    <!-- </div> -->
    <script>
        document.addEventListener('alpine:init', () => {
            let elemIDArr = @json($sortsleft);
            let sortsRightGroup = "{{$sortsrightgroup}}";
            let settings = {
                animation: 150,
                group: {
                    name: 'origin',
                    sort: false,
                },
                onEnd: function (evt) {
                    let parent = document.getElementById(sortsRightGroup);
                    let childs = parent.getElementsByClassName('list-group');
                    let idx = "{{$idx}}";
                    let vals = [];
                    for (const child of childs) {
                        let buttons = child.getElementsByClassName('list-group-item');
                        let val = 0;
                        if (buttons !== null && buttons.length == 1) { 
                            val = parseInt(buttons[0].getAttribute('data-val'));
                        }
                        vals.push(val);
                    }
                    let inputElem = document.getElementById('a'+idx);
                    inputElem.value = vals.join(',');
                    inputElem.dispatchEvent(new Event('input'));
                },
                ghostClass: 'blue-background-class'
            };
            elemIDArr.forEach(function(elemID, i) {
                let el = document.getElementById(elemID);
                new Sortable(el, settings);
            });
            elemIDArr = @json($sortsright);
            settings.filter = 'filtered';
            settings.group.put = function (to) {
                return to.el.children.length <= 1;
            }
            elemIDArr.forEach(function(elemID, i) {
                let el = document.getElementById(elemID);
                new Sortable(el, settings);
            });
        }); 
    </script>
@else
    <span>invalid question type</span>
@endif
</flux:fieldset>