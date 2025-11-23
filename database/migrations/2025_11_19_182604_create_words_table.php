<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->string('level');
            $table->string('type');
            $table->string('subtype');
            $table->string('traditional');
            $table->string('simplified')->nullable();
            $table->string('pinyin');
            $table->string('zhuyin');
            $table->string('category');
            $table->string('english')->nullable();
            $table->string('book_id')->nullable();
            $table->string('lesson_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('words');
    }
};
