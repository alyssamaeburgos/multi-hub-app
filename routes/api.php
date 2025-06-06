<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// PUBLIC ROUTES
Route::get('blogs', [BlogController::class, 'index']);


Route::post('/login', [AuthenticatedSessionController::class, 'apiLogin']);


// AUTH SANCTUM ROUTES
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Task API routes
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::post('/', [TaskController::class, 'store'])->name('store');
        Route::get('/', [TaskController::class, 'index'])->name('list');
        Route::get('/{id}', [TaskController::class, 'show'])->name('show');
        Route::put('/{id}', [TaskController::class, 'update'])->name('update');
        Route::delete('/{id}', [TaskController::class, 'destroy'])->name('delete');
    });

    // Note API routes
    Route::prefix('notes')->name('notes.')->group(function () {
        Route::get('/', [NoteController::class, 'index'])->name('index');
        Route::post('/', [NoteController::class, 'store'])->name('store');
        Route::put('/{id}', [NoteController::class, 'update'])->name('update');
        Route::delete('/{id}', [NoteController::class, 'destroy'])->name('destroy');
        Route::get('/search', [NoteController::class, 'search'])->name('search');
    });

    // Blog API routes
    // Route::prefix('blogs')->name('blogs.')->group(function () {
    //     // Route::get('/', [BlogController::class, 'index'])->name('index');
    //     Route::get('/user/blogs', [BlogController::class, 'userBlogs'])->name('user_blogs');
    //     Route::post('/', [BlogController::class, 'store'])->name('store');
    //     Route::get('/{blog}', [BlogController::class, 'show'])->name('show'); // Using implicit binding
    //     Route::put('/{blog}', [BlogController::class, 'update'])->name('update'); // Using implicit binding
    //     Route::delete('/{blog}', [BlogController::class, 'destroy'])->name('destroy'); // Using implicit binding
    // });
    Route::apiResource('blogs', BlogController::class)->except(['index']);
    Route::get('blogs/{blog}/comments', [CommentController::class, 'index']);
    Route::post('blogs/{blog}/comments', [CommentController::class, 'store']);
    Route::delete('comments/{comment}', [CommentController::class, 'destroy']);
    Route::get('user/blogs', [BlogController::class, 'userBlogs']);

    // Comments API Routes
    Route::prefix('comments')->name('comments.')->group(function () {
        // Route::get('/', [CommentController::class, 'index'])->name('index');
    });
});

Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return response()->json($request->user());
});
