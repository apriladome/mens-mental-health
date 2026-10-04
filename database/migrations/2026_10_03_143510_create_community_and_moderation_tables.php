<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('community_groups', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 100)->unique();
            $table->string('name', 100);
            $table->text('description');
            $table->boolean('is_private')->default(false);
            $table->timestamps();
        });

        Schema::create('community_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('community_groups')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('body');
            $table->boolean('is_quarantined')->default(false)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('community_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('community_posts')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('body');
            $table->boolean('is_quarantined')->default(false)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('moderation_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('reportable_type');
            $table->unsignedBigInteger('reportable_id');
            $table->enum('reason', ['self_harm_risk', 'hate_speech', 'harassment', 'spam', 'other'])->index();
            $table->enum('status', ['pending', 'reviewed', 'dismissed', 'actioned'])->default('pending')->index();
            $table->timestamps();

            $table->index(['reportable_type', 'reportable_id']);
        });

        Schema::create('moderation_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('moderation_reports')->cascadeOnDelete();
            $table->foreignId('moderator_user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('action_taken', ['warning_issued', 'content_scrubbed', 'user_suspended', 'dismissed']);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moderation_actions');
        Schema::dropIfExists('moderation_reports');
        Schema::dropIfExists('community_comments');
        Schema::dropIfExists('community_posts');
        Schema::dropIfExists('community_groups');
    }
};