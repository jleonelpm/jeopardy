<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Turn;
use Illuminate\Http\Request;

class TurnApiController extends Controller
{
    /**
     * Registrar un turno (respuesta a una pregunta)
     */
    public function store(Game $game, Request $request)
    {
        $request->validate([
            'team_id' => 'required|exists:teams,id',
            'question_id' => 'required|exists:questions,id',
            'is_correct' => 'required|boolean',
            'points_awarded' => 'required|integer',
        ]);

        $turn = Turn::create([
            'game_id' => $game->id,
            'team_id' => $request->team_id,
            'question_id' => $request->question_id,
            'is_correct' => $request->is_correct,
            'points_awarded' => $request->points_awarded,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Turno registrado exitosamente.',
            'data' => $turn->load(['team', 'question'])
        ], 201);
    }

    /**
     * Obtener el turno actual
     */
    public function currentTurn(Game $game)
    {
        $game->load('currentTurnTeam');

        return response()->json([
            'success' => true,
            'data' => [
                'current_team' => $game->currentTurnTeam,
                'game_status' => $game->status,
            ]
        ]);
    }

    /**
     * Cambiar al siguiente turno
     */
    public function nextTurn(Game $game, Request $request)
    {
        $request->validate([
            'next_team_id' => 'required|exists:teams,id',
        ]);

        $game->update([
            'current_turn_team_id' => $request->next_team_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Turno cambiado exitosamente.',
            'data' => $game->load('currentTurnTeam')
        ]);
    }
}
