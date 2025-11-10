<?php

namespace App\Livewire\LessonModule;

use Livewire\Component;
use App\Models\LessonModule;
use App\Models\Lesson;
use App\Models\Character;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use League\Csv\Reader;

class LessonModuleIndex extends Component
{
    use WithFileUploads;

    public $showImportModal = false;
    public $csvFile;

    public function importLessonModules()
    {
        $this->validate([
            'csvFile' => 'required|file|mimes:csv|max:1024', // max 1MB
        ]);

        try {
            $csv = Reader::createFromPath($this->csvFile->path());
            $csv->setHeaderOffset(0);

            // Validate CSV structure
            $header = $csv->getHeader();
            $requiredColumns = ['type', 'lesson_id', 'character_id', 'question', 'answer_key'];
            $missingColumns = array_diff($requiredColumns, $header);

            if (!empty($missingColumns)) {
                session()->flash('error', 'CSV is missing required columns: ' . implode(', ', $missingColumns));
                return;
            }

            $records = $csv->getRecords();
            $imported = 0;
            $errors = [];

            foreach ($records as $index => $record) {
                //dd($record);
                try {
                    // Validate required fields
                    if (empty($record['type']) || empty($record['lesson_id'])) {
                        $errors[] = "Row " . ($index + 2) . ": Missing required fields";
                        continue;
                    }

                    if (!in_array($record['type'], array_keys(LessonModule::VALID_LESSON_MODULE_TYPES))) {
                        $errors[] = "Row " . ($index + 2) . ": Incorrect type fields";
                        continue;
                    }

                    // Validate lesson_id exists
                    if (!Lesson::findByID($record['lesson_id'])) {
                        $errors[] = "Row " . ($index + 2) . ": Lesson ID {$record['lesson_id']} not found";
                        continue;
                    }

                    // Validate question does not repeat
                    if (substr($record['type'], -1) != 'x' && LessonModule::where('question', $record['question'])->first()) {
                        $errors[] = "Row " . ($index + 2) . ": Question {$record['question']} exists.";
                        continue;
                    }

                    // Validate character_id does not repeat for x-type
                    if (substr($record['type'], -1) == 'x' && LessonModule::where('character_id', $record['character_id'])->first()) {
                        $errors[] = "Row " . ($index + 2) . ": Character id {$record['character_id']} exist.";
                        continue;
                    }

                    // Validate character_id if present
                    if (!empty($record['character_id']) && !Character::findByID($record['character_id'])) {
                        $errors[] = "Row " . ($index + 2) . ": Character ID {$record['character_id']} not found";
                        continue;
                    }

                    LessonModule::create([
                        'type' => $record['type'],
                        'lesson_id' => $record['lesson_id'],
                        'character_id' => !empty($record['character_id']) ? $record['character_id'] : null,
                        'question' => $record['question'] ?? null,
                        'answer_key' => $record['answer_key'] ?? null,
                        'weight' => 1,
                    ]);

                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            $this->showImportModal = false;
            $this->reset('csvFile');

            // Show success message with any errors
            $message = "Successfully imported {$imported} lesson modules.";
            if (!empty($errors)) {
                $message .= " However, there were some errors:\n" . implode("\n", $errors);
                session()->flash('warning', $message);
            } else {
                session()->flash('message', $message);
            }

        } catch (\Exception $e) {
            session()->flash('error', 'Error importing lesson modules: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $lessonmodule = LessonModule::find($id);
        if ($lessonmodule) {
            $lessonmodule->delete();
            session()->flash('message', 'Lesson deleted successfully.');
        } else {
            session()->flash('message', 'Lesson not found.');
        }
    }
    
    public function render()
    {
        return view('livewire.lesson-module.lesson-module-index', [
            'lessonmodules' => LessonModule::with(['lesson', 'character'])->get()
        ]);
    }
}
