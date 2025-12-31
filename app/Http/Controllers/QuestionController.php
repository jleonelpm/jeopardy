<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Category;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::with('category')->latest()->paginate(15);
        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('questions.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        Question::create($request->validated());

        return redirect()->route('questions.index')
            ->with('success', 'Pregunta creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        $question->load('category');
        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        $categories = Category::orderBy('name')->get();
        return view('questions.edit', compact('question', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        // Verificar si la pregunta ya fue usada
        if ($question->is_used) {
            return redirect()->route('questions.index')
                ->with('error', 'No se puede editar una pregunta que ya fue utilizada en una partida.');
        }

        $question->update($request->validated());

        return redirect()->route('questions.index')
            ->with('success', 'Pregunta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        // Verificar si la pregunta ya fue usada
        if ($question->is_used) {
            return redirect()->route('questions.index')
                ->with('error', 'No se puede eliminar una pregunta que ya fue utilizada en una partida.');
        }

        $question->delete();

        return redirect()->route('questions.index')
            ->with('success', 'Pregunta eliminada exitosamente.');
    }
}
