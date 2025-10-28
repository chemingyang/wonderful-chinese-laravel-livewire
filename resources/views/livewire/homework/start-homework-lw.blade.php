<section>
<div class="space-y-6 p-3">
    <flux:heading size="xl">{{ @$lesson_title }}</flux:heading>
</div>
<div id="main-content" class="overflow-y-auto overflow-x-hidden top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 max-w-3xl max-h-full">
    @if ($index == 0)
    <div id="prompt-0" class="space-y-6 p-3 section">
        <flux:heading size="xl">Hi {{$student_name}}. Are you ready to begin this lesson?</flux:heading>
    </div>
    <div id="qa-0" class="space-y-6 p-3 section">
        <flux:heading size="md">Please click "Next" to start.</flux:heading>
    </div>
    @elseif ($index > 0 && $index <= $maxindex)
    @php
        $lessonmodule = $lessonmodules[($index - 1)];
    @endphp
    <div id="prompt-{{$index}}" class="space-y-6 p-3 section">
        <flux:heading size="lg">{{ $lessonmodule->prompt }} </flux:heading>
    </div>
    <div id="qa-{{$index}}" class="space-y-6 p-3 section">
        @include('partials.homework.homework-start-module-lw',['type' => $lessonmodule->type, 'question' => $lessonmodule->question, 'index' => $index, 'rel' => $lessonmodule->id])
    </div>
    @else
    <div id="prompt-{{$maxindex}}" class="space-y-6 p-3 section">
        <flux:heading size="xl">Your have reached the end of the questions. </flux:heading>
    </div>
    <div id="qa-{{$maxindex}}" class="space-y-6 p-3 section">
        <flux:heading size="md">Would you like to hand in your homework now?</flux:heading>
    </div>
    @endif
    <flux:separator class="my-4"/>
    <div class="space-y-6 p-3">
        <flux:button id="previous-btn" wire:click="prevStep" wire:loading.class="opacity-50" variant="filled" class="w-2xs">
            <span wire:loading.remove>Previous</span>
            <span wire:loading>
                Loading..
            </span>
        </flux:button>
        <flux:button id="next-btn" wire:click="nextStep" wire:loading.class="opacity-50" variant="primary" class="w-2xs float-end">
            <span wire:loading.remove>Next</span>
            <span wire:loading>
                Loading..
            </span>
        </flux:button>
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
    @include('partials.message-modal')
</div>
<div>
    <form method="POST" wire:submit="store">
    <flux:input id="student-id" type="text" wire:model="form.student_id" />
    <flux:input id="lesson-id" type="text" wire:model="form.lesson_id" />
    <flux:input id="started-at" type="text" wire:model="form.started_at" />
    <button id="submit-btn" type="submit" class="hidden text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-md px-8 py-4 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit Homework</button>
    </form>
</div>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<script>
</script>
</section>