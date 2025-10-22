<flux:fieldset>
@if (@$type === 'fill-in-blank')
    <div>Q{{ ($index) }}.{!! str_replace('<>','<input type="text" class="inline border-1 border-color:#fff" style="width:80px; padding:5px; margin:5px" name="" data-rel="{{$rel}}" />',$question); !!}</div>
@elseif (@$type === 'answer-question')
    <label>Q{{ ($index) }}. {{ $question }}</label>
    <flux:textarea rows="10" columns="35" data-rel="{{$rel}}" />
@elseif (@$type === 'sort')
    @php
        $words = explode('|',$question);
        $sorts = ['sort-'.$index];
    @endphp
    <div id="{{$sorts[0]}}" data-rel="{{$rel}}" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 mt-2 min-h-18" id="sort0">
    @foreach ($words as $i => $word)
        <div data-val="{{($i+1)}}" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" style="z-index:1; opacity:75%;"><span>{{$word}}</span></div>
    @endforeach
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            elemIDArr = {!! json_encode( $sorts) !!};
            elemIDArr.forEach(function(elemID, index) {
                let el = document.getElementById(elemID);
                new Sortable(el, {
                    animation: 150,
                    group: {
                        name: 'shared'
                    },
                    ghostClass: 'blue-background-class'
                });
            });
        });
    </script>
@elseif (@$type === 'drop')
    @php
        $qparts = explode(':',$question);
        $prompt = $qparts[0];
        $words = explode('|',$qparts[1]);
        $sorts = ['sort-'.$index.'-left','sort-'.$index.'-right'];
    @endphp
    <!--<div class="grid w-full gap-6 md:grid-cols-2"> -->
        <div id="{{$sorts[0]}}" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 justify-left min-h-18 mt-2" >
        @foreach ($words as $i => $word)
            <div data-val="{{($i+1)}}" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" style="z-index:1; opacity:75%;"><span class="p-1">{{$word}}</span></div>
        @endforeach
        </div>
        <div id="{{$sorts[1]}}" data-rel="{{$rel}}" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 h-full w-full space-x-1 justify-center min-h-18 mt-2">
            <span style="position:absolute; opacity: 50%;" class="px-6 py-0 filtered">{{$prompt}}</span>
        </div>
    <!-- </div> -->
    <script> /*
        document.addEventListener('DOMContentLoaded', () => {
            elemIDArr = {!! json_encode($sorts) !!};
            elemIDArr.forEach(function(elemID, index) {
                let el = document.getElementById(elemID);
                new Sortable(el, {
                    animation: 150,
                    group: {
                        name: 'shared'
                    },
                    ghostClass: 'blue-background-class'
                });
            });
        });*/
    </script>
@elseif (@$type === 'match')
    @php
        $qparts = explode(':',$question);
        $words = explode('|',$qparts[0]);
        $boxes = explode('|',$qparts[1]);
        $sortsleft = ['sort-'.$index.'-left'];
        $sortsright = [];
    @endphp
    <!--<div class="grid w-full gap-6 md:grid-cols-2"> -->
        <div>
            <div id="{{$sortsleft[0]}}" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 justify-left min-h-18 mt-2">
            @foreach($words as $i => $word)
                <div data-val="{{($i+1)}}" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" style="z-index:1; opacity:75%;"><span>{{$word}}</span></div>
            @endforeach
            </div>
        </div>
        <div class="flex justify-right">
            @foreach($boxes as $i => $box)
            @php
                $sortsright[] = 'sort-'.$index.'-right'.$i;
            @endphp
                <div id="{{$sortsright[$i]}}" data-rel="{{$rel}}" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 mr-2 h-full w-full space-x-1 justify-center min-h-18 mt-2"><span style="position:absolute; opacity: 50%;" class="px-6 py-0 filtered">{{$box}}</span></div>
            @endforeach
        </div>
    <!-- </div> -->
    <script>/*
        document.addEventListener('DOMContentLoaded', () => {
            elemIDArr = {!! json_encode($sortsleft) !!};
            elemIDArr.forEach(function(elemID, index) {
                let el = document.getElementById(elemID);
                new Sortable(el, {
                    animation: 150,
                    group: {
                        name: 'origin',
                        sort: false,
                    },
                    ghostClass: 'blue-background-class'
                });
            });
            elemIDArr = {!! json_encode($sortsright) !!};
            elemIDArr.forEach(function(elemID, index) {
                let el = document.getElementById(elemID);
                new Sortable(el, {
                    animation: 150,
                    group: {
                        name: 'origin',
                        put: function (to) {
                            return to.el.children.length <= 1;
                        },
                    },
                    filter: '.filtered',
                    ghostClass: 'blue-background-class'
                });
            });
        }); */
    </script>
@else
    <span>invalid question type</span>
@endif
</flux:fieldset>