<section>
<div class="space-y-6 p-3">
    <flux:heading size="xl">{{ @$lesson_title }}</flux:heading>
</div>
<div id="main-content" class="overflow-y-auto overflow-x-hidden top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 max-w-3xl max-h-full">
    @php
        $moduleCount = count($lessonmodules);
    @endphp
    @forelse (@$lessonmodules as $index => $lessonmodule)
    <div id="prompt-{{$index}}" class="space-y-6 p-3 section hidden">
        <flux:heading size="lg">{{ $lessonmodule->prompt }} </flux:heading>
    </div>
    <div id="qa-{{$index}}" class="space-y-6 p-3 section hidden">
        @include('partials.homework.homework-module-question',['type' => $lessonmodule->type, 'question' => $lessonmodule->question, 'index' => $index, 'rel' => $lessonmodule->id])
    </div>
    @empty
    @endforelse
    <div id="prompt-{{$index+1}}" class="space-y-6 p-3 section hidden">
        <flux:heading size="lg">Your have reached the end of the questions. </flux:heading>
    </div>
    <div id="qa-{{$index+1}}" class="space-y-6 p-3 section hidden">
        <flux:heading size="sm">Would you like to hand in your homework now?</flux:heading>
    </div>
    <flux:separator class="my-4"/>
    <div class="space-y-6 p-3">
        <flux:button id="previous-btn" variant="filled" class="w-2xs" data-incr="-1">Previous</flux:button>
        <flux:button id="next-btn" variant="primary" class="w-2xs float-end" data-incr="1">Next</flux:button>
    </div>
</div>
<div>
    <form method="POST" wire:submit="store">
        @foreach (@$lessonmodules as $key => $lessonmodule)
            <flux:input
                class="answers"
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
        <button id="submit-btn" type="submit" class="hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-md px-8 py-4 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit Homework</button>
    </form>
</div>
<script>
    var currentIndex = null;

    function setSection(currentidx) {
        for (const section of document.getElementById('main-content').getElementsByClassName('section')) {
            section.classList.add('hidden');
        }
        document.getElementById('prompt-'+currentidx).classList.remove('hidden');
        document.getElementById('qa-'+currentidx).classList.remove('hidden');
        let moduleCount = {{$moduleCount}};
        /* add some visual cues to the previous and next button when reaching edges */
        if (currentIndex == moduleCount) {
            document.getElementById('submit-btn').classList.remove('hidden');
            document.getElementById('next-btn').style.opacity = '25%';
        } else if (currentIndex == 0) {
            document.getElementById('previous-btn').style.opacity = '25%';
        } else {
            document.getElementById('submit-btn').classList.add('hidden');
            document.getElementById('next-btn').style.opacity = '100%';
            document.getElementById('previous-btn').style.opacity = '100%';
        }
    }

    function handleClick(evt) {
        let incr = this.getAttribute('data-incr');
        let prevIndex = currentIndex;
        let moduleCount = {{$moduleCount}};
        /* disallow 'next' click if the answers are empty */
        if (this.id == 'next-btn') {
            let currentInputValue = document.getElementById('a'+currentIndex).value;
            if (currentInputValue == null || currentInputValue == "") {
                alert('empty value not allowed');
                return;
            }
        }
        currentIndex += parseInt(incr);
        /* set the student-id, and lesson-id inputs upon the last step reached; cannot do this in page load somehow*/
        if (currentIndex == moduleCount) {
            let lesson_id = {{$lesson_id}};
            let student_id = {{$student_id}};
            let lesson_id_input = document.getElementById('lesson-id');
            lesson_id_input.value = lesson_id;
            lesson_id_input.dispatchEvent(new Event('input'));
            let student_id_input = document.getElementById('student-id');
            student_id_input.value = student_id;
            student_id_input.dispatchEvent(new Event('input')); 
        }

        if (currentIndex >= 0 && currentIndex <= moduleCount) {
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