<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

class UserRegister extends Component
{
    public string $name = '';

    public string $email = '';

    public string $type = '';
    
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'lowercase','max:16', 'in:'.implode(',', User::VALID_USER_TYPES)   ],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        ]);

        /* system to generate random password and email to user */
        $validated['password'] = Hash::make("12345678");

        event(new Registered(($user = User::create($validated))));

        session()->flash('message', 'User registered successfully.');

        $this->redirect(route('users.index', absolute: false), navigate: true);
    }

    public function render()
    {
        return view('livewire.user.user-register');
    }
}
