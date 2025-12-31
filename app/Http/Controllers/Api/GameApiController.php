<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameQuestion;
use Illuminate\Http\Request;

class GameApiController extends Controller
{
    /**
     * HU-07: Obtener partidas publicadas
     */
    public function published()
    {
        $games = Game::with(['teams', 'user'])
            ->where('is_published', true)
            ->where('status', '!=', 'finalizada')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $games
        ]);
    }

    /**
     * HU-08: Obtener tablero de juego
     */
    public function board(Game $game)
    {
        // Verificar que la partida esté publicada
        if (!$game->is_published) {
            return response()->json([
                'success' => false,
                'message' => 'Esta partida no está publicada.'
            ], 403);
        }

        $game->load(['teams', 'currentTurnTeam', 'gameQuestions.question.category']);

        // Agrupar preguntas por categoría
        $categories = $game->gameQuestions()
            ->with('question.category')
            ->get()
            ->groupBy('question.category_id')
            ->map(function ($questions) {
                return [
                    'category' => $questions->first()->question->category,
                    'questions' => $questions->sortBy('question.points')->values(),
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'data' => [
                'game' => $game,
                'categories' => $categories,
            ]
        ]);
    }

    /**
     * HU-09: Actualizar estado de pregunta (marcar como usada)
     */
    public function markQuestionUsed(Game $game, $questionId)
    {
        $gameQuestion = GameQuestion::where('game_id', $game->id)
            ->where('question_id', $questionId)
            ->first();

        if (!$gameQuestion) {
            return response()->json([
                'success' => false,
                'message' => 'Pregunta no encontrada en esta partida.'
            ], 404);
        }

        $gameQuestion->update(['used' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Pregunta marcada como usada.',
            'data' => $gameQuestion
        ]);
    }
}
