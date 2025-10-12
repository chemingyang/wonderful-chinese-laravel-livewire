<section>
    <form method="PUT" wire:submit="update" class="flex flex-col max-w-md mx-auto gap-6 bg-slate-900 shadow-2xl rounded-2xl p-4">
        <flux:input
            wire:model="form.name"
            label="Name"
            type="text"
            autofocus
            placeholder="name"  
        />
        <flux:textarea
            wire:model="form.email"
            label="Email"
            type="text"
            rows="4"
            placeholder="email"
        />
        <flux:select wire:model="form.type" :filter="false" label="User Type   ">
            <flux:select.option value="" wire:key="">select a user type</flux:select.option>
            @foreach (\App\Models\User::VALID_USER_TYPES as $userType)
                <flux:select.option value="{{ $userType }}" wire:key="{{ $userType }}">{{ ucfirst($userType) }}</flux:select.option>
            @endforeach
        </flux:select>
        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">
                {{ 'Update User' }}
            </flux:button>
        </div>
    </form>
</section>