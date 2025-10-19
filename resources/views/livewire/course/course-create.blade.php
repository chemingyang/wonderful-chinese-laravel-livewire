<section>
    <form method="POST" wire:submit="store" class="flex flex-col max-w-md mx-auto gap-6 bg-slate-900 shadow-2xl rounded-2xl p-4">
        <!-- Title -->
        <flux:input
            wire:model="form.title"
            label="Title"
            type="text"
            autofocus
            placeholder="title"  
        />

        <flux:textarea
            wire:model="form.description"
            label="Description"
            type="text"
            rows="4"
            placeholder="description"
        />

         <!-- Teacher -->
        <flux:select wire:model="form.teacher_id" :filter="false" label="Teacher">
            <flux:select.option value="" wire:key="">Select a teacher</flux:select.option>
            @foreach ($this->teachers as $teacher)
                <flux:select.option value="{{ $teacher->id }}" wire:key="{{ $teacher->id }}">
                    {{ $teacher->name }}
                </flux:select.option>
            @endforeach
        </flux:select>

        <flux:input
            wire:model="form.image"
            label="Image"
            type="file"
            accept="image/*" 
        />
        @if ($form->image)
            <div class="mt-2">
                <img src="{{ $form->image->temporaryUrl() }}" alt="Image Preview" class="h-12 w-12 object-cover rounded-lg">
            </div>
        @endif

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">
                {{ 'Create Course' }}
            </flux:button>
        </div>
    </form>

</section>
