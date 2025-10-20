<?php

namespace App\Livewire\Forms\Course;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;

class CourseForm extends Form
{
    public ?Course $course;
    public $title = '';
    public $description = '';
    public $teacher_id;
    public $image = null; 
    public $slug = '';

    public function setCourse(Course $course) {
        $this->course = $course;
        $this->title = $course->title;
        $this->description = $course->description;
        $this->teacher_id = $course->teacher_id;
        // $this->image = $course->image; // image is not set here TBD some handling reqiured for later
    }

    public function store() {
        $data = $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher_id' => 'nullable|exists:users,id', // TBD make sure it's a teacher
            'image' => 'nullable|image|max:1024', // 1MB Max
        ]);
        if ($this->image) {
            $data['image'] = $this->image->store('courses', 'public');
        }
        if (empty($data['teacher_id'])) $data['teacher_id'] = null;
        $data['slug'] = str()->slug($data['title']);
        Course::create($data);
        $this->reset();
    }

    public function update() {
        $data = $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher_id' => 'nullable|exists:users,id',
            'image' => 'nullable|image|max:1024', // 1MB Max
        ]);
        $data['slug'] = str()->slug($data['title']); //update the slug if the title has changed, but TBD how do we know it is unique?
        $data['image'] = $this->course->image; // keep existing image if no new image is uploaded
        // tried handled through middleware convertemptystringtonull but no good
        if (empty($data['teacher_id'])) $data['teacher_id'] = null;
        if ($this->image) {
            if ($this->course->image) {
                Storage::disk('public')->delete($this->course->image); // delete old image
            }
            $data['image'] = $this->image->store('courses', 'public');
        }
        $this->course->update($data);
        $this->reset();
    }
}