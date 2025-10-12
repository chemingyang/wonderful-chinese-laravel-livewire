<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use App\Livewire\Forms\User\UserForm;

class UserIndex extends Component
{
    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            session()->flash('message', 'User unregistered successfully.');
        } else {
            session()->flash('message', 'User not found.');
        }
    }
    
    public function clearSessionMessage() {
        session()->forget('message');
    }

    public function render()
    {
        return view('livewire.user.user-index',[
            'users' => \App\Models\User::all()
        ]);
    }
}
