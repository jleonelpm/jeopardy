<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Partidas') }}
            </h2>
            <a href="{{ route('games.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nueva Partida
            </a>
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Publicación
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Equipos
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha Creación
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($games as $game)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        #{{ $game->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($game->status === 'preparacion')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Preparación
                                            </span>
                                        @elseif ($game->status === 'en_curso')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                En Curso
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Finalizada
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($game->is_published)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                ✓ Publicada
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                No publicada
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $game->teams->count() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $game->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('games.show', $game) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            Ver
                                        </a>
                                        @if ($game->status === 'en_curso')
                                            <a href="{{ route('games.preview', $game) }}" class="text-purple-600 hover:text-purple-900 mr-3">
                                                Preview
                                            </a>
                                        @endif
                                        @if ($game->is_published)
                                            <a href="{{ route('play.game', $game) }}" target="_blank" class="text-green-600 hover:text-green-900 mr-3">
                                                Jugar
                                            </a>
                                        @endif
                                        @if ($game->status !== 'en_curso')
                                            <form action="{{ route('games.destroy', $game) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold"
                                                    onclick="return confirm('⚠️ ¿Estás seguro de eliminar la partida #{{ $game->id }}?\n\nSe eliminarán:\n• Todos los equipos\n• Todas las preguntas de la partida\n• Todos los registros de turnos\n\nEsta acción no se puede deshacer.')">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No hay partidas registradas
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $games->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
