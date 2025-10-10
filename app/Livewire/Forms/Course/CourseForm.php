<?php

namespace App\Livewire\Forms\Course;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Course;

class CourseForm extends Form
{
    public ?Course $course;
    public $title = '';
    public $description = '';
    public $image = null; 
    public $slug = '';

    public function setCourse(Course $course) {
        $this->course = $course;
        $this->title = $course->title;
        $this->description = $course->description;
        // $this->image = $course->image;
    }

    public function store() {
        $data = $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:1024', // 1MB Max
        ]);

        if ($this->image) {
            $data['image'] = $this->image->store('courses', 'public');
        }
        $data['slug'] = str()->slug($data['title']);
        Course::create($data);
        session()->flash('message', 'Course created successfully.');
        $this->reset();
    }

    public function update() {
        $data = $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:1024', // 1MB Max
        ]);
        $data['slug'] = str()->slug($data['title']); //update the slug if the title has changed, but TBD how do we know it is unique?
        $data['image'] = $this->course->image; // keep existing image if no new image is uploaded

        if ($this->image) {
            Storage::disk('public')->delete($this->course->image); // delete old image
            $data['image'] = $this->image->store('courses', 'public');
        }
       
        $this->course->update($data);
        session()->flash('message', 'Course updated successfully.');
        $this->reset();
    }
}