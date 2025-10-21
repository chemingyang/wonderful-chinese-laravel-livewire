<flux:fieldset>
@if (@$type === 'fill-in-blank')
    <div>{!! str_replace('<>','<input type="text" class="inline border-1 border-color:#fff" style="width:80px; padding:5px; margin:5px" name="" data-rel="a" />',$question); !!}</div>
@elseif (@$type === 'answer-question')
    <flux:text class="mt-2" size="md">Q{{ $idx }}. {{ $question }} </flux:text>
    <flux:textarea rows="10" columns="35" label="Answer:" />
@elseif (@$type === 'sort')
    <div class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 h-full" id="sort0">
        <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" style="z-index:1; opacity:75%;"><span>1. item 1</span></div>
        <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" style="z-index:1; opacity:75%;"><span>2. item 2</span></div>
        <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" style="z-index:1; opacity:75%;"><span>3. item 3</span></div>
        <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" style="z-index:1; opacity:75%;"><span>4. item 4</span></div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let elemID = 'sort0';
            let el = document.getElementById(elemID);
            new Sortable(el, {
                animation: 150,
                group: {
                    name: 'shared'
                },
                ghostClass: 'blue-background-class'
            });
        });
    </script>
@elseif (@$type === 'drop')
    <div class="grid w-full gap-6 md:grid-cols-2">
        <div id="sort-1-left" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 justify-left h-full" >
            <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" style="z-index:1; opacity:75%;"><span class="p-1">item 1</span></div>
            <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" style="z-index:1; opacity:75%;"><span class="p-1">item 2</span></div>
            <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" style="z-index:1; opacity:75%;"><span class="p-1">item 3</span></div>
        </div>
        <div id="sort-1-right" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 h-full w-full space-x-1 justify-center">
            <span style="position:absolute; opacity: 50%;" class="px-6 py-0 filtered">box1</span>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            elemIDArr = ['sort-1-left','sort-1-right'];
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
@elseif (@$type === 'match')
    <div class="grid w-full gap-6 md:grid-cols-2">
        <div>
            <div id="sort-2-left" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 justify-left h-full">
                <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" style="z-index:1; opacity:75%;"><span>item 1</span></div>
                <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" style="z-index:1; opacity:75%;"><span>item 2</span></div>
                <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-6 py-4 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" style="z-index:1; opacity:75%;"><span>item 3</span></div>
            </div>
        </div>
        <div class="flex justify-right">
            <div id="sort-2-right-1" data-val="{{ $idx }}" data-rel="" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 mr-2 h-full w-full space-x-1 justify-center"><span style="position:absolute; opacity: 50%;" class="px-6 py-0 filtered">box1</span></div>
            <div id="sort-2-right-2" data-val="{{ $idx }}" data-rel="" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 mr-2 h-full w-full space-x-1 justify-center"><span style="position:absolute; opacity: 50%;" class="px-6 py-0 filtered">box2</span></div>
            <div id="sort-2-right-3" data-val="{{ $idx }}" data-rel="" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 mr-2 h-full w-full space-x-1 justify-center"><span style="position:absolute; opacity: 50%;" class="px-6 py-0 filtered">box3</span></div>
        </div>
    </div>
    <script>/*
        document.addEventListener('DOMContentLoaded', () => {
            elemIDArr = ['sort-2-left'];
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
            elemIDArr = ['sort-2-right-1','sort-2-right-2','sort-2-right-3'];
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