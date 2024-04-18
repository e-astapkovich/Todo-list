<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\Admin\NoteController as AdminNoteController;

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

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function() {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/notes', NoteController::class);
    Route::patch('/notes/{note}/completed', [NoteController::class, 'completed'])->name('notes.completed');

    Route::prefix('admin')->middleware('is.admin')->group(function() {
        Route::resource('/notes', AdminNoteController::class)
            ->only([
                'index',
                'show',
            ]);
    });
});
