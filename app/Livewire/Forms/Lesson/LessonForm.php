<?php

namespace App\Livewire\Forms\Lesson;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;

class LessonForm extends Form
{
    public ?Lesson $lesson;
    public $title = '';
    public $description = '';
    public $course_id = null; 
    public $scheduled_at = null;
    public $completed_at = null;
    public $slug = '';

    public function store() {
        $data = $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'scheduled_at' => 'nullable|date',
            'completed_at' => 'nullable|date',
        ]);
        $data['slug'] = str()->slug($data['title']);
        Lesson::create($data);
        $this->reset();
    }

    public function setLesson(Lesson $lesson) {
        //dd($lesson);
        $this->lesson = $lesson;
        $this->title = $lesson->title;
        $this->description = $lesson->description ? $lesson->description : null;
        $this->course_id = $lesson->course_id;
        $this->scheduled_at = $lesson->scheduled_at ? date('Y-m-d', strtotime($lesson->scheduled_at)) : null;
        $this->completed_at = $lesson->completed_at ? date('Y-m-d', strtotime($lesson->completed_at)) : null;
    }

    public function update() {
        $data = $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'scheduled_at' => 'nullable|date',
            'completed_at' => 'nullable|date',
        ]);
        $data['slug'] = str()->slug($data['title']); //update the slug if the title has changed, but TBD how do we know it is unique?
        $this->lesson->update($data);
        $this->reset();
    }
}