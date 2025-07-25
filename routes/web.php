<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\web\BlogController;
use App\Http\Controllers\web\NoteController;
use App\Http\Controllers\web\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Task routes
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/{id}/edit', [TaskController::class, 'update'])->name('tasks.update');
    Route::get('/tasks/all', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/calendar', [TaskController::class, 'calendar'])->name('tasks.calendar');

    // Note routes
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');

    //  BLog routes
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
});

require __DIR__ . '/auth.php';
