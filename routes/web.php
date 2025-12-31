<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\GameController;
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

    // Rutas de recursos para gestión de contenido
    Route::resource('categories', CategoryController::class);
    Route::resource('questions', QuestionController::class);

    // Rutas de recursos para gestión de partidas
    Route::resource('games', GameController::class)->except(['edit', 'update']);
    Route::post('games/{game}/teams', [GameController::class, 'storeTeam'])->name('games.teams.store');
    Route::post('games/{game}/start', [GameController::class, 'start'])->name('games.start');
    Route::get('games/{game}/board', [GameController::class, 'board'])->name('games.board');
});

require __DIR__.'/auth.php';
