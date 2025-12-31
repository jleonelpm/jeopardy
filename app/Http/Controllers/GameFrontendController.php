<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameFrontendController extends Controller
{
    /**
     * HU-11: Visualizar tablero Jeopardy en el frontend
     * Solo muestra partidas publicadas
     */
    public function show(Game $game)
    {
        // Verificar que la partida esté publicada
        if (!$game->is_published) {
            abort(403, 'Esta partida no está disponible para jugar.');
        }

        // Verificar que la partida esté en curso
        if ($game->status !== 'en_curso') {
            abort(403, 'Esta partida no está activa.');
        }

        return view('game-frontend', compact('game'));
    }

    /**
     * Lista de partidas publicadas disponibles para jugar
     */
    public function index()
    {
        $games = Game::where('is_published', true)
            ->where('status', 'en_curso')
            ->with(['teams', 'user'])
            ->latest()
            ->get();

        return view('games-list', compact('games'));
    }
}
