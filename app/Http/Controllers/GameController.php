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
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('games.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGameRequest $request)
    {
        $game = Game::create([
            'user_id' => Auth::id(),
            'status' => 'preparacion',
            'num_rows' => $request->num_rows ?? 5,
            'selected_categories' => $request->selected_categories ?? [],
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

        // Validar configuración del tablero
        $numRows = $game->num_rows ?? 5;
        $selectedCategories = $game->selected_categories ?? [];

        if (count($selectedCategories) < 2) {
            return back()->with('error', 'Debes tener al menos 2 categorías configuradas.');
        }

        $numQuestions = $numRows * count($selectedCategories);

        DB::transaction(function () use ($game, $teams, $selectedCategories, $numRows, $numQuestions) {
            // Obtener preguntas disponibles de las categorías seleccionadas
            $availableQuestions = Question::whereIn('category_id', $selectedCategories)
                ->where('is_used', false)
                ->get();

            if ($availableQuestions->count() < $numQuestions) {
                throw new \Exception('No hay suficientes preguntas disponibles en las categorías seleccionadas.');
            }

            // Agrupar por categoría y seleccionar preguntas aleatoriamente
            $questionsByCategory = $availableQuestions->groupBy('category_id');
            $selectedQuestions = collect();

            foreach ($selectedCategories as $categoryId) {
                $categoryQuestions = $questionsByCategory[$categoryId] ?? collect();

                if ($categoryQuestions->count() < $numRows) {
                    throw new \Exception("No hay suficientes preguntas en la categoría ID {$categoryId}.");
                }

                // Seleccionar preguntas aleatorias sin repetir
                $selected = $categoryQuestions->random($numRows);
                $selectedQuestions = $selectedQuestions->merge($selected);
            }

            // Obtener IDs de preguntas ya asociadas a esta partida
            $existingQuestionIds = $game->gameQuestions()->pluck('question_id')->toArray();

            // Asignar preguntas únicas al tablero
            $usedQuestionIds = [];
            foreach ($selectedQuestions as $question) {
                // Evitar duplicados en la misma asignación
                if (in_array($question->id, $usedQuestionIds)) {
                    continue;
                }

                // Si la pregunta ya existe, solo actualizar su estado
                if (in_array($question->id, $existingQuestionIds)) {
                    $game->gameQuestions()
                        ->where('question_id', $question->id)
                        ->update(['used' => false]);
                } else {
                    // Si es nueva, crear la relación
                    $game->gameQuestions()->create([
                        'question_id' => $question->id,
                        'used' => false,
                    ]);
                }

                $usedQuestionIds[] = $question->id;
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

        if ($game->status === 'preparacion') {
            // Modo simulación: Mostrar vista previa con categorías seleccionadas
            $numRows = $game->num_rows ?? 5;
            $selectedCategories = $game->selected_categories ?? [];

            // Obtener las categorías seleccionadas con preguntas de ejemplo
            $categories = \App\Models\Category::whereIn('id', $selectedCategories)
                ->with(['questions' => function($query) use ($numRows) {
                    $query->where('is_used', false)->limit($numRows);
                }])
                ->get()
                ->map(function ($category) use ($numRows) {
                    $questions = $category->questions->take($numRows);

                    // Simular game_questions para mantener compatibilidad con la vista
                    $simulatedQuestions = $questions->map(function ($question) {
                        return (object) [
                            'id' => $question->id,
                            'question_id' => $question->id,
                            'used' => false,
                            'question' => $question,
                        ];
                    });

                    return [
                        'category' => $category,
                        'questions' => $simulatedQuestions,
                    ];
                });

            return view('games.preview', compact('game', 'categories'));
        }

        // Agrupar preguntas por categoría (modo normal)
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
     * Remove a team from the game.
     */
    public function destroyTeam(Game $game, Team $team)
    {
        if ($game->status !== 'preparacion') {
            return back()->with('error', 'Solo se pueden eliminar equipos durante la preparación.');
        }

        if ($team->game_id !== $game->id) {
            return back()->with('error', 'Este equipo no pertenece a esta partida.');
        }

        $team->delete();

        return back()->with('success', 'Equipo eliminado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        if ($game->status === 'en_curso') {
            return back()->with('error', 'No se puede eliminar una partida en curso.');
        }

        DB::transaction(function () use ($game) {
            // Eliminar turnos relacionados
            \App\Models\Turn::where('game_id', $game->id)->delete();

            // Eliminar preguntas de la partida
            $game->gameQuestions()->delete();

            // Eliminar equipos
            $game->teams()->delete();

            // Eliminar la partida
            $game->delete();
        });

        return redirect()->route('games.index')
            ->with('success', 'Partida y todos sus registros han sido eliminados exitosamente.');
    }
}
