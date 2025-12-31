<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jeopardy - Juego en Vivo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-900 text-white">
    <div id="app" data-game-id="{{ $game->id }}">
        <div class="min-h-screen flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Cargando Jeopardy...</h1>
                <p class="text-gray-400">Partida #{{ $game->id }}</p>
            </div>
        </div>
    </div>
</body>
</html>
