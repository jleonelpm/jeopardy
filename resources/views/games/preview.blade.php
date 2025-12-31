<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Vista Previa del Tablero - Partida #') }}{{ $game->id }}
            </h2>
            <div class="flex gap-2 items-center">
                @if ($game->is_published)
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                        ✓ Publicada
                    </span>
                @endif
                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                    Solo Vista Previa
                </span>
            </div>
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

            <!-- Nota informativa -->
            <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded">
                <p class="font-semibold">💡 Vista Previa del Backend</p>
                @if ($game->status === 'preparacion')
                    <p class="text-sm">Esta es una simulación del tablero basada en tu configuración. Las preguntas mostradas son ejemplos de las categorías seleccionadas.</p>
                    <p class="text-sm mt-1">
                        <strong>Estado:</strong> Preparación | <strong>Configuración:</strong> {{ $categories->count() }} categorías × {{ $game->num_rows ?? 5 }} filas
                    </p>
                @else
                    <p class="text-sm">Esta es una vista previa para verificar la configuración. Para jugar, publica la partida y accede desde el frontend.</p>
                    <p class="text-sm mt-1">
                        <strong>Configuración:</strong> {{ $categories->count() }} categorías × {{ $game->num_rows ?? 5 }} filas
                    </p>
                @endif
            </div>

            @if ($game->status !== 'preparacion')
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
            @if ($game->teams->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Equipos Registrados</h3>
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
            @endif
            @endif

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
                                    @php
                                        $numRows = $game->num_rows ?? 5;
                                    @endphp
                                    @for ($i = 0; $i < $numRows; $i++)
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
