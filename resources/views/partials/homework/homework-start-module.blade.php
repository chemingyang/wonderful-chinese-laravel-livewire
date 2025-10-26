<flux:fieldset>
@if (@$type === 'fill-in-blank')
    <div id="q{{$index}}" data-rel="{{$rel}}">Q{{ ($index+1) }}.{!! str_replace('<>','<input type="text" class="data-target inline border-1 border-color:#fff" style="width:80px; padding:5px; margin:5px" />',$question); !!}</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let rel = "{{$rel}}";
        let idx = "{{$index}}";
        let data_rel = document.getElementById('q'+idx);
        data_rel.addEventListener('change', function(event) {
            let childs = this.children;
            let vals = [];
            for (const child of childs) {
                vals.push(child.value);
            }
            let inputElem = document.getElementById('a'+idx);
            inputElem.value = vals.join(',');
            inputElem.dispatchEvent(new Event('input'));
        });
    });
</script>
@elseif (@$type === 'answer-question')
    <span>Q{{ ($index+1) }}. {{ $question }}</span>
    <div id="q{{$index}}" data-rel="{{$rel}}"><flux:textarea rows="10" columns="35" />
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let rel = "{{$rel}}";
        let idx = "{{$index}}";
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
        $sorts = ['sort-'.$index];
    @endphp
    <span>Q{{ ($index+1) }}.</span>
    <div id="{{$sorts[0]}}" data-rel="{{$rel}}" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 mt-2 min-h-18">
    @foreach ($sortwords as $i => $word)
        <div data-val="{{($i+1)}}" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" style="z-index:1; opacity:75%;"><span>{{($i+1)}}. {{$word}}</span></div>
    @endforeach
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let elemIDArr = {!! json_encode($sorts) !!};
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
                        let idx = "{{$index}}";
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
        $drops = ['sort-'.$index.'-left','sort-'.$index.'-right'];
    @endphp
        <span>Q{{ ($index+1) }}.</span>
    <!--<div class="grid w-full gap-6 md:grid-cols-2"> -->
        <div id="{{$dropsorts[0]}}" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 justify-left min-h-18 mt-2" >
        @foreach ($dropwords as $i => $word)
            <div data-val="{{($i+1)}}" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" style="z-index:1; opacity:75%;"><span class="p-1">{{($i+1)}}. {{$word}}</span></div>
        @endforeach
        </div>
        <div id="{{$sorts[1]}}" data-rel="{{$rel}}" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 h-full w-full space-x-1 justify-center min-h-18 mt-2">
            <span style="position:absolute; opacity: 50%;" class="px-6 py-0 filtered">{{$prompt}}</span>
        </div>
    <!-- </div> -->
    <script> 
        document.addEventListener('DOMContentLoaded', () => {
            let elemIDArr = {!! json_encode($drops) !!};
            
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
                        let idx = "{{$index}}";
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
                /* if (i == 1) {
                    settings.sort = false;
                }*/
                new Sortable(el, settings);
            });
        });
    </script>
@elseif (@$type === 'match')
    @php
        $matchparts = explode(':',$question);
        $matchwords = explode('|',$matchparts[1]);
        $matchboxes = explode('|',$matchparts[0]);
        $sortsleft = ['sort-'.$index.'-left'];
        $sortsright = [];
        $sortsrightgroup = 'sort-'.$index.'-rightgroup'
    @endphp
        <span>Q{{ ($index+1) }}.</span>
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
                $sortsright[] = 'sort-'.$index.'-right'.$i;
            @endphp
                <div id="{{$sortsright[$i]}}" data-rel="{{$rel}}" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 mr-2 h-full w-full space-x-1 justify-center min-h-18 mt-2"><span style="position:absolute; opacity: 50%;" class="px-6 py-0 filtered">{{$box}}</span></div>
            @endforeach
        </div>
    <!-- </div> -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let elemIDArr = {!! json_encode($sortsleft) !!};
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
                    let idx = "{{$index}}";
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
            elemIDArr = {!! json_encode($sortsright) !!};
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