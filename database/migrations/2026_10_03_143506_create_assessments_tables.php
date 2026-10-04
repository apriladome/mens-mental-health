<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('title');
            $table->text('instructions');
            $table->enum('scoring_method', ['sum', 'average', 'custom_matrix']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('assessment_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('assessments')->cascadeOnDelete();
            $table->unsignedSmallInteger('order')->default(1);
            $table->text('question_text');
            $table->json('options_json');
            $table->boolean('is_critical_flag')->default(false);
            $table->timestamps();
        });

        Schema::create('assessment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('assessment_id')->constrained('assessments')->cascadeOnDelete();
            $table->unsignedSmallInteger('total_score')->index();
            $table->enum('risk_classification', ['low', 'mild', 'moderate', 'severe', 'acute'])->index();
            $table->timestamp('completed_at')->index();
            $table->timestamps();
        });

        Schema::create('assessment_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('assessment_submissions')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('assessment_questions')->cascadeOnDelete();
            $table->unsignedSmallInteger('selected_value');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_answers');
        Schema::dropIfExists('assessment_submissions');
        Schema::dropIfExists('assessment_questions');
        Schema::dropIfExists('assessments');
    }
};