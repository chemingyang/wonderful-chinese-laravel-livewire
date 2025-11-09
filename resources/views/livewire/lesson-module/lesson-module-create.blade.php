<section>
    <form method="POST" wire:submit="store" class="flex flex-col max-w-md mx-auto gap-6 bg-slate-900 shadow-2xl rounded-2xl p-4">
        <flux:select wire:model="form.type" :filter="false" label="Module Type">
            <flux:select.option value="" wire:key="">select a lesson module type</flux:select.option>
            @foreach (array_keys(\App\Models\LessonModule::VALID_LESSON_MODULE_TYPES) as $type)
                <flux:select.option value="{{ $type }}" wire:key="{{ $type }}">{{ ucfirst($type) }}</flux:select.option>
            @endforeach
        </flux:select>
        <flux:select wire:model.live="form.lesson_id" :filter="false" label="Lesson">
            <flux:select.option value="" wire:key="">Select a lesson</flux:select.option>
            @foreach ($this->lessons as $lesson)
                <flux:select.option value="{{ $lesson->id }}" wire:key="{{ $lesson->id }}">
                    {{ $lesson->title }}
                </flux:select.option>
            @endforeach
        </flux:select>
        <flux:select wire:model="form.character_id" :filter="false" label="Character" :disabled="!$this->form->lesson_id">
            <flux:select.option value="" wire:key="">Select a character (optional)</flux:select.option>
            @if ($this->form->lesson_id)
                @foreach ($this->characters as $character)
                    <flux:select.option value="{{ $character->id }}" wire:key="{{ $character->id }}">
                        {{ $character->chinese_phrase }} ({{ $character->pinyin }})
                    </flux:select.option>
                @endforeach
            @else
                <flux:select.option value="" wire:key="">Please select a lesson first</flux:select.option>
            @endif
        </flux:select>
        <flux:input
            wire:model="form.audio"
            label="Audio"
            type="file"
            accept="audio/*" 
        />
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
        <flux:select wire:model.live="weightSelect" :filter="false" label="Weight">
            <flux:select.option value="" wire:key="">Select weight</flux:select.option>
            @for ($i = 1; $i <= 20; $i++)
                <flux:select.option value="{{ $i }}" wire:key="{{ $i }}">{{ $i }}</flux:select.option>
            @endfor
            <flux:select.option value="other" wire:key="other">Other</flux:select.option>
        </flux:select>
        @if ($weightSelect === 'other')
            <flux:input
                wire:model="form.weight"
                label="Custom Weight"
                type="number"
                min="1"
                placeholder="Enter weight"
            />
        @endif
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