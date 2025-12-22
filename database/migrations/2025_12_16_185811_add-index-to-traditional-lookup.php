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
        Schema::table('code_lookup', function (Blueprint $table) {
            $table->index('traditional');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('code_lookup', function (Blueprint $table) {
            $table->dropIndex(['traditional']);
        });
    }
};
