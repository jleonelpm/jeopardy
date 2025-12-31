<template>
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-bold text-center mb-4 text-yellow-400">PUNTAJES</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div
                v-for="team in sortedTeams"
                :key="team.id"
                class="bg-gray-700 rounded-lg p-4 border-l-4 transition transform hover:scale-105"
                :style="{ borderColor: team.color }"
            >
                <p class="font-semibold text-lg mb-1" :style="{ color: team.color }">
                    {{ team.name }}
                </p>
                <p class="text-3xl font-bold text-white">
                    {{ team.score }}
                </p>
                <p class="text-xs text-gray-400">puntos</p>
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
