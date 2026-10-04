<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Onboarding\IntakeWizard;
use App\Livewire\Tools\BreathingEngine;
use App\Livewire\Assessments\TakeAssessment;
use App\Livewire\Programs\ProgramIndex;
use App\Livewire\Programs\LessonViewer;
use App\Livewire\Community\SquadFeed;
use App\Livewire\Directory\ClinicianSearch;

Route::get('/onboarding', IntakeWizard::class)->name('onboarding');Route::get('/programs', ProgramIndex::class)->name('programs.index');
Route::get('/programs/lesson/{slug}', LessonViewer::class)->name('programs.lesson');
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::get('/directory', ClinicianSearch::class)->name('directory.index');
Route::get('/squads', SquadFeed::class)->name('squads.index');
Route::get('/assessments/phq-9', TakeAssessment::class)->name('assessments.phq9');
Route::get('/tools/breathing', BreathingEngine::class)->name('tools.breathing');
Route::get('/', function () {
    return view('welcome');
});
