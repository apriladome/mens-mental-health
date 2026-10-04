<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Clean up partial residue if previous run stopped halfway
        Schema::dropIfExists('direct_messages');
        Schema::dropIfExists('direct_message_threads');
        Schema::dropIfExists('clinical_notes');
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('clinician_availabilities');
        Schema::dropIfExists('clinician_specialty');
        Schema::dropIfExists('clinician_profiles');
        Schema::dropIfExists('specialties');

        Schema::create('specialties', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->timestamps();
        });

        Schema::create('clinician_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('legal_name');
            $table->string('professional_title', 100);
            $table->text('bio_summary');
            $table->text('license_number');
            $table->string('licensing_state_or_jurisdiction', 100)->index();
            $table->timestamp('license_verified_at')->nullable();
            $table->unsignedInteger('hourly_rate_cents')->default(0);
            $table->unsignedSmallInteger('max_weekly_caseload')->default(25);
            $table->boolean('is_accepting_clients')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('clinician_specialty', function (Blueprint $table) {
            $table->foreignId('clinician_profile_id')->constrained('clinician_profiles')->cascadeOnDelete();
            $table->foreignId('specialty_id')->constrained('specialties')->cascadeOnDelete();
            $table->primary(['clinician_profile_id', 'specialty_id']);
        });

        Schema::create('clinician_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinician_profile_id')->constrained('clinician_profiles')->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week')->index();
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_recurring')->default(true);
            $table->timestamps();
        });

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('clinician_profile_id')->constrained('clinician_profiles')->cascadeOnDelete();
            
            // Using dateTime to prevent MySQL timestamp default conflict
            $table->dateTime('scheduled_start_time')->index();
            $table->dateTime('scheduled_end_time');
            
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled_client', 'cancelled_provider', 'no_show'])->default('pending')->index();
            $table->string('telehealth_room_name', 100)->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
        });

        Schema::create('clinical_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained('appointments')->cascadeOnDelete();
            $table->foreignId('clinician_profile_id')->constrained('clinician_profiles')->cascadeOnDelete();
            $table->longText('encrypted_soap_notes');
            $table->timestamp('signed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('direct_message_threads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('clinician_profile_id')->constrained('clinician_profiles')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('direct_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thread_id')->constrained('direct_message_threads')->cascadeOnDelete();
            $table->foreignId('sender_user_id')->constrained('users')->cascadeOnDelete();
            $table->text('encrypted_message_body');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('direct_messages');
        Schema::dropIfExists('direct_message_threads');
        Schema::dropIfExists('clinical_notes');
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('clinician_availabilities');
        Schema::dropIfExists('clinician_specialty');
        Schema::dropIfExists('clinician_profiles');
        Schema::dropIfExists('specialties');
    }
};