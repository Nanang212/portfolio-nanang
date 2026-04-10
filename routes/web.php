<?php

use App\Http\Controllers\Admin\AboutMeCrudController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExperienceCrudController;
use App\Http\Controllers\Admin\ProjectCrudController;
use App\Http\Controllers\Admin\SkillCrudController;
use App\Http\Controllers\Portfolio\AboutController;
use App\Http\Controllers\Portfolio\ContactController;
use App\Http\Controllers\Portfolio\ExperienceController;
use App\Http\Controllers\Portfolio\HomeController;
use App\Http\Controllers\Portfolio\ProjectController;
use App\Http\Controllers\Portfolio\SkillController;
use Illuminate\Support\Facades\Route;

// ─── Public Portfolio Routes ──────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/experience', [ExperienceController::class, 'index'])->name('experience');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
Route::get('/skills', [SkillController::class, 'index'])->name('skills');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// ─── Admin Dashboard Routes ──────────────────────────────────────────────────
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Projects
    Route::post('/projects/reorder', [ProjectCrudController::class, 'reorder'])->name('projects.reorder');
    Route::get('/projects', [ProjectCrudController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectCrudController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectCrudController::class, 'store'])->name('projects.store');
    Route::get('/projects/{id}/edit', [ProjectCrudController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{id}', [ProjectCrudController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{id}', [ProjectCrudController::class, 'destroy'])->name('projects.destroy');
    Route::post('/projects/{id}/toggle-publish', [ProjectCrudController::class, 'togglePublish'])->name('projects.toggle-publish');

    // Experiences
    Route::post('/experiences/reorder', [ExperienceCrudController::class, 'reorder'])->name('experiences.reorder');
    Route::get('/experiences', [ExperienceCrudController::class, 'index'])->name('experiences.index');
    Route::get('/experiences/create', [ExperienceCrudController::class, 'create'])->name('experiences.create');
    Route::post('/experiences', [ExperienceCrudController::class, 'store'])->name('experiences.store');
    Route::get('/experiences/{id}/edit', [ExperienceCrudController::class, 'edit'])->name('experiences.edit');
    Route::put('/experiences/{id}', [ExperienceCrudController::class, 'update'])->name('experiences.update');
    Route::delete('/experiences/{id}', [ExperienceCrudController::class, 'destroy'])->name('experiences.destroy');

    // Skills
    Route::get('/skills', [SkillCrudController::class, 'index'])->name('skills.index');
    Route::get('/skills/create', [SkillCrudController::class, 'create'])->name('skills.create');
    Route::post('/skills', [SkillCrudController::class, 'store'])->name('skills.store');
    Route::get('/skills/{id}/edit', [SkillCrudController::class, 'edit'])->name('skills.edit');
    Route::put('/skills/{id}', [SkillCrudController::class, 'update'])->name('skills.update');
    Route::delete('/skills/{id}', [SkillCrudController::class, 'destroy'])->name('skills.destroy');

    // About Me
    Route::get('/about', [AboutMeCrudController::class, 'edit'])->name('about.edit');
    Route::put('/about', [AboutMeCrudController::class, 'update'])->name('about.update');

    // Messages
    Route::get('/messages', [ContactMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [ContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{id}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');
});

require __DIR__ . '/auth.php';
