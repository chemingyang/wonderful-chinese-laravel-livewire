<?php

namespace App\Livewire\Course;

use Livewire\Component;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;

class CourseIndex extends Component
{
    public function delete($id) {
        $course = Course::find($id);
        if ($course) {
            // Delete associated image if exists
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $course->delete();
            session()->flash('message', 'Course deleted successfully.');
        } else {
            session()->flash('message', 'Course not found.');
        }
    }
    
    public function render()
    {
        return view('livewire.course.course-index', [
            'courses' => \App\Models\Course::all()
        ]);
    }
}
