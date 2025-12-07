<section>
    <form method="PUT" wire:submit="update" class="flex flex-col max-w-md mx-auto gap-6 bg-slate-900 shadow-2xl rounded-2xl p-4">
        <flux:select wire:model="form.level" :filter="false" label="Level">
            <flux:select.option value="" wire:key="">Select a Level</flux:select.option>
            @foreach ($this->levels as $level)
                <flux:select.option value="{{ $level }}" wire:key="{{ $level }}">
                    {{ $level }}
                </flux:select.option>
            @endforeach
        </flux:select>
        <flux:select wire:model="form.type" :filter="false" label="Type">
            <flux:select.option value="" wire:key="">Select a Type</flux:select.option>
            @foreach ($this->types as $type)
                <flux:select.option value="{{ $type }}" wire:key="{{ $type }}">
                    {{ $type }}
                </flux:select.option>
            @endforeach
        </flux:select>
        <flux:select wire:model="form.subtype" :filter="false" label="Sub-Type">
            <flux:select.option value="" wire:key="">Select a Sub-Type</flux:select.option>
            @foreach ($this->subtypes as $subtype)
                <flux:select.option value="{{ $subtype }}" wire:key="{{ $subtype }}">
                    {{ $subtype }}
                </flux:select.option>
            @endforeach
        </flux:select>
        <flux:input
            wire:model="form.traditional"
            label="Traditional"
            type="text"
            autofocus
            placeholder="traditional"  
        />
        <flux:input
            wire:model="form.simplified"
            label="Simplified"
            type="text"
            autofocus
            placeholder="simplified"  
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
            wire:model="form.english"
            label="English"
            type="text"
            autofocus
            placeholder="translation"  
        />
        <flux:select wire:model="form.book_id" :filter="false" label="Book ID">
            <flux:select.option value="" wire:key="">Select a Book ID</flux:select.option>
            @foreach ($this->book_ids as $book_id)
                <flux:select.option value="{{ $book_id }}" wire:key="{{ $book_id }}">
                    {{ $book_id }}
                </flux:select.option>
            @endforeach
        </flux:select>
        <flux:select wire:model="form.lesson_id" :filter="false" label="Lesson ID">
            <flux:select.option value="" wire:key="">Select a Lesson ID</flux:select.option>
            @foreach ($this->lesson_ids as $lesson_id)
                <flux:select.option value="{{ $lesson_id }}" wire:key="{{ $lesson_id }}">
                    {{ $lesson_id }}
                </flux:select.option>
            @endforeach
        </flux:select>
        <flux:input
            wire:model="form.stroke_code"
            label="Stroke Code"
            type="text"
            autofocus
            placeholder="stroke code"  
        />
        
        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">
                {{ 'Update Word' }}
            </flux:button>
        </div>
    </form>
</section>
