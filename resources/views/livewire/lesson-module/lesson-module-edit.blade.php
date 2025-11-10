<section>
    <form method="PUT" wire:submit="update" class="flex flex-col max-w-md mx-auto gap-6 bg-slate-900 shadow-2xl rounded-2xl p-4">
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
        @if ($form->lessonmodule->audio)
            <div class="flex items-center gap-2">
                <audio id="player-edit" src="{{ asset('storage/' . $form->lessonmodule->audio) }}"></audio>
                <flux:button size="xs" onclick="document.getElementById('player-edit').play()" class="p-0 border-0 bg-transparent">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 0 1 0 .656l-5.603 3.113a.375.375 0 0 1-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112Z" />
                    </svg>
                </flux:button>
                <span class="text-sm text-gray-400">Current audio</span>
            </div>
        @endif
        <flux:input
            wire:model="form.image"
            label="Image"
            type="file"
            accept="image/*" 
        />
        @if ($form->image)
            <div class="mt-2">
                <img src="{{ $form->image->temporaryUrl() }}" alt="Image Preview" class="h-64 w-64 object-cover rounded-lg">
            </div>
        @endif
        @if ($form->lessonmodule->image)
            <div class="flex">
                <img src="{{ asset('storage/' . $form->lessonmodule->image) }}" alt="{{ $form->lessonmodule->title }} image" @class(['h-64 w-64 object-cover rounded-lg', 'opacity-20' => $form->image])>
            </div>
        @endif
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
                {{ 'Update Lesson Module' }}
            </flux:button>
        </div>
    </form>
</section>