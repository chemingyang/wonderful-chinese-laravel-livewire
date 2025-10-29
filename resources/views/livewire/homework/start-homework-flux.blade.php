<section>
<div class="space-y-6 p-3">
    <flux:heading size="xl">{{ @$lesson_title }}</flux:heading>
</div>
<div id="main-content" class="overflow-y-auto overflow-x-hidden top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 max-w-3xl max-h-full">
    @php
        $moduleCount = count($lessonmodules);
        $index = 0;
    @endphp
    <div id="prompt--1" class="space-y-6 p-3 section hidden">
        <flux:heading size="xl">Hi {{Auth::user()->name}}. Are you ready to begin this lesson?</flux:heading>
    </div>
    <div id="qa--1" class="space-y-6 p-3 section hidden">
        <flux:heading size="md">Please click "Begin Homework" to start.</flux:heading>
    </div>
    @foreach (@$lessonmodules as $index => $lessonmodule)
    <div id="prompt-{{$index}}" class="space-y-6 p-3 section hidden">
        <flux:heading size="lg">{{ $lessonmodule->prompt }} </flux:heading>
    </div>
    <div id="qa-{{$index}}" class="space-y-6 p-3 section hidden">
        @include('partials.homework.homework-start-module',['type' => $lessonmodule->type, 'question' => $lessonmodule->question, 'index' => $index, 'rel' => $lessonmodule->id])
    </div>
    @endforeach
    <div id="prompt-{{$index+1}}" class="space-y-6 p-3 section hidden">
        <flux:heading size="lg">Your have reached the end of the questions. </flux:heading>
    </div>
    <div id="qa-{{$index+1}}" class="space-y-6 p-3 section hidden">
        <flux:heading size="sm">Would you like to hand in your homework now?</flux:heading>
    </div>
    <flux:separator class="my-4"/>
    <div class="space-y-6 p-3">
        <flux:button id="previous-btn" variant="filled" class="w-2xs" data-incr="-1" style="display:none;">Previous</flux:button>
        <flux:button id="next-btn" variant="primary" class="w-2xs float-end" data-incr="1" style="display:none;">Next</flux:button>
    </div>
</div>
<flux:modal name="celebration" class="md:w-80" closable="false">
    <div class="space-y-6 p-3 section justify center">
        <img src="https://media.tenor.com/ZoZqWaSnN5UAAAAm/diwali-sparkles-stars.webp" width="200" height="200" alt="a bunch of colorful stars and sprinkles are flying in the air" style="margin: 0 auto; padding-top:15px;" loading="lazy">
    </div>
</flux:modal>
<flux:modal name="try-again" class="md:w-80" closable="false">
    <div class="space-y-6 p-3 section justify center">
        <img src="https://media.baamboozle.com/uploads/images/599509/1660662180_69405_gif-url.gif" width="200" height="198.5" alt="a bunch of colorful stars and sprinkles are flying in the air" style="margin: 0 auto; padding-top:15px; padding-right:10px;" loading="lazy">
    </div>
</flux:modal>
<div>
    <form method="POST" wire:submit="store">
        @foreach (@$lessonmodules as $key => $lessonmodule)
            <flux:input
                class="answers"
                id="a{{$key}}"
                wire:model="form.answers.{{$lessonmodule->id}}"
                data-question="{{ $lessonmodule->question }}"
                data-answer-key="{{ $lessonmodule->answer_key }}"
                data-type="{{ $lessonmodule->type }}"
                data-id="{{$lessonmodule->id}}"
                type="text"
                placeholder="your answer"
            />
        @endforeach
        <flux:input id="student-id" type="text" wire:model="form.student_id" class="" />
        <flux:input id="lesson-id" type="text" wire:model="form.lesson_id" class=""/>
        <button id="submit-btn" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-md px-8 py-4 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Begin Homework</button>
    </form>
</div>
<script>
    var currentIndex = null;

    function setSection() {
        // console.log('in secs:'+currentIndex);
        for (const section of document.getElementById('main-content').getElementsByClassName('section')) {
            section.classList.add('hidden');
        }
        let promptID = 'prompt-'+currentIndex;
        let qaID = 'qa-'+currentIndex;
        document.getElementById(promptID).classList.remove('hidden');
        document.getElementById(qaID).classList.remove('hidden');
        let moduleCount = "{{$moduleCount}}";
        /* add some visual cues to the previous and next button when reaching edges */
        if (currentIndex == moduleCount) {
            document.getElementById('submit-btn').classList.remove('hidden');
            document.getElementById('next-btn').style.opacity = '25%';
        } else if (currentIndex == 0) {
            document.getElementById('previous-btn').style.opacity = '25%';
            document.getElementById('submit-btn').innerText = "Submit Homework";
            document.getElementById('submit-btn').classList.add('hidden');
            document.getElementById('next-btn').style.display = 'inline-block';
            document.getElementById('previous-btn').style.display = 'inline-block';
        } else {
            //document.getElementById('submit-btn').classList.add('hidden');
            document.getElementById('next-btn').style.opacity = '100%';
            document.getElementById('previous-btn').style.opacity = '100%';
        }
    }

    function matchStrArr(str1, str2, type) {
        let arr1 = str1.split(',');
        let arr2 = str2.split(',');
        if (type == 'drop') {
            arr1.sort((a, b) => a - b);
            arr2.sort((a, b) => a - b);
        }
        return JSON.stringify(arr1) === JSON.stringify(arr2);
    }

    function handleClick(evt) {
        let incr = this.getAttribute('data-incr');
        let prevIndex = currentIndex;
        let moduleCount = "{{$moduleCount}}";
        /* disallow 'next' click if the answers are empty */
        if (this.id == 'next-btn' && currentIndex >= 0) {
            let currentInputValue = document.getElementById('a'+currentIndex).value;
            let currentAnswerKey = document.getElementById('a'+currentIndex).getAttribute('data-answer-key');
            let currentType = document.getElementById('a'+currentIndex).getAttribute('data-type');
            //console.log([currentInputValue+' - '+currentAnswerKey]);

            if (currentInputValue != null && currentInputValue != "" && 
                (currentAnswerKey == null || currentAnswerKey == "" || matchStrArr(currentInputValue, currentAnswerKey, currentType))) {
                Flux.modal('celebration').show();
                setTimeout(() => {
                    Flux.modal('celebration').close();
                }, "1000");
            } else {
                Flux.modal('try-again').show();
                setTimeout(() => {
                    Flux.modal('try-again').close();
                }, "1000");
                return;
            }
        }
        currentIndex += parseInt(incr);
        /* set the student-id, and lesson-id inputs upon the last step reached; cannot do this in page load somehow*/
        if (currentIndex == moduleCount) {
            let lesson_id = "{{$lesson_id}}";
            let student_id = "{{$student_id}}";
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
        currentIndex = parseInt("{{$currentindex}}");
        // console.log('in dom:'+currentIndex);
        setSection();
    });
</script>
</section>