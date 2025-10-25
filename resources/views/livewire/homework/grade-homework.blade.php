<section>
<div class="space-y-6 p-3">
    <flux:heading size="xl">{{ @App\Models\Lesson::find($form->lesson_id)->title }}</flux:heading>
    <flux:heading size="lg">Student: {{ @App\Models\Student::find($form->student_id)->name }}</flux:heading>
</div>
<div class="overflow-y-auto overflow-x-hidden top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 max-w-3xl max-h-full">
@php
    $answers = $form->answers ?? [];
    //dd($answers);
    $counter = 0;
@endphp
@forelse ($answers as $i => $answer)
@php
    $lessonmodule = @$lessonmodules[$i];
    $counter++;
@endphp
    <div class="space-y-6 p-3 section">
        @include('partials.homework.homework-grade-module',['type' => $lessonmodule->type, 'question' => $lessonmodule->question, 'answer' => $answer, 'index' => $counter, 'rel' => $lessonmodule->id, 'homework_id' => $i])
    </div>
@empty
    <span>no answer found</span>
@endforelse
</div>
<div class="">
    <form method="PUT" wire:submit="update">
        @foreach (@$lessonmodules as $key => $lessonmodule)
            <flux:input
                class="hidden"
                id="a{{$lessonmodule->id}}"
                wire:model="form.answers.{{$lessonmodule->id}}"
                type="text"
                placeholder="student's answer"
            />
            <flux:input
                class="hidden"
                id="g{{$lessonmodule->id}}"
                wire:model="form.gradings.{{$lessonmodule->id}}"
                type="text"
                placeholder="teacher's comment"
            />
        @endforeach
        <flux:input id="student-id" type="text" wire:model="form.student_id" class="hidden" />
        <flux:input id="lesson-id" type="text" wire:model="form.lesson_id" class="hidden" />
        <button id="submit-btn" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-md px-8 py-4 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Grade Homework</button>
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
</section>
