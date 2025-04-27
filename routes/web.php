<?php

use App\Http\Controllers\SolutionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('subjects.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Both teachers and students
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Subjects - View only
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::get('/subjects/{subject}', [SubjectController::class, 'show'])->name('subjects.show');
    
    // Tasks - View only
    Route::get('/subjects/{subject}/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/subjects/{subject}/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
});

// Teacher
Route::middleware(['auth','verified','role:teacher'])->group(function () {
    // Subjects - Create, Update, Delete
    Route::get('/subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
    Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
    Route::get('/subjects/{subject}/edit', [SubjectController::class, 'edit'])->name('subjects.edit');
    Route::put('/subjects/{subject}', [SubjectController::class, 'update'])->name('subjects.update');
    Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy');
    
    // Tasks - Create, Update, Delete
    Route::get('/subjects/{subject}/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/subjects/{subject}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/subjects/{subject}/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/subjects/{subject}/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/subjects/{subject}/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    
    // Solutions - View and evaluate
    Route::get('/subjects/{subject}/tasks/{task}/solutions', [SolutionController::class, 'index'])->name('solutions.index');
    Route::get('/subjects/{subject}/tasks/{task}/solutions/{solution}', [SolutionController::class, 'show'])->name('solutions.show');
    Route::put('/subjects/{subject}/tasks/{task}/solutions/{solution}', [SolutionController::class, 'update'])->name('solutions.update');
});

// Student
Route::middleware(['auth','verified','role:student'])->group(function () {
    // Subject enrollment
    Route::post('/subjects/{subject}/enroll', [SubjectController::class, 'enroll'])->name('subjects.enroll');
    Route::delete('/subjects/{subject}/leave', [SubjectController::class, 'leave'])->name('subjects.leave');
    
    // Solutions - Submit
    Route::get('/subjects/{subject}/tasks/{task}/solutions/create', [SolutionController::class, 'create'])->name('solutions.create');
    Route::post('/subjects/{subject}/tasks/{task}/solutions', [SolutionController::class, 'store'])->name('solutions.store');
});

require __DIR__.'/auth.php';
