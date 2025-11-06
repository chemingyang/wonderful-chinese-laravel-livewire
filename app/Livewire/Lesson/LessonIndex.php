<?php

namespace App\Livewire\Lesson;

use Livewire\Component;
use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use League\Csv\Reader;

class LessonIndex extends Component
{
    use WithFileUploads;

    public $showImportModal = false;
    public $csvFile;

    public function importLessons()
    {
        $this->validate([
            'csvFile' => 'required|file|mimes:csv|max:1024', // max 1MB
        ]);

        try {
            $csv = Reader::createFromPath($this->csvFile->path());
            $csv->setHeaderOffset(0);

            $records = $csv->getRecords();
            $imported = 0;
            $errors = [];

            foreach ($records as $index => $record) {
                try {
                    // Validate required fields
                    if (empty($record['title']) || empty($record['course_id'])) {
                        $errors[] = "Row " . ($index + 2) . ": Missing required fields";
                        continue;
                    }

                    // Validate course_id exists
                    if (!Course::find($record['course_id'])) {
                        $errors[] = "Row " . ($index + 2) . ": Course ID {$record['course_id']} not found";
                        continue;
                    }

                    $record['slug'] = str()->slug($record['description']);

                    Lesson::create([
                        'title' => $record['title'],
                        'slug' => $record['slug'],
                        'description' => $record['description'] ?? null,
                        'course_id' => $record['course_id'],
                    ]);

                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            $this->showImportModal = false;
            $this->reset('csvFile');

            // Show success message with any errors
            $message = "Successfully imported {$imported} lessons.";
            if (!empty($errors)) {
                $message .= " However, there were some errors:\n" . implode("\n", $errors);
                session()->flash('warning', $message);
            } else {
                session()->flash('message', $message);
            }

        } catch (\Exception $e) {
            session()->flash('error', 'Error importing lessons: ' . $e->getMessage());
        }
    }
    
    // should include the delete function here
    public function delete($id)
    {
        $lesson = Lesson::find($id);
        if ($lesson) {
            $lesson->delete();
            session()->flash('message', 'Lesson deleted successfully.');
        } else {
            session()->flash('message', 'Lesson not found.');
        }
    }

    public function render()
    {
        return view('livewire.lesson.lesson-index',[
            'lessons' => \App\Models\Lesson::with('course:id,title')->get()
        ]);
    }
}
