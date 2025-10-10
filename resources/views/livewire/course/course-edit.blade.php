<section>
    <form method="PUT" wire:submit="update" class="flex flex-col max-w-md mx-auto gap-6 bg-slate-900 shadow-2xl rounded-2xl p-4">
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
        <flux:input
            wire:model="form.image"
            label="Image"
            type="file"
            accept="image/*" 
        />
        <div class="flex gap-2">
        @if ($form->course->image)
            <div class="flex">
                <img src="{{ asset('storage/' . $form->course->image) }}" alt="{{ $form->course->title }} image" @class(['h-12 w-12 object-cover rounded-lg', 'opacity-20' => $form->image])>
            </div>
        @endif
        @if ($form->image)
            <div class="flex">
                <img src="{{ $form->image->temporaryUrl() }}" alt="Image Preview" class="h-12 w-12 object-cover rounded-lg">
            </div>
        @endif
        </div>
        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">
                {{ 'Update Course' }}
            </flux:button>
        </div>
    </form>
</section>
