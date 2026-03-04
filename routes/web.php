<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Task Management Routes
    Route::get('/tasks', function () {
        return view('tasks.index');
    })->name('tasks.index');

    Route::get('/api/tasks', [TaskController::class, 'index'])->name('api.tasks.index');
    Route::post('/api/tasks', [TaskController::class, 'store'])->name('api.tasks.store');
    Route::put('/api/tasks/{task}', [TaskController::class, 'update'])->name('api.tasks.update');
    Route::delete('/api/tasks/{task}', [TaskController::class, 'destroy'])->name('api.tasks.destroy');
    Route::post('/api/tasks/reorder', [TaskController::class, 'reorder'])->name('api.tasks.reorder');

    Route::get('/api/projects', [ProjectController::class, 'index'])->name('api.projects.index');
    Route::post('/api/projects', [ProjectController::class, 'store'])->name('api.projects.store');
    Route::put('/api/projects/{project}', [ProjectController::class, 'update'])->name('api.projects.update');
    Route::delete('/api/projects/{project}', [ProjectController::class, 'destroy'])->name('api.projects.destroy');
});

require __DIR__.'/auth.php';
