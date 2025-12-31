<template>
    <div class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50 p-4">
        <div class="bg-blue-900 rounded-lg shadow-2xl max-w-4xl w-full p-8 relative">
            <!-- Temporizador -->
            <div class="absolute top-4 right-4">
                <Timer :duration="question.question.time_limit" @timeout="handleTimeout" />
            </div>

            <!-- Categoría -->
            <div class="text-center mb-4">
                <p class="text-yellow-400 text-sm font-semibold uppercase">
                    {{ question.question.category.name }}
                </p>
                <p class="text-blue-300 text-lg">Valor: ${{ question.question.points }}</p>
            </div>

            <!-- Pregunta -->
            <div class="bg-blue-800 rounded-lg p-8 mb-6 min-h-[200px] flex items-center justify-center">
                <p class="text-white text-3xl font-semibold text-center">
                    {{ question.question.question_text }}
                </p>
            </div>

            <!-- Equipo en turno -->
            <div class="text-center mb-6">
                <p class="text-gray-400 text-sm mb-2">Equipo en turno:</p>
                <p class="text-2xl font-bold" :style="{ color: currentTeam.color }">
                    {{ currentTeam.name }}
                </p>
            </div>

            <!-- Respuesta (solo visible para moderador) -->
            <div v-if="showAnswer" class="bg-green-800 rounded-lg p-4 mb-6">
                <p class="text-green-200 text-sm mb-2">Respuesta correcta:</p>
                <p class="text-white text-xl font-semibold">
                    {{ question.question.correct_answer }}
                </p>
            </div>

            <!-- Acciones -->
            <div class="flex justify-center gap-4">
                <button
                    v-if="!showAnswer"
                    @click="showAnswer = true"
                    class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 px-6 rounded-lg transition"
                >
                    Revelar Respuesta
                </button>

                <template v-if="showAnswer">
                    <button
                        @click="handleCorrect"
                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg transition"
                    >
                        ✓ Correcta
                    </button>
                    <button
                        @click="handleIncorrect"
                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-8 rounded-lg transition"
                    >
                        ✗ Incorrecta
                    </button>
                </template>

                <button
                    @click="$emit('close')"
                    class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition"
                >
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
import Timer from './Timer.vue';

export default {
    name: 'QuestionModal',
    components: {
        Timer,
    },
    props: {
        question: {
            type: Object,
            required: true,
        },
        currentTeam: {
            type: Object,
            required: true,
        },
    },
    emits: ['close', 'answer'],
    setup(props, { emit }) {
        const showAnswer = ref(false);

        const handleCorrect = () => {
            emit('answer', {
                isCorrect: true,
                points: props.question.question.points,
            });
        };

        const handleIncorrect = () => {
            emit('answer', {
                isCorrect: false,
                points: props.question.question.points,
            });
        };

        const handleTimeout = () => {
            // Auto-marcar como incorrecta si se acaba el tiempo
            handleIncorrect();
        };

        return {
            showAnswer,
            handleCorrect,
            handleIncorrect,
            handleTimeout,
        };
    },
};
</script>
