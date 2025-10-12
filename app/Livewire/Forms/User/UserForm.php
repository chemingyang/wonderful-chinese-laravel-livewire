<?php

namespace App\Livewire\Forms\User;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\User;

class UserForm extends Form
{
    public ?User $user;
    public $name = '';
    public $email = '';
    public $type = '';

    public function store() {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'type' => 'required|in:'.implode(',', User::VALID_USER_TYPES),
        ]);
        //$data['slug'] = str()->slug($data['title']);
        User::create($data);
        $this->reset();
    }

    public function setUser(User $user) {
        //dd($lesson);
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->type = $user->type;
    }

    public function update() {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'type' => 'required|in:'.implode(',', User::VALID_USER_TYPES),
        ]);
        // $data['slug'] = str()->slug($data['title']); //update the slug if the title has changed, but TBD how do we know it is unique?
        $this->user->update($data);
        $this->reset();
    }
}
