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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            
            // Relates to the users table; if the user is deleted, their profile is deleted
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            // Pseudonymous public identifier (e.g. "IronOak_42")
            $table->string('public_handle', 50)->unique();
            $table->string('avatar_preset_id', 50)->default('default_monochrome');
            $table->string('timezone', 50)->default('UTC');
            $table->string('locale', 10)->default('en');
            
            // Privacy & UI settings
            $table->boolean('stealth_mode_enabled')->default(false);
            $table->enum('retention_preference', ['full', 'minimal', 'ephemeral'])->default('full');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};