<?php

namespace App\Livewire\Enrollment;

use Livewire\Component;
use App\Models\Enrollment;

class EnrollmentIndex extends Component
{
     public function delete($id)
    {
        $enrollment = Enrollment::find($id);
        if ($enrollment) {
            $enrollment->delete();
            session()->flash('message', 'Lesson deleted successfully.');
        } else {
            session()->flash('message', 'Lesson not found.');
        }
    }
    
    public function render()
    {
        return view('livewire.enrollment.enrollment-index', [
            'enrollments' => \App\Models\Enrollment::with('course','student')->get()
        ]);
    }
}
