<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emergency_resources', function (Blueprint $table) {
            $table->id();
            $table->string('country_code', 2)->index();
            $table->string('region_code', 10)->nullable()->index();
            $table->string('resource_name', 255);
            $table->string('phone_number', 50);
            $table->string('sms_number', 50)->nullable();
            $table->string('web_url', 1024)->nullable();
            $table->boolean('is_veteran_specific')->default(false);
            $table->string('operating_hours', 100)->default('24/7');
            $table->timestamps();
        });

        Schema::create('crisis_escalation_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('trigger_source', ['phq9_q9', 'keyword_sentinel', 'manual_panic_trigger', 'provider_flag']);
            $table->enum('severity_level', ['elevated', 'imminent_danger'])->index();
            $table->boolean('intercept_viewed')->default(false);
            $table->foreignId('clinician_dispatched_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('resolved_at')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('stripe_customer_id', 100)->unique();
            $table->string('stripe_subscription_id', 100)->unique();
            $table->string('plan_identifier', 50)->index();
            $table->string('status', 50)->index();
            $table->timestamp('current_period_end')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('crisis_escalation_logs');
        Schema::dropIfExists('emergency_resources');
    }
};