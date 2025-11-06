<section>
<script src="{{ asset('js/start-homework.js') }}"></script>
<style src="{{ asset('css/start-homework.css') }}"></style>
<div class="space-y-6 p-3">
    <flux:heading size="xl" x-text="$wire.lesson_title"></flux:heading>
</div>
<div wire:cloak x-data="{ indx: @entangle('index'), maxindx: @js($maxindex) }" id="main-content" class="overflow-y-auto overflow-x-hidden top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 max-w-3xl max-h-full">
    <div x-show="indx == -1">
        <div id="prompt--1" class="space-y-6 p-3 section">
            <flux:heading size="lg">Hi <span x-text="$wire.student_name"><span>! Are you ready to begin this lesson?</flux:heading>
        </div>
        <div id="qa--1" class="space-y-6 p-3 section">
            <flux:heading size="lg">Please click "Next" to start.</flux:heading>
        </div>
    </div>
    @foreach ($lessonmodules as $idx => $lessonmodule)
    <div x-data="{ idx: @js($idx) }" x-show="indx === idx">
        <div id="prompt-{{$idx}}" class="space-y-6 p-3 section inline-block">
            <flux:heading size="xl">{{ $lessonmodule->prompt }} </flux:heading>
        </div>
        <div id="qa-{{$idx}}" class="space-y-6 p-3 section">
            <template x-if="indx === idx">
            @include('partials.homework.homework-start-module-lw',['type' => $lessonmodule->type, 'question' => $lessonmodule->question, 'answer' => $form->answers[(string)$lessonmodule->id] ?? '', 'idx' => $idx, 'rel' => $lessonmodule->id, 'chinese_phrase' => $lessonmodule->chinese_phrase, 'zhuyin' => $lessonmodule->zhuyin, 'pinyin' => $lessonmodule->pinyin, 'audio' => $lessonmodule->audio])
            </template>
            <flux:input id="a{{$idx}}" wire:key="answers.{{$lessonmodule->id}}" type="text" wire:model.defer="form.answers.{{$lessonmodule->id}}" class="hidden" />
        </div>
    </div>
    @endforeach
    <div x-show="maxindx === indx">
        <div id="prompt-{{$maxindex}}" class="space-y-6 p-3 section">
            <flux:heading size="xl">Your have reached the end of the questions. </flux:heading>
        </div>
        <div id="qa-{{$maxindex}}" class="space-y-6 p-3 section">
            <flux:heading size="md">Would you like to hand in your homework now?</flux:heading>
        </div>
    </div>
    <flux:separator class="my-4"/>
    <div class="space-y-6 p-3">
        <flux:button wire:click="saveStep(-1)" x-show="indx > -1 && indx < maxindx" wire:loading.class="opacity-50" variant="filled" class="w-5xs">
            Previous
        </flux:button>
        <flux:button wire:click="saveStep(1)" x-show="indx > -1 && indx < maxindx" wire:loading.class="opacity-50" variant="primary" class="w-5xs mt-2 float-end"> 
            <span wire:loading.remove>Next</span>
            <span wire:loading>
                Loading..
            </span>
        </flux:button>
    </div>
    <div>
        <flux:input wire:key="student_id" type="text" wire:model="form.student_id" class="hidden"/>
        <flux:input wire:key="lesson_id" type="text" wire:model="form.lesson_id" class="hidden" />
        <flux:input wire:key="started_at" type="text" wire:model="form.started_at" class="hidden" />
        <flux:input wire:key="submitted_at" type="text" wire:model="form.submitted_at" class="hidden" />
        <flux:button wire:click="saveStep(1)" x-show="indx === maxindx" wire:loading.class="opacity-50" variant="primary" class="w-2xs mt-2 float-end"> 
            <span wire:loading.remove>Submit</span>
            <span wire:loading>
                Loading..
            </span>
        </flux:button>
        <flux:button wire:click="saveStep(1)" x-show="indx === -1" wire:loading.class="opacity-50" variant="primary" class="w-2xs mt-2"> 
            <span wire:loading.remove>Begin Lesson</span>
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