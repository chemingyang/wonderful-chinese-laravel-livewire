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
        <div class="flex justify-between align-items-center gap-3">
            <div class="flex item-center gap-2">
                <audio id="player" src="{{ asset('storage/' . $form->lessonmodule->audio) }}"></audio>
                <flux:button onclick="document.getElementById('player').play()" class="p-0 border-0 bg-transparent">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 0 1 0 .656l-5.603 3.113a.375.375 0 0 1-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112Z" />
                </svg>
                </flux:button>
            </div>
            <button type="button" 
                @click="confirm('Are you sure you want to delete this audio?')" 
                wire:click="deleteAudio({{ $form->lessonmodule->id }})" 
                class="flex float-right text-sm font-semiboldtext-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg px-2 py-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900"
            >Remove Audio</button>
        </div>
        @endif
        <flux:input
            wire:model="form.image"
            label="Image"
            type="file"
            accept="image/*" 
        />
        <flux:field variant="inline">
            <flux:checkbox wire:model="others" :disabled="!$this->form->lesson_id||!in_array($this->form->type,['fill-in-blank','answer-question'])" wire:change="getOtherModules()" />
            <flux:select :filter="false" :disabled="!$this->others" wire:change="setFormImage($event.target.value)">
                <flux:select.option value="" wire:key="">Use other lesson module's images (optional)</flux:select.option>
                @if (!empty($othermodules))
                    @foreach ($othermodules as $othermodule)
                    <flux:select.option value="{{ $othermodule->id }}" wire:key="{{ $othermodule->id }}">
                        {{ $othermodule->question }}
                    </flux:select.option>
                    @endforeach
                @endif
            </flux:select>
        </flux:field>
        @if ($form->image)
            <div class="mt-2">
                @if (gettype($form->image) != 'string')
                <img src="{{ $form->image->temporaryUrl() }}" alt="Image Preview" class="w-80 object-cover rounded-lg">
                @else
                <img src="{{ asset('storage/' . $form->image) }}" alt="Image Preview" class="w-80 object-cover rounded-lg">
                @endif
            </div>
        @endif
        @if ($form->lessonmodule->image)
            <div class="flex justify-between items-center gap-3">
                <div class="flex">
                    <img src="{{ asset('storage/' . $form->lessonmodule->image) }}" alt="{{ $form->lessonmodule->title }} image" @class(['w-80 object-cover rounded-lg', 'opacity-20' => $form->image])>
                </div>
                <button type="button" 
                    @click="confirm('Are you sure you want to delete this image?')" 
                    wire:click="deleteImage({{ $form->lessonmodule->id }})" 
                    class="justify-end text-sm font-semiboldtext-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg px-2 py-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900"
                >Remove Image</button>
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