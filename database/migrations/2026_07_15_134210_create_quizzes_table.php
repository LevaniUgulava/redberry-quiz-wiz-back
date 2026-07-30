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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('image_url');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('difficulty_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->decimal('points');
            $table->text('description');
            $table->unsignedInteger('time_limit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
