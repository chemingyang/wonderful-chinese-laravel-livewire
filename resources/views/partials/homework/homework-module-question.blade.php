<flux:fieldset>
@if (@$type === 'fill-in-blank')
    <div>{!! str_replace('<>','<input type="text" class="inline border-1 border-color:#fff" style="width:80px; padding:5px; margin:5px" name="" data-rel="a" />',$question); !!}</div>
@elseif (@$type === 'answer-question')
    <flux:text class="mt-2" size="md">Q{{ $idx }}. {{ $question }} </flux:text>
    <flux:textarea rows="10" columns="35" label="Answer:" />
@elseif (@$type === 'sort')
    <div class="list-group flex" id="sort{{ $idx }}">
        <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><span>1. item 1</span></div>        
        <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><span>2. item 2</span></div>        
        <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><span>3. item 3</span></div>        
        <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><span>4. item 4</span></div>        
    </div>
    <script>
    /*
    document.addEventListener('DOMContentLoaded', () => {
        let elemID = 'sort'+{{ $idx }};
        let el = document.getElementById(elemID);
        new Sortable(el, {
            animation: 150,
            group: {
                name: 'shared'
            },
            ghostClass: 'blue-background-class'
        });
    }); */
    </script>
@elseif (@$type === 'drop')
    <div class="grid w-full gap-6 md:grid-cols-2">
        <div id="sort-{{ $idx }}-left" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 justify-left">
            <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><span>item 1</span></div>
            <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><span>item 2</span></div>
            <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><span>item 3</span></div>
            <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><span>item 4</span></div>
        </div>
        <div>
            <label>Family</label>
            <div id="sort-{{ $idx }}-right" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 justify-right">
                <label>&nbsp;</label>
            </div>
        </div>
    </div>
    <script>
        /* document.addEventListener('DOMContentLoaded', () => {
            let elemIDArr = ['sort-'+{{ $idx }}+'-left', 'sort-'+{{ $idx }}+'-right'];
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
        }); */
    </script>
@elseif (@$type === 'match')
    <div class="grid w-full gap-6 md:grid-cols-2">
        <div id="sort-2-left" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1 justify-left">
            <d&nbsp;
&nbsp;
&nbsp;iv data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><span>item 1</span></div>
            <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><span>item 2</span></div>
            <div data-val="" data-rel="" class="list-group-item focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 m-1 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><span>item 3</span></div>
        </div>
        <div class="flex justify-right">
            <div><label>Box1</label><div id="sort-2-right-1" data-val="{{ $idx }}" data-rel="" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1"><label>&nbsp;&nbsp;&nbsp;</label></div></div>
            <div><label>Box2</label><div id="sort-2-right-2" data-val="{{ $idx }}" data-rel="" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1"><label>&nbsp;&nbsp;&nbsp;</label></div></div>
            <div><label>Box3</label><div id="sort-2-right-3" data-val="{{ $idx }}" data-rel="" class="flex list-group border border-gray-200 rounded-lg cursor-pointer p-1"><label>&nbsp;&nbsp;&nbsp;</label></div></div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            le&nbsp;
&nbsp;
&nbsp;t elemIDArr = ['sort-2-left','sort-2-right-1','sort-2-right-2','sort-2-right-3'];
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
@else
    <span>invalid question type</span>
@endif
</flux:fieldset>