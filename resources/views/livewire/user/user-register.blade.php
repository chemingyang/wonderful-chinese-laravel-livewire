<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Name')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Full name')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        

        <!-- User Type -->
        <flux:select wire:model="type" :filter="false" label="User Type   ">
            <flux:select.option value="" wire:key="">Select a user type</flux:select.option>
            @foreach (\App\Models\User::VALID_USER_TYPES as $userType)
                <flux:select.option value="{{ $userType }}" wire:key="{{ $userType }}">{{ ucfirst($userType) }}</flux:select.option>
            @endforeach
        </flux:select>

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create User Account') }}
            </flux:button>
        </div>
    </form>
</div>
