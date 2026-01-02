<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameFrontendController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rutas públicas para el frontend del juego
Route::get('/play', [GameFrontendController::class, 'index'])->name('play.index');
Route::get('/play/{game}', [GameFrontendController::class, 'show'])->name('play.game');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas API para el frontend del juego (no duplicadas con Filament)
    Route::post('games/{game}/teams', [GameController::class, 'storeTeam'])->name('games.teams.store');
    Route::delete('games/{game}/teams/{team}', [GameController::class, 'destroyTeam'])->name('games.teams.destroy');
    Route::post('games/{game}/start', [GameController::class, 'start'])->name('games.start');
    Route::get('games/{game}/preview', [GameController::class, 'preview'])->name('games.preview');
    Route::post('games/{game}/publish', [GameController::class, 'publish'])->name('games.publish');
    Route::post('games/{game}/unpublish', [GameController::class, 'unpublish'])->name('games.unpublish');
});

require __DIR__.'/auth.php';
