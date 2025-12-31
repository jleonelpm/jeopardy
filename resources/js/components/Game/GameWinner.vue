<template>
    <Transition name="winner-appear">
        <div class="fixed inset-0 bg-black bg-opacity-95 flex items-center justify-center z-50 p-4">
            <Transition name="winner-scale">
                <div class="text-center max-w-2xl">
                    <!-- Animación de confeti -->
                    <div class="mb-8 text-6xl animate-bounce">
                        🎉
                    </div>

                    <!-- Título -->
                    <h1 class="text-5xl font-bold text-yellow-400 mb-8 animate-pulse">
                        ¡PARTIDA FINALIZADA!
                    </h1>

                    <!-- Equipo ganador -->
                    <div class="mb-8 p-8 rounded-lg border-4" :style="{ borderColor: winnerTeam.color, backgroundColor: 'rgba(0,0,0,0.5)' }">
                        <p class="text-gray-300 text-lg mb-2">Equipo Ganador</p>
                        <h2 class="text-6xl font-bold mb-4" :style="{ color: winnerTeam.color }">
                            {{ winnerTeam.name }}
                        </h2>
                        <p class="text-4xl font-bold text-white">
                            {{ winnerTeam.score }} puntos
                        </p>
                    </div>

                    <!-- Ranking de equipos -->
                    <div class="mb-8 bg-gray-900 rounded-lg p-6 border border-gray-700">
                        <h3 class="text-xl font-semibold text-gray-300 mb-4">Ranking Final</h3>
                        <div class="space-y-3">
                            <div
                                v-for="(team, index) in sortedTeams"
                                :key="team.id"
                                class="flex items-center justify-between p-3 rounded-lg"
                                :class="index === 0 ? 'bg-yellow-900 border-2 border-yellow-500' : index === 1 ? 'bg-gray-700 border-2 border-gray-500' : index === 2 ? 'bg-orange-900 border-2 border-orange-700' : 'bg-gray-800'"
                            >
                                <div class="flex items-center gap-4">
                                    <span class="text-2xl font-bold w-8">{{ index + 1 }}º</span>
                                    <span class="text-xl" :style="{ color: team.color }">{{ team.name }}</span>
                                </div>
                                <span class="text-2xl font-bold">{{ team.score }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Botón para volver -->
                    <button
                        @click="goBack"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-lg text-lg transition transform hover:scale-105"
                    >
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
    transition: opacity 0.5s ease;
}

.winner-appear-enter-from,
.winner-appear-leave-to {
    opacity: 0;
}

.winner-scale-enter-active {
    animation: winner-bounce 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.winner-scale-leave-active {
    animation: winner-bounce-out 0.4s ease-in;
}

@keyframes winner-bounce {
    0% {
        transform: scale(0.3) rotateZ(-10deg);
        opacity: 0;
    }
    50% {
        transform: scale(1.05) rotateZ(2deg);
    }
    100% {
        transform: scale(1) rotateZ(0deg);
        opacity: 1;
    }
}

@keyframes winner-bounce-out {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    100% {
        transform: scale(0.3);
        opacity: 0;
    }
}
</style>
