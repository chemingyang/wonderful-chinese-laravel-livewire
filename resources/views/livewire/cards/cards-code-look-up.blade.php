<section class="max-w-2xl mx-auto p-6 border border-gray-200 rounded-lg shadow-md">
    <form method="POST" wire:submit="enqueue" class="flex flex-col gap-6">
        <!-- From ID -->
        <flux:input
            :label="__('From ID')"
            wire:model="from_id"
            type="text"
            name="from_id"
            required
            autofocus
        />

        <!-- From ID -->
        <flux:input
            :label="__('To ID')"
            wire:model="to_id"
            name="to_id"
            type="text"
            required
        />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">
                {{ __('Enqueue') }}
            </flux:button>
        </div>
    </form>
</section>
