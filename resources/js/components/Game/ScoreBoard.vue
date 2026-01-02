<template>
    <div class="bg-gradient-to-r from-gray-800 via-gray-900 to-gray-800 p-8 rounded-2xl shadow-2xl border-2 border-gray-700">
        <div class="flex items-center justify-center gap-3 mb-6">
            <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            <h3 class="text-2xl font-black text-center text-yellow-400 uppercase tracking-widest">Marcador</h3>
            <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div
                v-for="(team, index) in sortedTeams"
                :key="team.id"
                class="bg-gradient-to-br from-gray-700 to-gray-800 rounded-xl p-6 border-l-4 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl relative overflow-hidden group"
                :style="{ borderColor: team.color }"
            >
                <!-- Posición -->
                <div v-if="index === 0" class="absolute top-2 right-2 bg-yellow-400 text-gray-900 rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm shadow-lg">
                    1°
                </div>
                <div v-else-if="index === 1" class="absolute top-2 right-2 bg-gray-400 text-gray-900 rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm shadow-lg">
                    2°
                </div>
                <div v-else-if="index === 2" class="absolute top-2 right-2 bg-orange-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm shadow-lg">
                    3°
                </div>

                <!-- Icono del equipo -->
                <div class="flex items-center gap-3 mb-3">
                    <div class="bg-white/10 rounded-full p-2">
                        <svg class="w-6 h-6" :style="{ color: team.color }" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                        </svg>
                    </div>
                    <p class="font-black text-lg flex-1 truncate" :style="{ color: team.color }">
                        {{ team.name }}
                    </p>
                </div>

                <!-- Puntaje -->
                <div class="flex items-baseline gap-2">
                    <p class="text-4xl font-black text-white">
                        {{ team.score }}
                    </p>
                    <p class="text-sm text-gray-400 font-semibold">pts</p>
                </div>

                <!-- Efecto de brillo -->
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
            </div>
        </div>
    </div>
</template>

<script>
import { computed } from 'vue';

export default {
    name: 'ScoreBoard',
    props: {
        teams: {
            type: Array,
            required: true,
        },
    },
    setup(props) {
        const sortedTeams = computed(() => {
            return [...props.teams].sort((a, b) => b.score - a.score);
        });

        return {
            sortedTeams,
        };
    },
};
</script>
