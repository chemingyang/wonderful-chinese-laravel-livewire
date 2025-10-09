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

        <flux:input
            wire:model="form.image"
            label="Image"
            type="file"
            accept="image/*" 
        />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">
                {{ 'Create Course' }}
            </flux:button>
        </div>
    </form>

</section>
