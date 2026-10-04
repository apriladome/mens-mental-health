<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\EmergencyResource;
use App\Models\HabitDefinition;
use App\Models\Specialty;
use App\Models\ClinicianProfile;
use App\Models\ClinicianAvailability;
use App\Models\Program;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\CommunityGroup;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Spatie Roles & Permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = ['super_admin', 'clinical_director', 'clinician', 'moderator', 'member', 'guest'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // 2. Emergency Crisis Hotlines
        $emergencyResources = [
            [
                'country_code' => 'US',
                'region_code' => null,
                'resource_name' => 'Suicide & Crisis Lifeline (National)',
                'phone_number' => '988',
                'sms_number' => '988',
                'web_url' => 'https://988lifeline.org',
                'is_veteran_specific' => false,
                'operating_hours' => '24/7',
            ],
            [
                'country_code' => 'US',
                'region_code' => null,
                'resource_name' => 'Veterans Crisis Line',
                'phone_number' => '988',
                'sms_number' => '838255',
                'web_url' => 'https://www.veteranscrisisline.net',
                'is_veteran_specific' => true,
                'operating_hours' => '24/7',
            ],
            [
                'country_code' => 'US',
                'region_code' => null,
                'resource_name' => 'Crisis Text Line',
                'phone_number' => '741741',
                'sms_number' => '741741',
                'web_url' => 'https://www.crisistextline.org',
                'is_veteran_specific' => false,
                'operating_hours' => '24/7',
            ],
        ];

        foreach ($emergencyResources as $resource) {
            EmergencyResource::firstOrCreate(['resource_name' => $resource['resource_name']], $resource);
        }

        // 3. Validated Assessment: PHQ-9 (Patient Health Questionnaire-9)
        $phq9 = Assessment::firstOrCreate(
            ['code' => 'PHQ-9'],
            [
                'title' => 'Personal Mood & Capacity Audit (PHQ-9)',
                'instructions' => 'Over the last 2 weeks, how often have you been bothered by any of the following problems? Answer honestly—your data is encrypted.',
                'scoring_method' => 'sum',
                'is_active' => true,
            ]
        );

        $standardOptions = [
            ['label' => 'Not at all', 'value' => 0],
            ['label' => 'Several days', 'value' => 1],
            ['label' => 'More than half the days', 'value' => 2],
            ['label' => 'Nearly every day', 'value' => 3],
        ];

        $phq9Questions = [
            ['order' => 1, 'text' => 'Little interest or pleasure in doing things', 'critical' => false],
            ['order' => 2, 'text' => 'Feeling down, depressed, or hopeless', 'critical' => false],
            ['order' => 3, 'text' => 'Trouble falling or staying asleep, or sleeping too much', 'critical' => false],
            ['order' => 4, 'text' => 'Feeling tired or having little energy', 'critical' => false],
            ['order' => 5, 'text' => 'Poor appetite or overeating', 'critical' => false],
            ['order' => 6, 'text' => 'Feeling bad about yourself — or that you are a failure or have let yourself or your family down', 'critical' => false],
            ['order' => 7, 'text' => 'Trouble concentrating on things, such as reading the newspaper or watching television', 'critical' => false],
            ['order' => 8, 'text' => 'Moving or speaking so slowly that other people could have noticed, or being fidgety/restless', 'critical' => false],
            ['order' => 9, 'text' => 'Thoughts that you would be better off dead, or of hurting yourself in some way', 'critical' => true],
        ];

        foreach ($phq9Questions as $q) {
            AssessmentQuestion::firstOrCreate(
                ['assessment_id' => $phq9->id, 'order' => $q['order']],
                [
                    'question_text' => $q['text'],
                    'options_json' => $standardOptions,
                    'is_critical_flag' => $q['critical'],
                ]
            );
        }

        // 4. Keystone Resilience Habit Definitions
        $habits = [
            ['title' => '10-Minute Box Breathing Protocol', 'category' => 'somatic'],
            ['title' => '20-Minute Brisk Sunlight Walk', 'category' => 'physical'],
            ['title' => 'Cognitive Thought Record Debrief', 'category' => 'cognitive'],
            ['title' => 'Zero Screens 60m Before Bed', 'category' => 'somatic'],
            ['title' => 'Check in with a Friend or Squad Member', 'category' => 'relational'],
        ];

        foreach ($habits as $habit) {
            HabitDefinition::firstOrCreate(['title' => $habit['title']], [
                'category' => $habit['category'],
                'is_system_preset' => true,
            ]);
        }

        // 5. Clinical & Coaching Specialties
        $specialties = [
            ['name' => 'Executive & Work Burnout', 'slug' => 'executive-work-burnout'],
            ['name' => 'Divorce & Life Transitions', 'slug' => 'divorce-life-transitions'],
            ['name' => 'First Responders & Tactical Stress', 'slug' => 'first-responders-tactical-stress'],
            ['name' => 'Anger Regulation & Nervous System Reset', 'slug' => 'anger-regulation-nervous-system-reset'],
            ['name' => 'Addiction & Habit Neutralization', 'slug' => 'addiction-habit-neutralization'],
        ];

        foreach ($specialties as $specialty) {
            Specialty::firstOrCreate(['slug' => $specialty['slug']], $specialty);
        }

        // 6. Psychoeducational Program: The Burnout Reset Protocol
        $program = Program::firstOrCreate(
            ['slug' => 'burnout-reset-protocol'],
            [
                'title' => 'The Burnout Reset Protocol',
                'summary' => 'A 7-day tactical operating manual to stop energy leaks, down-regulate physical stress, and rebuild mental stamina.',
                'tier_requirement' => 'free',
                'estimated_completion_days' => 7,
                'is_published' => true,
            ]
        );

        $module = Module::firstOrCreate(
            ['program_id' => $program->id, 'order' => 1],
            ['title' => 'Phase 1: Physiological Stabilization']
        );

        Lesson::firstOrCreate(
            ['module_id' => $module->id, 'slug' => 'mechanics-of-overload'],
            [
                'order' => 1,
                'title' => 'The Mechanics of Overload: What Stress Does to Your Biology',
                'reading_time_minutes' => 6,
                'body_content' => "Stress is not an emotional defect; it is a neurological and hormonal state. When demands exceed perceived resources for extended periods, your sympathetic nervous system stays locked in fight-or-flight.\n\nIn this lesson, we break down cortisol depletion, sleep disruption, and the exact steps to mechanically trigger your parasympathetic brake.",
                'interactive_tool_type' => 'box_breathing_embed',
            ]
        );

        // 7. Foundational Peer Squads
        $groups = [
            ['slug' => 'executive-overwhelm', 'name' => 'Executive & Career Isolation', 'description' => 'A squad for high-output professionals managing sustained leadership pressure, focus issues, and burnout.'],
            ['slug' => 'life-transitions-rebuild', 'name' => 'Separation, Divorce & Rebuilding', 'description' => 'Direct, supportive discussions on navigating relationship dissolution, custody battles, and rebuilding purpose.'],
            ['slug' => 'trades-physical-burnout', 'name' => 'Blue-Collar & Physical Labor Recovery', 'description' => 'Managing chronic strain, fatigue, and decompression without turning to alcohol or isolation.'],
        ];

        foreach ($groups as $group) {
            CommunityGroup::firstOrCreate(['slug' => $group['slug']], $group);
        }

        // 8. Test Accounts

        // A. Super Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@mensmentalhealth.local'],
            [
                'password' => Hash::make('Password123!'),
                'auth_type' => 'verified',
                'email_verified_at' => now(),
            ]
        );
        $admin->syncRoles(['super_admin']);
        UserProfile::firstOrCreate(
            ['user_id' => $admin->id],
            ['public_handle' => 'Admin_System', 'avatar_preset_id' => 'admin_shield']
        );

        // B. Verified Clinician
        $clinicianUser = User::firstOrCreate(
            ['email' => 'dr.miller@mensmentalhealth.local'],
            [
                'password' => Hash::make('Password123!'),
                'auth_type' => 'verified',
                'email_verified_at' => now(),
            ]
        );
        $clinicianUser->syncRoles(['clinician']);
        UserProfile::firstOrCreate(
            ['user_id' => $clinicianUser->id],
            ['public_handle' => 'DrMiller_PsyD', 'avatar_preset_id' => 'clinician_caduceus']
        );

        $clinicianProfile = ClinicianProfile::firstOrCreate(
            ['user_id' => $clinicianUser->id],
            [
                'legal_name' => 'Marcus Vance Miller, PsyD',
                'professional_title' => 'Licensed Clinical Psychologist (PsyD)',
                'bio_summary' => 'Specializing in men’s high-stress burnout, first responder trauma, and pragmatic cognitive behavioral protocols.',
                'license_number' => 'PSY-CA-994821',
                'licensing_state_or_jurisdiction' => 'California',
                'license_verified_at' => now(),
                'hourly_rate_cents' => 15000, // $150.00
                'max_weekly_caseload' => 20,
                'is_accepting_clients' => true,
            ]
        );

        // Attach Specialties & Availability to Clinician
        $burnoutSpecialty = Specialty::where('slug', 'executive-work-burnout')->first();
        if ($burnoutSpecialty) {
            $clinicianProfile->specialties()->syncWithoutDetaching([$burnoutSpecialty->id]);
        }

        ClinicianAvailability::firstOrCreate(
            ['clinician_profile_id' => $clinicianProfile->id, 'day_of_week' => 1, 'start_time' => '09:00:00'],
            ['end_time' => '17:00:00', 'is_recurring' => true]
        );

        // C. Pseudonymous Test Member
        $member = User::firstOrCreate(
            ['email' => 'marcus@mensmentalhealth.local'],
            [
                'password' => Hash::make('Password123!'),
                'auth_type' => 'pseudonymous',
                'email_verified_at' => now(),
            ]
        );
        $member->syncRoles(['member']);
        UserProfile::firstOrCreate(
            ['user_id' => $member->id],
            ['public_handle' => 'IronOak_42', 'avatar_preset_id' => 'iron_oak']
        );
    }
}