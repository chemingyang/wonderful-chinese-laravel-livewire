<?php

namespace App\Livewire\Character;

use Livewire\Component;
use App\Models\Lesson;
use App\Models\Character;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use League\Csv\Reader;

class CharacterIndex extends Component
{
    use WithFileUploads;

    public $showImportModal = false;
    public $csvFile;
    public $selected_lesson = null;
    public function importCharacters()
    {
        $this->validate([
            'csvFile' => 'required|file|mimes:csv|max:1024', // max 1MB
        ]);

        try {
            $csv = Reader::createFromPath($this->csvFile->path());
            $csv->setHeaderOffset(0);

            $records = $csv->getRecords();
            $imported = 0;
            $updated = 0;
            $skipped = 0;

            foreach ($records as $index => $record) {
            //dd($record);
                try{
                    // Validate required fields
                    if (empty($record['chinese_phrase']) || empty($record['lesson_id'])) {
                        $errors[] = "Row " . ($index + 2) . ": Lesson ID {$record['lesson_id']} or chinese phrase not found";
                        $skipped++;
                        continue;
                    }
                    // Validate lesson_id exists
                    if (!Lesson::findByID($record['lesson_id'])) {
                        $errors[] = "Row " . ($index + 2) . ": Lesson ID {$record['lesson_id']} not found";
                        $skipped++;
                        continue;
                    }

                    $char = Character::where('chinese_phrase', $record['chinese_phrase'])->first();

                    if (!empty($char)) {
                        $char->Update([
                            'chinese_phrase' => $record['chinese_phrase'],
                            'zhuyin' => $record['zhuyin'],
                            'pinyin' => $record['pinyin'],
                            'lesson_id' => $record['lesson_id'],
                            'english_translation' => $record['translation'] ?? null,
                        ]);
                        $updated++;
                    } else {
                        Character::Create([
                            'chinese_phrase' => $record['chinese_phrase'],
                            'zhuyin' => $record['zhuyin'],
                            'pinyin' => $record['pinyin'],
                            'lesson_id' => $record['lesson_id'],
                            'english_translation' => $record['translation'] ?? null,
                        ]);
                        $imported++;
                    }

                }  catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            $this->showImportModal = false;
            $this->reset('csvFile');

            // Show success message with any errors
            $message = "Successfully imported {$imported} characters; updated {$updated}; skipped {$skipped}.";
            if (!empty($errors)) {
                $message .= " However, there were some errors:\n" . implode("\n", $errors);
                session()->flash('warning', $message);
            } else {
                session()->flash('message', $message);
            }
        } catch (\Exception $e) {
            session()->flash('warning', 'Error importing characters: ' . $e->getMessage());
        }
    }

    public function delete($id) {
        $character = Character::find($id);
        if ($character) {
            // Delete associated image if exists
            if ($character->audio) {
                Storage::disk('public')->delete($character->audio);
            }
            $character->delete();
            session()->flash('message', 'Character deleted successfully.');
        } else {
            session()->flash('message', 'Character not found.');
        }
    }

    public function render()
    {   
        $characters = \App\Models\Character::all();
        $lessons = \App\Models\Lesson::all();
        $lessons_arr = [];
        foreach ($lessons as $lesson) {
            $lessons_arr[$lesson['id']] = $lesson['title'];
        }
        //foreach ($characters as $character) {
        //    $lesson = Lesson::find($character->lesson_id);
        //    $character->lesson_title = $lesson->title;
        //}
        //dd($characters);
        return view('livewire.character.character-index', [
            'characters' => $characters,
            'lessons'=> $lessons_arr,
        ]);
    }
}
