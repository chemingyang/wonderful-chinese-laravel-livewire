<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = ['level', 'type', 'subtype', 'traditional', 'simplified', 'zhuyin', 'pinyin', 'category', 'english', 'book_id', 'lesson_id', 'stroke_code'];

    const VALID_LEVELS = [
        '萌芽級' => '萌芽級',
        '成長級' => '成長級',
        '茁壯級' => '茁壯級',
    ];

    const VALID_TYPES = [
        '人物' => '人物',
        '數量' => '數量',
        '程度' => '程度',
        '時間' => '時間',
        '形色' => '形色',
        '生活' => '生活',
        '交通' => '交通',
        '自然' => '自然',
        '地方' => '地方',
        '常用語' => '常用語',
        '功能詞' => '功能詞',
    ];

    const VALID_SUBTYPES = [
        '人物' => '人物',
        '家庭' => '家庭',
        '身體部位' => '身體部位',
        '身體動作' => '身體動作',
        '手部動作' => '手部動作',
        '腳部動作' => '腳部動作',
        '眼部動作' => '眼部動作',
        '口部動作' => '口部動作',
        '心理活動' => '心理活動',
        '人格特質' => '人格特質',
        '職業' => '職業',
        '數字' => '數字',
        '數量' => '數量',
        '金錢' => '金錢',
        '程度' => '程度',
        '年月日星期' => '年月日星期',
        '時間' => '時間',
        '顏色' => '顏色',
        '尺寸' => '尺寸',
        '形狀' => '形狀',
        '衣物飾品' => '衣物飾品',
        '居家用品' => '居家用品',
        '居家活動' => '居家活動',
        '飲食' => '飲食',
        '學校' => '學校',
        '休閒活動' => '休閒活動',
        '健康' => '健康',
        '交通工具' => '交通工具',
        '現象' => '現象',
        '季節' => '季節',
        '天氣' => '天氣',
        '植物' => '植物',
        '動物' => '動物',
        '自然環境' => '自然環境',
        '方位' => '方位',
        '處所' => '處所',
        '國家' => '國家',
        '語言' => '語言',
        '一般' => '一般',
        '祝福' => '祝福',
        '功能詞' => '功能詞',
        '鼻子動作' => '鼻子動作',
    ];

    const VALID_BOOK_IDS = [
        'B1' => 'B1',
        'B2' => 'B2',
        'B3' => 'B3',
        'B4' => 'B4',
        'B5' => 'B5',
        'B6' => 'B6',
        'B7' => 'B7',
        'B8' => 'B8',
        'B9' => 'B9',
        'B10' => 'B10',
    ];

    const VALID_LESSON_IDS = [
        'L1' => 'L1',
        'L2' => 'L2',
        'L3' => 'L3',
        'L4' => 'L4',
        'L5' => 'L5',
        'L6' => 'L6',
        'L7' => 'L7',
        'L8' => 'L8',
        'L9' => 'L9',
        'L10' => 'L10',
        'L11' => 'L11',
        'L12' => 'L12',
    ];

    // --- IGNORE ----
    protected $hidden = ['created_at', 'updated_at'];

    public static function findByID(int|string $id)
    {
        return once(fn () => self::find($id));
    }

    // --- View helper accessors (computed once per model instance) ---
    public function getSanitizedEnglishAttribute(): string
    {
        $english = $this->english ?? '';

        return preg_replace('/\s*\/\s*/', '/', trim(preg_replace('/\([^)]*\)/', '', $english)));
    }

    public function getEnglishWordCountAttribute(): int
    {
        $english = $this->sanitized_english;
        $words = array_filter(preg_split('/[\/\s]+/', $english), function ($w) { return $w !== ''; });

        return count($words);
    }

    public function getTraditionalCharsAttribute(): string
    {
        return explode('/', $this->traditional ?? '')[0] ?? '';
    }

    public function getTraditionalFullWidthCountAttribute(): int
    {
        $traditional = $this->traditional_chars;
        $chars = preg_split('//u', $traditional, -1, PREG_SPLIT_NO_EMPTY);
        $count = 0;
        foreach ($chars as $c) {
            if (preg_match('/\p{Han}/u', $c)) {
                $count++;
            }
        }

        return $count;
    }

    public function getTraditionalFontSizeAttribute(): string
    {
        $fullWidthCount = $this->traditional_full_width_count;

        if ($fullWidthCount <= 2) {
            return '56px';
        }

        return match ($fullWidthCount) {
            3 => '46px',
            4 => '36px',
            5 => '26px',
            default => '20px',
        };
    }

    public function getEnglishFontSizeAttribute(): string
    {
        $count = $this->english_word_count;

        if ($count >= 12) {
            return '12px';
        }

        if ($count >= 9) {
            return '15px';
        }

        if ($count >= 7) {
            return '18px';
        }

        return '20px';
    }
}
