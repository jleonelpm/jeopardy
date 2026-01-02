<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900 text-white">
        <!-- Header con información de la partida -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6 shadow-2xl border-b-4 border-yellow-400">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <div class="bg-yellow-400 rounded-full w-16 h-16 flex items-center justify-center shadow-lg transform hover:rotate-12 transition-transform">
                        <svg class="w-10 h-10 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <h1 class="text-5xl font-black tracking-wider text-white drop-shadow-2xl" style="font-family: 'Impact', sans-serif; letter-spacing: 0.1em;">JEOPARDY!</h1>
                </div>
                <div class="text-right bg-white/10 backdrop-blur-sm rounded-lg px-6 py-3 border border-white/20">
                    <p class="text-sm font-semibold text-yellow-300">Partida #{{ game.id }}</p>
                    <p class="text-xs text-blue-200 uppercase tracking-wide">{{ game.status }}</p>
                </div>
            </div>
        </div>

        <!-- Turno actual -->
        <div class="bg-gradient-to-b from-gray-800 to-transparent p-8 shadow-inner">
            <div class="max-w-7xl mx-auto">
                <div class="text-center transform hover:scale-105 transition-transform">
                    <p class="text-sm text-gray-300 mb-3 uppercase tracking-widest font-semibold flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        TURNO ACTUAL
                    </p>
                    <h2 class="text-5xl font-black drop-shadow-lg animate-pulse" :style="{ color: currentTeam?.color, textShadow: `0 0 20px ${currentTeam?.color}` }">
                        {{ currentTeam?.name }}
                    </h2>
                </div>
            </div>
        </div>

        <!-- Tablero de categorías y preguntas -->
        <div class="max-w-7xl mx-auto p-6">
            <div class="grid gap-3" :style="{ gridTemplateColumns: `repeat(${categories.length}, 1fr)` }">
                <!-- Encabezados de categorías -->
                <div
                    v-for="category in categories"
                    :key="category.category.id"
                    class="bg-gradient-to-b from-blue-500 to-blue-700 p-5 text-center font-black text-xl rounded-lg shadow-2xl border-2 border-blue-400 transform hover:-translate-y-1 transition-all uppercase tracking-wide"
                    style="font-family: 'Arial Black', sans-serif;"
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
                            class="w-full h-full bg-gradient-to-br from-blue-600 via-blue-500 to-purple-600 hover:from-yellow-500 hover:via-yellow-400 hover:to-orange-500 text-5xl font-black rounded-xl shadow-2xl transition-all duration-300 transform hover:scale-110 hover:rotate-2 border-4 border-blue-400 hover:border-yellow-300 active:scale-95 group relative overflow-hidden"
                        >
                            <span class="relative z-10 drop-shadow-lg">${{ gameQuestion.question.points }}</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                        </button>
                        <div
                            v-else
                            class="w-full h-full bg-gray-800 text-gray-600 flex items-center justify-center text-6xl rounded-xl shadow-inner border-4 border-gray-700"
                        >
                            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
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
        let isCheckingGameFinish = false;

        const finishGameIfComplete = async () => {
            // Prevenir múltiples llamadas concurrentes
            if (isCheckingGameFinish || gameFinished.value) {
                return;
            }

            isCheckingGameFinish = true;

            try {
                const finishResponse = await fetch(`/api/games/${props.gameId}/finish`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                });

                const finishData = await finishResponse.json();
                console.log('Game finish response:', finishData);

                if (finishData.success) {
                    gameFinished.value = true;
                }
            } catch (error) {
                console.error('Error finishing game:', error);
            } finally {
                isCheckingGameFinish = false;
            }
        };

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

                    console.log(`Total: ${totalQuestions}, Used: ${usedQuestions}, GameFinished: ${gameFinished.value}`);

                    if (totalQuestions > 0 && usedQuestions === totalQuestions && !gameFinished.value) {
                        console.log('All questions answered, finalizing game...');
                        // Esperar un poco antes de finalizar
                        await new Promise(resolve => setTimeout(resolve, 500));
                        // Llamar a la función para finalizar
                        await finishGameIfComplete();
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
