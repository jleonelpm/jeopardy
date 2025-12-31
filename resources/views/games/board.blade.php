<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tablero - Partida #') }}{{ $game->id }}
            </h2>
            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                En Curso
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Turno actual -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Turno Actual</p>
                            <h3 class="text-2xl font-bold" style="color: {{ $game->currentTurnTeam->color }}">
                                {{ $game->currentTurnTeam->name }}
                            </h3>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Puntaje</p>
                            <p class="text-3xl font-bold">{{ $game->currentTurnTeam->score }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Puntajes de todos los equipos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Puntajes</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach ($game->teams->sortByDesc('score') as $team)
                            <div class="border-l-4 pl-4 py-2" style="border-color: {{ $team->color }}">
                                <p class="font-semibold">{{ $team->name }}</p>
                                <p class="text-2xl font-bold">{{ $team->score }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Tablero de preguntas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Tablero Jeopardy</h3>

                    @if ($categories->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full border-collapse">
                                <thead>
                                    <tr>
                                        @foreach ($categories as $categoryData)
                                            <th class="border border-gray-300 bg-blue-600 text-white p-4 text-center font-bold">
                                                {{ $categoryData['category']->name }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < 5; $i++)
                                        <tr>
                                            @foreach ($categories as $categoryData)
                                                @php
                                                    $gameQuestion = $categoryData['questions']->values()->get($i);
                                                @endphp
                                                <td class="border border-gray-300 p-2 text-center">
                                                    @if ($gameQuestion)
                                                        @if ($gameQuestion->used)
                                                            <div class="bg-gray-300 text-gray-500 p-8 rounded text-2xl font-bold">
                                                                -
                                                            </div>
                                                        @else
                                                            <button class="bg-blue-500 hover:bg-blue-700 text-white p-8 rounded w-full text-2xl font-bold">
                                                                ${{ $gameQuestion->question->points }}
                                                            </button>
                                                        @endif
                                                    @else
                                                        <div class="bg-gray-100 p-8 rounded">
                                                            <span class="text-gray-400">-</span>
                                                        </div>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No hay preguntas disponibles para esta partida.</p>
                    @endif
                </div>
            </div>

            <!-- Acciones -->
            <div class="mt-6 flex justify-between">
                <a href="{{ route('games.show', $game) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver a Detalles
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
