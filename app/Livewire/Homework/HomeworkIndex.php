<?php

namespace App\Livewire\Homework;

use Livewire\Component;

// admin view show a list of current and past homeworks
class HomeworkIndex extends Component
{
    public function render()
    {
        return view('livewire.homework.homework-index');
    }
}
