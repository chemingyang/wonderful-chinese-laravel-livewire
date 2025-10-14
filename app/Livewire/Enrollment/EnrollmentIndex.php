<?php

namespace App\Livewire\Enrollment;

use Livewire\Component;

class EnrollmentIndex extends Component
{
    public function render()
    {
        return view('livewire.enrollment.enrollment-index', [
            'enrollments' => \App\Models\Enrollment::with('course','student')->get()
        ]);
    }
}
