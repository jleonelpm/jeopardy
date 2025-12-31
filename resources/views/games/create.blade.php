<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Partida') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <p class="text-gray-600">
                            Al crear una nueva partida, se generará en estado de <strong>preparación</strong>.
                            Podrás registrar equipos antes de iniciar el juego.
                        </p>
                    </div>

                    <form action="{{ route('games.store') }}" method="POST">
                        @csrf

                        <!-- Configuración del Tablero -->
                        <div class="bg-gray-50 p-6 rounded-lg mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Configuración del Tablero</h3>

                            <!-- Número de filas -->
                            <div class="mb-4">
                                <label for="num_rows" class="block text-gray-700 text-sm font-bold mb-2">
                                    Número de filas (mínimo 3)
                                </label>
                                <input type="number" name="num_rows" id="num_rows" min="3" max="10" value="5"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('num_rows') border-red-500 @enderror">
                                @error('num_rows')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Selección de categorías -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    Categorías del Juego (mínimo 2)
                                </label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-2 max-h-64 overflow-y-auto border border-gray-300 rounded p-3">
                                    @foreach($categories as $category)
                                        <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded cursor-pointer">
                                            <input type="checkbox" name="selected_categories[]" value="{{ $category->id }}"
                                                class="form-checkbox h-4 w-4 text-blue-600">
                                            <span class="text-sm text-gray-700">{{ $category->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('selected_categories')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('games.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Crear Partida
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
