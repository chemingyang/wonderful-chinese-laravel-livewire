<section>
<div class="space-y-6 p-3">
    <flux:heading size="xl">{{ @$lesson->title }}</flux:heading>
</div>
<div id="static-modal" data-modal-backdrop="static" tabindex="-1" class="overflow-y-auto overflow-x-hidden top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 max-w-3xl max-h-full">
    @forelse (@$lessonmodules as $index => $lessonmodule)
    <div class="space-y-6 p-3">
        <flux:heading size="lg">{{ $lessonmodule->prompt }} </flux:text>
    </div>
    <div class="space-y-6 p-3">
        @include('partials.homework.homework-module-question',['type' => $lessonmodule->type, 'question' => $lessonmodule->question, 'idx' => $index + 1 ])
    </div>
    <flux:separator class="my-4"/>
    @empty
    @endforelse
    <div class="space-y-6 p-3">
        <flux:button variant="ghost" class="w-2xs">Previous</flux:button>
        <flux:button variant="primary" class="w-2xs float-end">Next</flux:button>
    </div>
<div>
</section>
<script>
    /*
    function initSort(elemIDArr) {
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
    }
    document.addEventListener('DOMContentLoaded', () => {
        // console.log('DOM is loaded! livewire initialized');
        //document.getElementById('start-homework').show();
    });
    */
</script>