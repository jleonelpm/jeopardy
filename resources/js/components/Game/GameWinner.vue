<template>
    <Transition name="winner-appear">
        <div class="fixed inset-0 bg-gray-900 flex items-center justify-center z-50 p-2 sm:p-4 overflow-y-auto">
            <!-- Partículas de fondo -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute w-2 h-2 bg-yellow-400 rounded-full animate-float" style="top: 10%; left: 20%; animation-delay: 0s;"></div>
                <div class="absolute w-3 h-3 bg-blue-400 rounded-full animate-float" style="top: 70%; left: 80%; animation-delay: 1s;"></div>
                <div class="absolute w-2 h-2 bg-purple-400 rounded-full animate-float" style="top: 30%; left: 60%; animation-delay: 2s;"></div>
                <div class="absolute w-4 h-4 bg-pink-400 rounded-full animate-float" style="top: 80%; left: 30%; animation-delay: 1.5s;"></div>
                <div class="absolute w-2 h-2 bg-green-400 rounded-full animate-float" style="top: 50%; left: 10%; animation-delay: 0.5s;"></div>
            </div>

            <Transition name="winner-scale">
                <div class="text-center max-w-3xl w-full relative z-10 my-auto">
                    <!-- Animación de trofeo con múltiples iconos -->
                    <div class="mb-4 sm:mb-8 flex justify-center gap-2 sm:gap-4 text-4xl sm:text-6xl">
                        <span class="animate-bounce" style="animation-delay: 0s;">🎉</span>
                        <span class="animate-bounce" style="animation-delay: 0.1s;">🏆</span>
                        <span class="animate-bounce" style="animation-delay: 0.2s;">🎊</span>
                    </div>

                    <!-- Título con gradiente -->
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black mb-3 sm:mb-4 bg-gradient-to-r from-yellow-400 via-orange-500 to-yellow-400 bg-clip-text text-transparent animate-pulse drop-shadow-2xl px-4" style="font-family: 'Impact', sans-serif;">
                        ¡PARTIDA FINALIZADA!
                    </h1>
                    <div class="h-1 w-32 sm:w-48 md:w-64 mx-auto bg-gradient-to-r from-transparent via-yellow-400 to-transparent mb-6 sm:mb-10 rounded-full"></div>

                    <!-- Equipo ganador con diseño mejorado -->
                    <div class="mb-6 sm:mb-10 p-6 sm:p-8 md:p-10 rounded-2xl border-4 shadow-2xl relative overflow-hidden transition-transform bg-gradient-to-br from-blue-700 to-blue-800"
                         :style="{
                             borderColor: winnerTeam.color,
                             boxShadow: `0 0 40px ${winnerTeam.color}`
                         }">
                        <!-- Efecto de brillo -->
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent transform -skew-x-12 animate-shimmer"></div>

                        <div class="relative z-10">
                            <!-- Corona animada -->
                            <div class="text-5xl sm:text-6xl md:text-7xl mb-3 sm:mb-4 animate-bounce-slow">👑</div>

                            <p class="text-yellow-300 text-sm sm:text-base md:text-lg mb-2 sm:mb-3 uppercase tracking-widest font-bold flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                EQUIPO GANADOR
                            </p>
                            <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-black mb-4 sm:mb-5 md:mb-6 drop-shadow-2xl animate-pulse-slow px-2 break-words"
                                :style="{ color: winnerTeam.color, textShadow: `0 0 30px ${winnerTeam.color}` }">
                                {{ winnerTeam.name }}
                            </h2>
                            <div class="flex items-center justify-center gap-2 sm:gap-3 bg-white rounded-full px-4 sm:px-6 md:px-8 py-2 sm:py-3 md:py-4 inline-flex shadow-lg">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 md:w-8 md:h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black text-gray-900">
                                    {{ winnerTeam.score }}
                                </p>
                                <p class="text-sm sm:text-base md:text-lg lg:text-xl text-gray-700 font-bold">puntos</p>
                            </div>
                        </div>
                    </div>

                    <!-- Ranking de equipos con diseño mejorado -->
                    <div class="mb-6 sm:mb-10 bg-gray-800 rounded-2xl p-4 sm:p-6 md:p-8 border-2 border-gray-600 shadow-2xl">
                        <div class="flex items-center justify-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <h3 class="text-lg sm:text-xl md:text-2xl font-black text-yellow-400 uppercase tracking-wider">Ranking Final</h3>
                        </div>
                        <div class="space-y-2 sm:space-y-3 md:space-y-4">
                            <div
                                v-for="(team, index) in sortedTeams"
                                :key="team.id"
                                class="flex items-center justify-between p-3 sm:p-4 md:p-5 rounded-xl transition-all duration-300 hover:shadow-xl border-2 relative overflow-hidden"
                                :class="index === 0 ? 'bg-yellow-600 border-yellow-400' :
                                        index === 1 ? 'bg-gray-600 border-gray-400' :
                                        index === 2 ? 'bg-orange-600 border-orange-400' :
                                        'bg-gray-700 border-gray-500'"
                            >
                                <!-- Efecto de brillo -->
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent transform -skew-x-12"></div>

                                <div class="flex items-center gap-2 sm:gap-3 md:gap-5 relative z-10">
                                    <!-- Medalla -->
                                    <div class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 rounded-full font-black text-base sm:text-lg md:text-xl border-2"
                                         :class="index === 0 ? 'bg-yellow-300 text-gray-900 border-yellow-200' :
                                                 index === 1 ? 'bg-gray-300 text-gray-900 border-gray-200' :
                                                 index === 2 ? 'bg-orange-400 text-white border-orange-300' :
                                                 'bg-gray-500 text-white border-gray-400'">
                                        {{ index + 1 }}º
                                    </div>

                                    <!-- Icono del equipo -->
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 md:w-8 md:h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                                    </svg>

                                    <span class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-white truncate">{{ team.name }}</span>
                                </div>

                                <div class="flex items-center gap-1 sm:gap-2 relative z-10">
                                    <span class="text-xl sm:text-2xl md:text-3xl font-black text-white">{{ team.score }}</span>
                                    <span class="text-xs sm:text-sm text-gray-200 font-semibold">pts</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botón para volver con mejor diseño -->
                    <button
                        @click="goBack"
                        class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-black py-3 sm:py-4 md:py-5 px-6 sm:px-8 md:px-12 rounded-xl text-base sm:text-lg md:text-xl transition-all duration-300 transform hover:scale-110 shadow-2xl hover:shadow-blue-500/50 border-2 border-blue-400 flex items-center gap-2 sm:gap-3 mx-auto"
                    >
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        Volver al Dashboard
                    </button>
                </div>
            </Transition>
        </div>
    </Transition>
