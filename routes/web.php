<?php

use App\Http\Controllers\SolutionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::middleware(['auth', 'verified'])->group(function () {
    // Profile management
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Subject routes
    Route::controller(SubjectController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name(name: 'dashboard');
        Route::get('/subjects', 'index')->name('subjects.index');
        Route::middleware('role:teacher')->group(function() {
            Route::get('/subjects/create' ,'create')->name('subjects.create');
            Route::post('/subjects', 'store')->name('subjects.store');
        });
        // Subject-specific routes
        Route::get('/subjects/{subject}', 'show')->name('subjects.show');
        Route::middleware('role:teacher')->group(function () {
            Route::get('/subjects/{subject}/edit', 'edit')->name('subjects.edit');
            Route::put('/subjects/{subject}', 'update')->name('subjects.update');
            Route::delete('/subjects/{subject}', 'destroy')->name('subjects.destroy');
        });
        Route::middleware('role:student')->group(function () {
            Route::post('/subjects/{subject}/enroll', 'enroll')->name('subjects.enroll');
            Route::delete('/subjects/{subject}/leave', 'leave')->name('subjects.leave');
        });
    });

    // Task routes
    Route::controller(TaskController::class)->group(function () {
        Route::get('/subjects/{subject}/tasks', 'index')->name('tasks.index');
        Route::middleware('role:teacher')->group(function () {
            Route::get('/subjects/{subject}/tasks/create', 'create')->name('tasks.create');
            Route::post('/subjects/{subject}/tasks', 'store')->name('tasks.store');
        });
        // Task-specific routes
        Route::get('/subjects/{subject}/tasks/{task}', 'show')->name('tasks.show');
        Route::middleware('role:teacher')->group(function () {
            Route::get('/subjects/{subject}/tasks/{task}/edit', 'edit')->name('tasks.edit');
            Route::put('/subjects/{subject}/tasks/{task}', 'update')->name('tasks.update');
            Route::delete('/subjects/{subject}/tasks/{task}', 'destroy')->name('tasks.destroy');
        });
    });

    // Solution routes
    Route::controller(SolutionController::class)->group(function () {
        Route::middleware('role:student')->group(function () {
            Route::get('/subjects/{subject}/tasks/{task}/solutions/create', 'create')->name('solutions.create');
            Route::post('/subjects/{subject}/tasks/{task}/solutions', 'store')->name('solutions.store');
        });
        Route::middleware('role:teacher')->group(function () {
            Route::get('/subjects/{subject}/tasks/{task}/solutions', 'index')->name('solutions.index');
            Route::get('/subjects/{subject}/tasks/{task}/solutions/{solution}', 'show')->name('solutions.show');
            Route::put('/subjects/{subject}/tasks/{task}/solutions/{solution}', 'update')->name('solutions.update');
        });
    });

});

require __DIR__.'/auth.php';
