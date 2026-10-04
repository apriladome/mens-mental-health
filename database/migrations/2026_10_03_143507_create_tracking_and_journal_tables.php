<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mood_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('energy_level');
            $table->unsignedTinyInteger('irritability_level');
            $table->unsignedTinyInteger('focus_level');
            $table->unsignedTinyInteger('sleep_quality');
            $table->date('logged_date');
            $table->timestamps();

            $table->unique(['user_id', 'logged_date']);
        });

        Schema::create('habit_definitions', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->enum('category', ['somatic', 'cognitive', 'physical', 'relational']);
            $table->boolean('is_system_preset')->default(true);
            $table->timestamps();
        });

        Schema::create('habit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('habit_definition_id')->constrained('habit_definitions')->cascadeOnDelete();
            $table->timestamp('completed_at');
            $table->timestamps();

            $table->index(['user_id', 'completed_at']);
        });

        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('template_type', 50);
            $table->text('encrypted_title');
            $table->longText('encrypted_body');
            $table->string('sentiment_heuristic', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_entries');
        Schema::dropIfExists('habit_logs');
        Schema::dropIfExists('habit_definitions');
        Schema::dropIfExists('mood_entries');
    }
};