<section>
    <form method="POST" wire:submit="store" class="flex flex-col max-w-md mx-auto gap-6 bg-slate-900 shadow-2xl rounded-2xl p-4">
        <flux:select wire:model="form.type" :filter="false" label="Module Type">
            <flux:select.option value="" wire:key="">select a lesson module type</flux:select.option>
            @foreach (\App\Models\LessonModule::VALID_LESSON_MODULE_TYPES as $type)
                <flux:select.option value="{{ $type }}" wire:key="{{ $type }}">{{ ucfirst($type) }}</flux:select.option>
            @endforeach
        </flux:select>
        <flux:select wire:model="form.lesson_id" :filter="false" label="Lesson">
            <flux:select.option value="" wire:key="">Select a lesson</flux:select.option>
            @foreach ($this->lessons as $lesson)
                <flux:select.option value="{{ $lesson->id }}" wire:key="{{ $lesson->id }}">
                    {{ $lesson->title }}
                </flux:select.option>
            @endforeach
        </flux:select>
        <flux:textarea
            wire:model="form.question"
            label="Question"
            type="text"
            rows="4"
            placeholder="question"
        />
        <flux:input
            wire:model="form.answer_key"
            label="Answer Key"
            type="text"
            autofocus
            placeholder="answer key"
        />
        <flux:input
            wire:model="form.weight"
            label="Weight"
            type="text"
            autofocus
            placeholder="weight"
        />
        <flux:textarea
            wire:model="form.note"
            label="Note"
            type="text"
            rows="4"
            placeholder="note"
        />
        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">
                {{ 'Create Lesson Module' }}
            </flux:button>
        </div>
    </form>
</section>