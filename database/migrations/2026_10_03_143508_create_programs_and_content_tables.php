<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 150)->unique();
            $table->string('title');
            $table->text('summary');
            $table->enum('tier_requirement', ['free', 'member', 'premium'])->default('free');
            $table->unsignedSmallInteger('estimated_completion_days')->default(7);
            $table->boolean('is_published')->default(false)->index();
            $table->timestamps();
        });

        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            $table->unsignedSmallInteger('order')->default(1);
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('modules')->cascadeOnDelete();
            $table->unsignedSmallInteger('order')->default(1);
            $table->string('slug', 150)->unique();
            $table->string('title');
            $table->unsignedSmallInteger('reading_time_minutes')->default(5);
            $table->longText('body_content');
            $table->string('audio_media_url', 1024)->nullable();
            $table->string('interactive_tool_type', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('user_program_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            $table->unsignedBigInteger('last_completed_lesson_id')->nullable();
            $table->enum('status', ['in_progress', 'completed', 'abandoned'])->default('in_progress');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'program_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_program_progress');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('modules');
        Schema::dropIfExists('programs');
    }
};