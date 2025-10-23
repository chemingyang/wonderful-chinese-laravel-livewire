<section>
<div class="space-y-6 p-3">
    <flux:heading size="xl">{{ @$lesson->title }}</flux:heading>
</div>
<div id="static-modal" data-modal-backdrop="static" tabindex="-1" class="overflow-y-auto overflow-x-hidden top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 max-w-3xl max-h-full">
    @php
        $moduleCount = count($lessonmodules);
    @endphp
    @forelse (@$lessonmodules as $index => $lessonmodule)
    <div id="prompt-{{$index}}" class="space-y-6 p-3 section hidden">
        <flux:heading size="lg">{{ $lessonmodule->prompt }} </flux:text>
    </div>
    <div id="qa-{{$index}}" class="space-y-6 p-3 section hidden">
        @include('partials.homework.homework-module-question',['type' => $lessonmodule->type, 'question' => $lessonmodule->question, 'index' => $index, 'rel' => $lessonmodule->id])
    </div>
    @empty
    @endforelse
    <flux:separator class="my-4"/>
    <div class="space-y-6 p-3">
        <flux:button id="previous-btn" variant="ghost" class="w-2xs" data-incr="-1">Previous</flux:button>
        <flux:button id="next-btn" variant="primary" class="w-2xs float-end" data-incr="1">Next</flux:button>
    </div>
</div>
<div>
    <span>hidden form not supposed to see this</span>
    <form method="POST" wire:submit="store">
        @foreach (@$lessonmodules as $key => $lessonmodule)
            <flux:input
                class="answers hidden"
                id="a{{$key}}"
                wire:model="form.answers.{{$lessonmodule->id}}"
                data-question="{{ $lessonmodule->question }}"
                data-type="{{ $lessonmodule->type }}"
                data-id="{{$lessonmodule->id}}"
                type="text"
                placeholder="your answer"
            />
        @endforeach
        <flux:input id="student-id" type="text" wire:model="form.student_id" class="hidden" />
        <flux:input id="lesson-id" type="text" wire:model="form.lesson_id" class="hidden"/>
        <button id="submit-button" type="submit" class="hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-md px-8 py-4 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit Homework</button>
    </form>
</div>
<script>
    var currentIndex = null;

    function setSection(currentidx) {
        for (const section of document.getElementById('static-modal').getElementsByClassName('section')) {
            section.classList.add('hidden');
        }
        document.getElementById('prompt-'+currentidx).classList.remove('hidden');
        document.getElementById('qa-'+currentidx).classList.remove('hidden');

        /* add some visual cues to the previous and next button when reaching edges */

        /* if (currentIndex == 0) {
            document.getElementById('previous-btn').classList.add('hidden');
            document.getElementById('next-btn').classList.remove('hidden');
        } else if (currentIndex == 4) {
            document.getElementById('previous-btn').classList.remove('hidden');
            document.getElementById('next-btn').classList.add('hidden');
        } else {
            document.getElementById('previous-btn').classList.remove('hidden');
            document.getElementById('next-btn').classList.remove('hidden');
        }*/
    }

    function handleClick(evt) {
        let incr = this.getAttribute('data-incr');
        let prevIndex = currentIndex;
        let moduleCount = {{$moduleCount}};
        currentIndex += parseInt(incr);
        if (currentIndex >= 0 && currentIndex < moduleCount) {
            setSection(currentIndex);
        } else {
            currentIndex = prevIndex;
        }
    }

    document.getElementById('previous-btn').addEventListener('click', handleClick);
    document.getElementById('next-btn').addEventListener('click', handleClick);

    document.addEventListener('DOMContentLoaded', () => {
        currentIndex = 0;
        setSection(currentIndex);
    });
</script>
</section>