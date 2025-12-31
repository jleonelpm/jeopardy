<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Pregunta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('questions.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">
                                Categoría *
                            </label>
                            <select name="category_id" id="category_id"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('category_id') border-red-500 @enderror"
                                required>
                                <option value="">Seleccione una categoría</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="question_text" class="block text-gray-700 text-sm font-bold mb-2">
                                Pregunta *
                            </label>
                            <textarea name="question_text" id="question_text" rows="3"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('question_text') border-red-500 @enderror"
                                required>{{ old('question_text') }}</textarea>
                            @error('question_text')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="correct_answer" class="block text-gray-700 text-sm font-bold mb-2">
                                Respuesta Correcta *
                            </label>
                            <textarea name="correct_answer" id="correct_answer" rows="2"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('correct_answer') border-red-500 @enderror"
                                required>{{ old('correct_answer') }}</textarea>
                            @error('correct_answer')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="points" class="block text-gray-700 text-sm font-bold mb-2">
                                    Puntos *
                                </label>
                                <select name="points" id="points"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('points') border-red-500 @enderror"
                                    required>
                                    <option value="">Seleccione puntos</option>
                                    <option value="100" {{ old('points') == 100 ? 'selected' : '' }}>100</option>
                                    <option value="200" {{ old('points') == 200 ? 'selected' : '' }}>200</option>
                                    <option value="300" {{ old('points') == 300 ? 'selected' : '' }}>300</option>
                                    <option value="400" {{ old('points') == 400 ? 'selected' : '' }}>400</option>
                                    <option value="500" {{ old('points') == 500 ? 'selected' : '' }}>500</option>
                                </select>
                                @error('points')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="time_limit" class="block text-gray-700 text-sm font-bold mb-2">
                                    Tiempo Límite (segundos) *
                                </label>
                                <input type="number" name="time_limit" id="time_limit" value="{{ old('time_limit', 30) }}"
                                    min="10" max="300"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('time_limit') border-red-500 @enderror"
                                    required>
                                @error('time_limit')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('questions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Crear Pregunta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
