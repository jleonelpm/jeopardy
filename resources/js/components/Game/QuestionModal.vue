<template>
    <Transition name="modal-fade">
        <div class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50 p-4">
            <Transition name="modal-scale">
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
                    <Transition name="answer-reveal">
                        <div v-if="showAnswer" class="bg-green-700 rounded-lg p-4 mb-6 border-2 border-green-500">
                            <p class="text-green-100 text-sm mb-2 font-semibold">Respuesta correcta:</p>
                            <p class="text-white text-xl font-bold">
                                {{ question.question.correct_answer }}
                            </p>
                        </div>
                    </Transition>

                    <!-- Acciones -->
                    <div class="flex justify-center gap-4">
                        <button
                            v-if="!showAnswer"
                            @click="revealAnswer"
                            class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 px-6 rounded-lg transition"
                        >
                            Revelar Respuesta
                        </button>

                        <Transition v-if="showAnswer" name="buttons-fade">
                            <div class="flex gap-2">
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
                            </div>
                        </Transition>

                        <button
                            @click="$emit('close')"
                            class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition"
                        >
                            Cancelar
                        </button>
                    </div>
                </div>
            </Transition>
        </div>
    </Transition>
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

        // Efectos de sonido (usando Web Audio API)
        const playSound = (frequency, duration, type = 'correct') => {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);

            oscillator.frequency.value = frequency;
            oscillator.type = 'sine';

            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + duration);

            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + duration);
        };

        const playCorrectSound = () => {
            // Sonido de éxito (escala ascendente)
            playSound(523, 0.15); // C5
            setTimeout(() => playSound(659, 0.15), 150); // E5
            setTimeout(() => playSound(784, 0.3), 300); // G5
        };

        const playIncorrectSound = () => {
            // Sonido de error (frecuencias bajas descendentes)
            playSound(200, 0.2);
            setTimeout(() => playSound(150, 0.3), 200);
        };

        const revealAnswer = () => {
            showAnswer.value = true;
            playSound(440, 0.1); // Sonido suave al revelar
        };

        const handleCorrect = () => {
            playCorrectSound();
            emit('answer', {
                isCorrect: true,
                points: props.question.question.points,
            });
        };

        const handleIncorrect = () => {
            playIncorrectSound();
            emit('answer', {
                isCorrect: false,
                points: props.question.question.points,
            });
        };

        const handleTimeout = () => {
            // Auto-marcar como incorrecta si se acaba el tiempo
            playIncorrectSound();
            handleIncorrect();
        };

        return {
            showAnswer,
            revealAnswer,
            handleCorrect,
            handleIncorrect,
            handleTimeout,
        };
    },
};
</script>

<style scoped>
/* Transición del fondo del modal */
.modal-fade-enter-active,
.modal-fade-leave-active {
    transition: opacity 0.3s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
    opacity: 0;
}

/* Transición del contenido del modal (escala) */
.modal-scale-enter-active {
    animation: scale-in 0.3s ease-out;
}

.modal-scale-leave-active {
    animation: scale-out 0.2s ease-in;
}

@keyframes scale-in {
    0% {
        transform: scale(0.8);
        opacity: 0;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes scale-out {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    100% {
        transform: scale(0.8);
        opacity: 0;
    }
}

/* Transición para la revelación de respuesta */
.answer-reveal-enter-active {
    animation: slide-down 0.4s ease-out;
}

.answer-reveal-leave-active {
    animation: slide-up 0.3s ease-in;
}

@keyframes slide-down {
    0% {
        transform: translateY(-20px);
        opacity: 0;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes slide-up {
    0% {
        transform: translateY(0);
        opacity: 1;
    }
    100% {
        transform: translateY(-20px);
        opacity: 0;
    }
}

/* Transición para botones de acción */
.buttons-fade-enter-active {
    animation: fade-in 0.3s ease-out 0.2s both;
}

.buttons-fade-leave-active {
    animation: fade-out 0.2s ease-in;
}

@keyframes fade-in {
    0% {
        opacity: 0;
        transform: translateY(10px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fade-out {
    0% {
        opacity: 1;
    }
    100% {
        opacity: 0;
    }
}
</style>
