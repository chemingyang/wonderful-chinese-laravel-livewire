<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

Route::middleware('auth')->group(function () {
    Route::get('courses', \App\Livewire\Course\CourseIndex::class)->name('courses.index');
    Route::get('courses/create', \App\Livewire\Course\CourseCreate::class)->name('courses.create');
    Route::get('courses/{course}/edit', \App\Livewire\Course\CourseEdit::class)->name('courses.edit');
    // Route::get('courses/{course:slug}', \App\Livewire\Course\CourseShow::class)->name('courses.show');
    Route::get('lessons', \App\Livewire\Lesson\LessonIndex::class)->name('lessons.index');
    Route::get('lessons/create', \App\Livewire\Lesson\LessonCreate::class)->name('lessons.create');
    Route::get('lessons/{lesson}/edit', \App\Livewire\Lesson\LessonEdit::class)->name('lessons.edit');
    // Route::get('lessons/{lesson:slug}', \App\Livewire\Lesson\LessonShow::class)->name('lessons.show');
});

require __DIR__.'/auth.php';
