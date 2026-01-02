<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Partida #') }}{{ $game->id }}
            </h2>
            <div>
                @if ($game->status === 'preparacion')
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        Preparación
                    </span>
                @elseif ($game->status === 'en_curso')
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                        En Curso
                    </span>
                @else
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                        Finalizada
                    </span>
                @endif
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

            <!-- Información de la partida -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Información de la Partida</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Moderador</p>
                            <p class="font-semibold">{{ $game->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Fecha de Creación</p>
                            <p class="font-semibold">{{ $game->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @if ($game->started_at)
                            <div>
                                <p class="text-sm text-gray-600">Fecha de Inicio</p>
                                <p class="font-semibold">{{ $game->started_at->format('d/m/Y H:i') }}</p>
                            </div>
                        @endif
                        @if ($game->ended_at)
                            <div>
                                <p class="text-sm text-gray-600">Fecha de Finalización</p>
                                <p class="font-semibold">{{ $game->ended_at->format('d/m/Y H:i') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Equipos registrados -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Equipos Registrados ({{ $game->teams->count() }})</h3>
                        @if ($game->status === 'preparacion')
                            <button onclick="document.getElementById('teamFormModal').classList.remove('hidden')"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Agregar Equipo
                            </button>
                        @endif
                    </div>

                    @if ($game->teams->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($game->teams as $team)
                                <div class="border rounded-lg p-4 relative" style="border-color: {{ $team->color }}; border-width: 3px;">
                                    @if ($game->status === 'preparacion')
                                        <form action="{{ route('games.teams.destroy', [$game, $team]) }}" method="POST" class="absolute top-2 right-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs"
                                                onclick="return confirm('¿Estás seguro de eliminar el equipo {{ $team->name }}?')">
                                                ✕
                                            </button>
                                        </form>
                                    @endif
                                    <div class="flex items-center justify-between">
                                        <div class="pr-8">
                                            <h4 class="font-semibold text-lg">{{ $team->name }}</h4>
                                            <p class="text-sm text-gray-600">Color: <span class="font-semibold" style="color: {{ $team->color }}">{{ $team->color }}</span></p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold">{{ $team->score }}</p>
                                            <p class="text-xs text-gray-600">puntos</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No hay equipos registrados aún.</p>
                    @endif
                </div>
            </div>

            <!-- Acciones -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center gap-4">
                        <a href="{{ route('games.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Volver a Partidas
                        </a>

                        <div class="flex gap-2">
                            @if ($game->status === 'preparacion')
                                <a href="{{ route('games.preview', $game) }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                    Vista Previa
                                </a>

                                <form action="{{ route('games.start', $game) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                        @if($game->teams->count() < 2) disabled title="Se requieren al menos 2 equipos" @endif>
                                        Iniciar Partida
                                    </button>
                                </form>
                            @elseif ($game->status === 'en_curso')
                                <a href="{{ route('games.preview', $game) }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                    Vista Previa
                                </a>

                                @if (!$game->is_published)
                                    <form action="{{ route('games.publish', $game) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            Publicar Partida
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('games.unpublish', $game) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                            Despublicar
                                        </button>
                                    </form>
                                    <span class="px-3 py-2 text-sm font-semibold rounded bg-green-100 text-green-800">
                                        ✓ Publicada
                                    </span>
                                @endif
                            @else
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar equipo -->
    <div id="teamFormModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Registrar Nuevo Equipo</h3>
                <form action="{{ route('games.teams.store', $game) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                            Nombre del Equipo *
                        </label>
                        <input type="text" name="name" id="name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="color" class="block text-gray-700 text-sm font-bold mb-2">
                            Color del Equipo *
                        </label>
                        <select name="color" id="color"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                            <option value="">Seleccione un color</option>
                            <option value="red" style="color: red;">Rojo</option>
                            <option value="blue" style="color: blue;">Azul</option>
                            <option value="green" style="color: green;">Verde</option>
                            <option value="yellow" style="color: orange;">Amarillo</option>
                            <option value="purple" style="color: purple;">Morado</option>
                            <option value="orange" style="color: darkorange;">Naranja</option>
                            <option value="pink" style="color: pink;">Rosa</option>
                            <option value="cyan" style="color: cyan;">Cian</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="button" onclick="document.getElementById('teamFormModal').classList.add('hidden')"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Cancelar
                        </button>
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Registrar Equipo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
