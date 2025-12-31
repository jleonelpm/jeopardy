<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Partidas Disponibles - Jeopardy</title>
    @vite(['resources/css/app.css'])
</head>
<body class="antialiased bg-gray-900 text-white min-h-screen">
    <div class="max-w-7xl mx-auto py-12 px-4">
        <h1 class="text-5xl font-bold text-center mb-8 text-yellow-400">JEOPARDY!</h1>
        <p class="text-center text-gray-400 mb-12">Selecciona una partida para jugar</p>

        @if ($games->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($games as $game)
                    <a href="{{ route('play.game', $game) }}"
                       class="bg-gray-800 hover:bg-gray-700 rounded-lg p-6 shadow-lg transition transform hover:scale-105">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-white">Partida #{{ $game->id }}</h3>
                                <p class="text-sm text-gray-400">Creada por {{ $game->user->name }}</p>
                            </div>
                            <span class="px-2 py-1 bg-green-600 text-xs rounded">EN VIVO</span>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Equipos:</span>
                                <span class="text-white font-semibold">{{ $game->teams->count() }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Estado:</span>
                                <span class="text-green-400">En Curso</span>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-700">
                            <p class="text-center text-blue-400 font-semibold">Hacer clic para jugar →</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="text-6xl mb-4">🎮</div>
                <p class="text-xl text-gray-400 mb-2">No hay partidas disponibles en este momento</p>
                <p class="text-sm text-gray-500">Las partidas aparecerán aquí cuando el moderador las publique</p>
            </div>
        @endif

        <div class="mt-12 text-center">
            <a href="/" class="text-blue-400 hover:text-blue-300 underline">
                ← Volver al inicio
            </a>
        </div>
    </div>
</body>
</html>
