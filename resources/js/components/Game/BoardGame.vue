<template>
    <div class="min-h-screen bg-gray-900 text-white">
        <!-- Header con información de la partida -->
        <div class="bg-blue-800 p-4 shadow-lg">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <h1 class="text-3xl font-bold">JEOPARDY!</h1>
                <div class="text-right">
                    <p class="text-sm">Partida #{{ game.id }}</p>
                    <p class="text-xs">{{ game.status }}</p>
                </div>
            </div>
        </div>

        <!-- Turno actual -->
        <div class="bg-gray-800 p-6 shadow-inner">
            <div class="max-w-7xl mx-auto">
                <div class="text-center">
                    <p class="text-sm text-gray-400 mb-2">TURNO ACTUAL</p>
                    <h2 class="text-4xl font-bold" :style="{ color: currentTeam?.color }">
                        {{ currentTeam?.name }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- Tablero de categorías y preguntas -->
        <div class="max-w-7xl mx-auto p-6">
            <div class="grid gap-2" :style="{ gridTemplateColumns: `repeat(${categories.length}, 1fr)` }">
                <!-- Encabezados de categorías -->
                <div
                    v-for="category in categories"
                    :key="category.category.id"
                    class="bg-blue-600 p-4 text-center font-bold text-xl rounded shadow-lg"
                >
                    {{ category.category.name }}
                </div>

                <!-- Grid de preguntas -->
                <template v-for="(category, catIndex) in categories" :key="`cat-${catIndex}`">
                    <div
                        v-for="(gameQuestion, qIndex) in category.questions"
                        :key="`q-${gameQuestion.id}`"
                        class="aspect-square"
                        :style="{ gridColumn: catIndex + 1, gridRow: qIndex + 2 }"
                    >
                        <button
                            v-if="!gameQuestion.used"
                            @click="selectQuestion(gameQuestion)"
                            class="w-full h-full bg-blue-500 hover:bg-blue-400 text-4xl font-bold rounded shadow-lg transition transform hover:scale-105"
                        >
                            ${{ gameQuestion.question.points }}
                        </button>
                        <div
                            v-else
                            class="w-full h-full bg-gray-700 text-gray-500 flex items-center justify-center text-6xl rounded shadow-inner"
                        >
                            —
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Scoreboard -->
        <ScoreBoard :teams="teams" />

        <!-- Modal de pregunta -->
        <QuestionModal
            v-if="selectedQuestion"
            :question="selectedQuestion"
            :current-team="currentTeam"
            @close="closeQuestion"
            @answer="handleAnswer"
        />

        <!-- Modal de ganador -->
        <GameWinner
            v-if="gameFinished"
            :teams="teams"
            @close="closeWinner"
        />
    </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import ScoreBoard from './ScoreBoard.vue';
import QuestionModal from './QuestionModal.vue';
import GameWinner from './GameWinner.vue';

export default {
    name: 'BoardGame',
    components: {
        ScoreBoard,
        QuestionModal,
        GameWinner,
    },
    props: {
        gameId: {
            type: Number,
            required: true,
        },
    },
    setup(props) {
        const game = ref({});
        const categories = ref([]);
        const teams = ref([]);
        const currentTeam = ref(null);
        const selectedQuestion = ref(null);
        const gameFinished = ref(false);

        const loadGameBoard = async () => {
            try {
                const response = await fetch(`/api/games/${props.gameId}/board`);
                const data = await response.json();

                if (data.success) {
                    game.value = data.data.game;
                    categories.value = data.data.categories;
                    teams.value = data.data.game.teams;
                    currentTeam.value = data.data.game.current_turn_team;

                    // Verificar si todas las preguntas han sido respondidas
                    const totalQuestions = categories.value.reduce((sum, cat) => sum + cat.questions.length, 0);
                    const usedQuestions = categories.value.reduce((sum, cat) => {
                        return sum + cat.questions.filter(q => q.used).length;
                    }, 0);

                    if (totalQuestions > 0 && usedQuestions === totalQuestions) {
                        // Finalizar el juego después de un pequeño delay
                        setTimeout(() => {
                            gameFinished.value = true;
                        }, 500);
                    }
                }
            } catch (error) {
                console.error('Error loading game board:', error);
            }
        };

        const selectQuestion = (gameQuestion) => {
            selectedQuestion.value = gameQuestion;
        };

        const closeQuestion = () => {
            selectedQuestion.value = null;
        };

        const closeWinner = () => {
            window.location.href = '/dashboard';
        };

        const handleAnswer = async ({ isCorrect, points }) => {
            // Actualizar puntaje del equipo
            await fetch(`/api/teams/${currentTeam.value.id}/score`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    points: points,
                    operation: isCorrect ? 'add' : 'subtract',
                }),
            });

            // Marcar pregunta como usada
            await fetch(`/api/games/${props.gameId}/questions/${selectedQuestion.value.question_id}/mark-used`, {
                method: 'PATCH',
            });

            // Registrar turno
            await fetch(`/api/games/${props.gameId}/turns`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    team_id: currentTeam.value.id,
                    question_id: selectedQuestion.value.question_id,
                    is_correct: isCorrect,
                    points_awarded: isCorrect ? points : -points,
                }),
            });

            // Cambiar automáticamente al siguiente turno (rotación automática)
            await fetch(`/api/games/${props.gameId}/next-turn`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                },
            });

            // Recargar tablero
            await loadGameBoard();
            closeQuestion();
        };

        onMounted(() => {
            loadGameBoard();
        });

        return {
            game,
            categories,
            teams,
            currentTeam,
            selectedQuestion,
            gameFinished,
            selectQuestion,
            closeQuestion,
            closeWinner,
            handleAnswer,
        };
    },
};
</script>
