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
        Schema::create('review_modules', function (Blueprint $table) {
            $table->id();
            $table->text('type');
            $table->unsignedBigInteger('lesson_id');
            $table->unsignedBigInteger('character_id')->nullable();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
            $table->text('audio')->nullable();
            $table->text('image')->nullable();
            $table->text('note')->nullable();
            $table->smallInteger('weight');
            $table->timestamps();//
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('review_modules', function (Blueprint $table) {
            Schema::dropIfExists('review_modules');
        });
    }
};
