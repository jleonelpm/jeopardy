<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Moderador - Jeopardy Educativo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-indigo-600">Jeopardy Educativo</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Bienvenido, <strong>{{ auth()->user()->name }}</strong></span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button
                            type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200"
                        >
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Panel de Control del Moderador</h2>
            <p class="text-gray-600 mt-2">Gestiona categorías, preguntas y partidas de Jeopardy</p>
        </div>

        <!-- Opciones principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Crear Nueva Partida -->
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                <div class="p-6">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Nueva Partida</h3>
                    <p class="text-gray-600 text-sm mb-4">Inicia una nueva partida de Jeopardy con tu contenido</p>
                    <a href="#" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                        Crear Partida
                    </a>
                </div>
            </div>

            <!-- Gestionar Categorías -->
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                <div class="p-6">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.972 1.972 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Gestionar Categorías</h3>
                    <p class="text-gray-600 text-sm mb-4">Crea y organiza categorías para tus preguntas</p>
                    <a href="#" class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded transition">
                        Ir a Categorías
                    </a>
                </div>
            </div>

            <!-- Gestionar Preguntas -->
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                <div class="p-6">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-yellow-500 text-white mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Gestionar Preguntas</h3>
                    <p class="text-gray-600 text-sm mb-4">Crea, edita y organiza las preguntas del banco</p>
                    <a href="#" class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded transition">
                        Ir a Preguntas
                    </a>
                </div>
            </div>

            <!-- Ver Partidas -->
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                <div class="p-6">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-purple-500 text-white mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Ver Partidas</h3>
                    <p class="text-gray-600 text-sm mb-4">Visualiza el historial y resultados de partidas</p>
                    <a href="#" class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded transition">
                        Ver Partidas
                    </a>
                </div>
            </div>

            <!-- Configuración -->
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                <div class="p-6">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-gray-500 text-white mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Configuración</h3>
                    <p class="text-gray-600 text-sm mb-4">Ajusta la configuración de tu cuenta y preferencias</p>
                    <a href="#" class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded transition">
                        Configurar
                    </a>
                </div>
            </div>

            <!-- Documentación -->
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                <div class="p-6">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.748 10-10.747S17.5 6.253 12 6.253z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Ayuda y Documentación</h3>
                    <p class="text-gray-600 text-sm mb-4">Consulta la documentación sobre cómo usar la plataforma</p>
                    <a href="#" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded transition">
                        Ver Ayuda
                    </a>
                </div>
            </div>
        </div>

        <!-- Información de la sesión -->
        <div class="mt-12 p-6 bg-blue-50 border border-blue-200 rounded-lg">
            <h3 class="text-lg font-semibold text-blue-900 mb-4">Información de tu Cuenta</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-blue-700">Nombre:</p>
                    <p class="text-base text-blue-900">{{ auth()->user()->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-blue-700">Email:</p>
                    <p class="text-base text-blue-900">{{ auth()->user()->email }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-blue-700">Rol:</p>
                    <p class="text-base text-blue-900">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-blue-700">Miembro desde:</p>
                    <p class="text-base text-blue-900">{{ auth()->user()->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
