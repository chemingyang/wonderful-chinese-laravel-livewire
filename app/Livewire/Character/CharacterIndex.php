<?php

namespace App\Livewire\Character;

use Livewire\Component;
use App\Models\Lesson;
use App\Models\Character;
use Illuminate\Support\Facades\Storage;

class CharacterIndex extends Component
{
    public function delete($id) {
        $character = Character::find($id);
        if ($character) {
            // Delete associated image if exists
            if ($character->audio) {
                Storage::disk('public')->delete($character->audio);
            }
            $character->delete();
            session()->flash('message', 'Character deleted successfully.');
        } else {
            session()->flash('message', 'Character not found.');
        }
    }

    public function render()
    {   
        $characters = \App\Models\Character::all();
        foreach ($characters as $character) {
            $lesson = Lesson::find($character->lesson_id);
            $character->lesson_title = $lesson->title;
        }
        
        return view('livewire.character.character-index', [
            'characters' => $characters,
        ]);
    }
}
