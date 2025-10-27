<section>
    <form method="POST" wire:submit="store" class="flex flex-col max-w-md mx-auto gap-6 bg-slate-900 shadow-2xl rounded-2xl p-4">
        <flux:input
            wire:model="form.chinese_phrase"
            label="Chinese"
            type="text"
            autofocus
            placeholder="chinese phrase"  
        />
        <flux:input
            wire:model="form.zhuyin"
            label="Zhuyin"
            type="text"
            autofocus
            placeholder="zhuyin"  
        />
        <flux:input
            wire:model="form.pinyin"
            label="Pinyin"
            type="text"
            autofocus
            placeholder="pinyin"  
        />
        <flux:input
            wire:model="form.english_translation"
            label="Translation"
            type="text"
            autofocus
            placeholder="translation"  
        />
        <flux:select wire:model="form.lesson_id" :filter="false" label="Lesson">
            <flux:select.option value="" wire:key="">Select a Lesson</flux:select.option>
            @foreach ($this->lessons as $lesson)
                <flux:select.option value="{{ $lesson->id }}" wire:key="{{ $lesson->id }}">
                    {{ $lesson->title }}
                </flux:select.option>
            @endforeach
        </flux:select>
        <flux:input
            wire:model="form.audio"
            label="Audio"
            type="file"
            accept="audio/*" 
        />
        {{--
        @if ($form->audio)
            <div class="flex">
                <audio id="player" src="$form->audio->temporaryUrl()"></audio>
                <flux:button onclick="document.getElementById('player').play()" class="p-0 border-0 bg-transparent">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 0 1 0 .656l-5.603 3.113a.375.375 0 0 1-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112Z" />
                </svg>
                </flux:button>
            </div>
        @endif --}}
        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">
                {{ 'Create Character' }}
            </flux:button>
        </div>
    </form>
</section>
