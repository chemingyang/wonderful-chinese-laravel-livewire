<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Livewire\Forms\User\UserForm;
use App\Models\User;

class UserEdit extends Component
{
    public UserForm $form;

    public function mount(User $user) {
        $this->form->setUser($user);
    }

    public function update() {
        $this->form->update();
        session()->flash('message', 'User updated successfully.');
        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.user.user-edit');
    }
}
