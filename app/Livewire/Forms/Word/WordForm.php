<?php

namespace App\Livewire\Forms\Word;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Word;

class WordForm extends Form
{
    public ?Word $word;
    public $level = '';
    public $type = '';
    public $subtype = '';
    public $traditional = '';
    public $simplified = '';
    public $pinyin = '';
    public $zhuyin = '';
    public $category = '';
    public $english = '';
    public $lesson_id = '';
    public $book_id = ''; 
    private $validation_rule = [
            'level' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'subtype' => 'required|string|max:255',
            'traditional' => 'required|string|max:255',
            'simplified' => 'nullable|string|max:255',
            'pinyin' => 'required|string|max:255',
            'zhuyin' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'english' => 'nullable|string|max:255',
            'book_id' => 'nullable|string|max:255',
            'lesson_id' => 'nullable|string|max:255',
        ];

    public function setWord(Word $word) {
        $this->word = $word;
        $this->level = $word->level;
        $this->type = $word->type;
        $this->subtype = $word->subtype;
        $this->traditional = $word->traditional;
        $this->simplified = $word->simplified ?? '';
        $this->pinyin = $word->pinyin;
        $this->zhuyin = $word->zhuyin;
        $this->category = $word->category;
        $this->english = $word->english ?? '';
        $this->book_id = $word->book_id ?? '';
        $this->lesson_id = $world->lesson_id ?? '';
    }

    public function store() {
        $data = $this->validate($this->validation_rule);

        // see function update
        Word::create($data);
        $this->reset();
    }

    public function update() {
        $data = $this->validate($this->validation_rule);

        $this->word->update($data);
        $this->reset();
    }

}