</template>

<script>
import { computed } from 'vue';

export default {
    name: 'GameWinner',
    props: {
        teams: {
            type: Array,
            required: true,
        },
    },
    emits: ['close'],
    setup(props, { emit }) {
        const winnerTeam = computed(() => {
            return props.teams.reduce((max, team) => (team.score > max.score ? team : max), props.teams[0]);
        });

        const sortedTeams = computed(() => {
            return [...props.teams].sort((a, b) => b.score - a.score);
        });

        const goBack = () => {
            window.location.href = '/dashboard';
        };

        return {
            winnerTeam,
            sortedTeams,
            goBack,
        };
    },
};
</script>

<style scoped>
.winner-appear-enter-active,
.winner-appear-leave-active {
    transition: opacity 0.6s ease;
}

.winner-appear-enter-from,
.winner-appear-leave-to {
    opacity: 0;
}

.winner-scale-enter-active {
    animation: winner-bounce 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.winner-scale-leave-active {
    animation: winner-bounce-out 0.5s ease-in;
}

@keyframes winner-bounce {
    0% {
        transform: scale(0.3) rotateZ(-15deg);
        opacity: 0;
    }
    50% {
        transform: scale(1.1) rotateZ(5deg);
    }
    100% {
        transform: scale(1) rotateZ(0deg);
        opacity: 1;
    }
}

@keyframes winner-bounce-out {
    0% {
        transform: scale(1) rotateZ(0deg);
        opacity: 1;
    }
    100% {
        transform: scale(0.3) rotateZ(15deg);
        opacity: 0;
    }
}

/* Animación de flotación para partículas */
@keyframes float {
    0%, 100% {
        transform: translateY(0) translateX(0);
        opacity: 0;
    }
    10% {
        opacity: 1;
    }
    90% {
        opacity: 1;
    }
    100% {
        transform: translateY(-100vh) translateX(20px);
        opacity: 0;
    }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

/* Animación de brillo shimmer */
@keyframes shimmer {
    0% {
        transform: translateX(-100%) skewX(-12deg);
    }
    100% {
        transform: translateX(200%) skewX(-12deg);
    }
}

.animate-shimmer {
    animation: shimmer 3s infinite;
}

/* Animación de pulse lento */
@keyframes pulse-slow {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.8;
    }
}

.animate-pulse-slow {
    animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Animación de bounce lento */
@keyframes bounce-slow {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-15px);
    }
}

.animate-bounce-slow {
    animation: bounce-slow 2s ease-in-out infinite;
}
</style>
