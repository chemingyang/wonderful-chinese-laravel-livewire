<?php

namespace App\Livewire\LessonModule;

use Livewire\Component;
use App\Models\LessonModule;
use App\Models\Lesson;
use App\Models\Character;
use Livewire\Attributes\Confirm;
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
            $updated = 0;
            $errors = [];
            $notices = [];

            foreach ($records as $index => $record) {
                //dd($record);
                try {
                    // Validate required fields
                    if (empty($record['type']) || empty($record['lesson_id'])) {
                        $notices[] = "Row " . ($index + 2) . ": Missing required fields";
                        continue;
                    }

                    if (!in_array($record['type'], array_keys(LessonModule::VALID_LESSON_MODULE_TYPES))) {
                        $notices[] = "Row " . ($index + 2) . ": Incorrect type fields";
                        continue;
                    }

                    // Validate lesson_id exists
                    if (!Lesson::findByID($record['lesson_id'])) {
                        $notices[] = "Row " . ($index + 2) . ": Lesson ID {$record['lesson_id']} not found";
                        continue;
                    }
                    // Validate character_id if present
                    if (!empty($record['lesson_id']) && !Lesson::findByID($record['lesson_id'])) {
                        $notices[] = "Row " . ($index + 2) . ": Lesson ID {$record['lesson_id']} not found";
                        continue;
                    }

                    // Validate character_id if present
                    if (!empty($record['character_id']) && !Character::findByID($record['character_id'])) {
                        $notices[] = "Row " . ($index + 2) . ": Character ID {$record['character_id']} not found";
                        continue;
                    }

                    // Validate character_id does not repeat for x-type
                    if (substr($record['type'], -1) == 'x' && LessonModule::where('character_id', $record['character_id'])->first()) {
                        $notices[] = "Row " . ($index + 2) . ": Character id {$record['character_id']} exist.";
                        continue;
                    }

                    $lm_first = LessonModule::where('question', $record['question'])->where('lesson_id', $record['lesson_id'])->first();
                    if (substr($record['type'], -1) != 'x') { 
                        if (!empty($lm_first)) {
                            $lm_first->update([
                                'type' => $record['type'],
                                'lesson_id' => $record['lesson_id'],
                                'character_id' => !empty($record['character_id']) ? $record['character_id'] : null,
                                'question' => $record['question'] ?? null,
                                'answer_key' => $record['answer_key'] ?? null,
                                'weight' => 1,
                            ]);
                            $updated++;
                        } else {
                            LessonModule::create([
                                'type' => $record['type'],
                                'lesson_id' => $record['lesson_id'],
                                'character_id' => !empty($record['character_id']) ? $record['character_id'] : null,
                                'question' => $record['question'] ?? null,
                                'answer_key' => $record['answer_key'] ?? null,
                                'weight' => 1,
                            ]);
                            $imported++;
                        }
                    }
                } catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            $this->showImportModal = false;
            $this->reset('csvFile');
            $skipped = count($notices);
            // Show success message with any errors
            $message = "Successfully imported {$imported} & updated {$updated} lesson modules. Also skipped {$skipped}." . "\n";
            if (!empty($errors) || !empty($notices)) {
                $message .= " errors:" . implode("\n", $errors) . "\n";
                $message .= " notices:" . implode("\n", $notices) . "\n";
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
        $lessonmodule = LessonModule::findByID($id);
        if ($lessonmodule) {
            if ($lessonmodule->audio) {
                Storage::disk('public')->delete($lessonmodule->audio);
            }
            if ($lessonmodule->image) {
                Storage::disk('public')->delete($lessonmodule->image);
            }
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
