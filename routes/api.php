<?php

use App\Http\Controllers\Api\GameApiController;
use App\Http\Controllers\Api\TeamApiController;
use App\Http\Controllers\Api\TurnApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// HU-07: Obtener partidas publicadas
Route::get('/games/published', [GameApiController::class, 'published']);

// HU-08: Obtener tablero de juego
Route::get('/games/{game}/board', [GameApiController::class, 'board']);

// HU-09: Actualizar estado de pregunta
Route::patch('/games/{game}/questions/{question}/mark-used', [GameApiController::class, 'markQuestionUsed']);

// HU-10: Actualizar puntajes
Route::patch('/teams/{team}/score', [TeamApiController::class, 'updateScore']);

// Gestión de turnos
Route::post('/games/{game}/turns', [TurnApiController::class, 'store']);
Route::get('/games/{game}/current-turn', [TurnApiController::class, 'currentTurn']);
Route::patch('/games/{game}/next-turn', [TurnApiController::class, 'nextTurn']);
