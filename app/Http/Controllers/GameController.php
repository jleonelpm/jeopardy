<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\StoreTeamRequest;
use App\Models\Game;
use App\Models\Team;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::with(['user', 'teams'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('games.index', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('games.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGameRequest $request)
    {
        $game = Game::create([
            'user_id' => Auth::id(),
            'status' => 'preparacion',
            'current_turn_team_id' => null,
            'started_at' => null,
            'ended_at' => null,
        ]);

        return redirect()->route('games.show', $game)
            ->with('success', 'Partida creada exitosamente. Ahora puedes registrar equipos.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        $game->load(['teams', 'user']);

        return view('games.show', compact('game'));
    }

    /**
     * Store a team for the game.
     */
    public function storeTeam(StoreTeamRequest $request, Game $game)
    {
        if ($game->status !== 'preparacion') {
            return back()->with('error', 'No se pueden agregar equipos a una partida en curso o finalizada.');
        }

        Team::create([
            'game_id' => $game->id,
            'name' => $request->name,
            'color' => $request->color,
            'score' => 0,
        ]);

        return back()->with('success', 'Equipo registrado exitosamente.');
    }

    /**
     * Start the game.
     */
    public function start(Game $game)
    {
        if ($game->status !== 'preparacion') {
            return back()->with('error', 'Esta partida ya ha sido iniciada.');
        }

        $teams = $game->teams;

        if ($teams->count() < 2) {
            return back()->with('error', 'Debes registrar al menos 2 equipos para iniciar la partida.');
        }

        DB::transaction(function () use ($game, $teams) {
            // Asignar todas las preguntas disponibles a la partida
            $questions = Question::where('is_used', false)->get();

            foreach ($questions as $question) {
                $game->gameQuestions()->create([
                    'question_id' => $question->id,
                    'used' => false,
                ]);
            }

            // Iniciar partida y asignar primer turno
            $game->update([
                'status' => 'en_curso',
                'started_at' => now(),
                'current_turn_team_id' => $teams->first()->id,
            ]);
        });

        return redirect()->route('games.preview', $game)
            ->with('success', 'Partida iniciada exitosamente.');
    }

    /**
     * HU-05: Vista previa del tablero (solo visualización)
     */
    public function preview(Game $game)
    {
        $game->load(['teams', 'currentTurnTeam', 'gameQuestions.question.category']);

        // Agrupar preguntas por categoría
        $categories = $game->gameQuestions()
            ->with('question.category')
            ->get()
            ->groupBy('question.category_id')
            ->map(function ($questions) {
                return [
                    'category' => $questions->first()->question->category,
                    'questions' => $questions->sortBy('question.points'),
                ];
            });

        return view('games.preview', compact('game', 'categories'));
    }

    /**
     * HU-06: Publicar partida para permitir juego desde frontend
     */
    public function publish(Game $game)
    {
        if ($game->status !== 'en_curso') {
            return back()->with('error', 'Solo se pueden publicar partidas en curso.');
        }

        if ($game->gameQuestions()->count() === 0) {
            return back()->with('error', 'La partida debe tener preguntas asignadas antes de publicarse.');
        }

        $game->update(['is_published' => true]);

        return back()->with('success', 'Partida publicada exitosamente. Ahora es accesible desde el frontend.');
    }

    /**
     * HU-06: Despublicar partida
     */
    public function unpublish(Game $game)
    {
        $game->update(['is_published' => false]);

        return back()->with('success', 'Partida despublicada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        if ($game->status === 'en_curso') {
            return back()->with('error', 'No se puede eliminar una partida en curso.');
        }

        $game->delete();

        return redirect()->route('games.index')
            ->with('success', 'Partida eliminada exitosamente.');
    }
}
