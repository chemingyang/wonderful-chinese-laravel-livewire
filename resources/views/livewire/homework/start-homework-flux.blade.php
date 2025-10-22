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
        @include('partials.homework.homework-module-question',['type' => $lessonmodule->type, 'question' => $lessonmodule->question, 'index' => $index + 1, 'rel' => $lessonmodule->id])
    </div>
    <flux:separator class="my-4"/>
    @empty
    @endforelse
    <div class="space-y-6 p-3">
        <flux:button variant="ghost" class="w-2xs">Previous</flux:button>
        <flux:button variant="primary" class="w-2xs float-end">Next</flux:button>
    </div>
<div>
<div>
    <span>hidden form not supposed to see this</span>
    <form method="POST" wire:submit="store">
        @foreach (@$lessonmodules as $key => $lessonmodule)
            <flux:input
                class="answers"
                id="a{{$key}}"
                {{-- wire:model="form.answers.{{$lessonmodule->id}}" --}}
                data-question="{{ $lessonmodule->question }}"
                data-type="{{ $lessonmodule->type }}"
                data-id="{{$lessonmodule->id}}"
                type="text"
                placeholder="your answer"
            />
        @endforeach
        <flux:input id="student-id" type="text" wire:model="form.student_id" placeholder="student id" />
        <flux:input id="lesson-id" type="text" wire:model="form.lesson_id" placeholder="lesson id"/>
        <button id="submit-button" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-md px-8 py-4 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit Homework</button>
    </form>
</div>
<script>

</script>
</section>