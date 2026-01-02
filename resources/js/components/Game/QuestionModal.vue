<template>
    <Transition name="modal-fade">
        <div class="fixed inset-0 bg-black flex items-stretch justify-center z-50 p-2 sm:p-4">
            <Transition name="modal-scale">
            <div class="bg-blue-600 w-full h-full max-h-screen rounded-none sm:rounded-xl shadow-2xl p-4 sm:p-6 md:p-8 relative border-4 border-yellow-400 overflow-hidden overflow-y-auto">
                    <!-- Efecto de brillo de fondo -->
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent transform -skew-x-12 animate-shimmer"></div>

                    <!-- Temporizador -->
                    <div class="absolute top-4 sm:top-6 right-4 sm:right-6 z-10">
                        <Timer :duration="question.question.time_limit" @timeout="handleTimeout" />
                    </div>

                    <!-- Categoría -->
                    <div class="text-center mb-6 relative z-10">
                        <div class="inline-flex items-center gap-2 bg-yellow-400 px-4 sm:px-6 py-2 rounded-full border-2 border-yellow-500 mb-3 shadow-lg">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-900" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/>
                            </svg>
                            <p class="text-blue-900 text-xs sm:text-sm font-black uppercase tracking-wider">
                                {{ question.question.category.name }}
                            </p>
                        </div>
                        <div class="inline-flex items-center gap-2 bg-white px-3 sm:px-4 py-1 rounded-full border-2 border-blue-300 shadow-lg">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-700" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-blue-900 text-base sm:text-lg font-bold">{{ question.question.points }}</p>
                        </div>
                    </div>

                    <!-- Pregunta -->
                    <div class="bg-blue-800 rounded-xl p-6 sm:p-8 lg:p-10 mb-8 min-h-[180px] sm:min-h-[220px] flex items-center justify-center border-2 border-blue-500 shadow-inner relative z-10">
                        <p class="text-white text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-center leading-relaxed drop-shadow-lg break-words">
                            {{ question.question.question_text }}
                        </p>
                    </div>

                    <!-- Equipo en turno -->
                    <div class="text-center mb-8 relative z-10">
                        <div class="inline-flex items-center gap-3 bg-white rounded-full px-4 sm:px-6 py-3 border-2 shadow-lg" :style="{ borderColor: currentTeam.color }">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" :style="{ color: currentTeam.color }" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                            </svg>
                            <div>
                                <p class="text-gray-600 text-[11px] sm:text-xs font-semibold uppercase tracking-wide">Turno de</p>
                                <p class="text-xl sm:text-2xl font-black break-words" :style="{ color: currentTeam.color }">
                                    {{ currentTeam.name }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Respuesta (solo visible para moderador) -->
                    <Transition name="answer-reveal">
                        <div v-if="showAnswer" class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl p-6 mb-8 border-4 border-green-400 shadow-2xl relative z-10 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 animate-shimmer"></div>
                            <div class="relative z-10">
                                <div class="flex items-center gap-2 mb-3">
                                    <svg class="w-6 h-6 text-green-100" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <p class="text-green-100 text-sm font-black uppercase tracking-wider">Respuesta correcta:</p>
                                </div>
                                <p class="text-white text-2xl font-black">
                                    {{ question.question.correct_answer }}
                                </p>
                            </div>
                        </div>
                    </Transition>

                    <!-- Acciones -->
                    <div class="flex flex-wrap justify-center gap-4 relative z-10">
                        <button
                            v-if="!showAnswer"
                            @click="revealAnswer"
                            class="bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-gray-900 font-black py-3 sm:py-4 px-6 sm:px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-2xl flex items-center gap-2 border-2 border-yellow-300 w-full sm:w-auto justify-center"
                        >
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                            Revelar Respuesta
                        </button>

                        <Transition v-if="showAnswer" name="buttons-fade">
                            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                                <button
                                    @click="handleCorrect"
                                    class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-black py-3 sm:py-4 px-6 sm:px-10 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-2xl flex items-center gap-2 border-2 border-green-400 w-full sm:w-auto justify-center"
                                >
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Correcta
                                </button>
                                <button
                                    @click="handleIncorrect"
                                    class="bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white font-black py-3 sm:py-4 px-6 sm:px-10 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-2xl flex items-center gap-2 border-2 border-red-400 w-full sm:w-auto justify-center"
                                >
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    Incorrecta
                                </button>
                            </div>
                        </Transition>

                        <button
                            @click="$emit('close')"
                            class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-black py-3 sm:py-4 px-6 sm:px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center gap-2 border-2 border-gray-500 w-full sm:w-auto justify-center"
                        >
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
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

        // Sonidos en mp3 (ubicar archivos en /public/sounds/)
        const correctAudio = new Audio('/sounds/correct.mp3');
        const incorrectAudio = new Audio('/sounds/incorrect.mp3');
        const revealAudio = new Audio('/sounds/reveal.mp3');

        const playAudio = (audio) => {
            if (!audio) return;
            audio.currentTime = 0;
            audio.play().catch(() => {});
        };

        const playCorrectSound = () => playAudio(correctAudio);
        const playIncorrectSound = () => playAudio(incorrectAudio);

        const revealAnswer = () => {
            showAnswer.value = true;
            playAudio(revealAudio);
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
    animation: scale-in 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.modal-scale-leave-active {
    animation: scale-out 0.3s ease-in;
}

@keyframes scale-in {
    0% {
        transform: scale(0.7) rotate(-5deg);
        opacity: 0;
    }
    100% {
        transform: scale(1) rotate(0deg);
        opacity: 1;
    }
}

@keyframes scale-out {
    0% {
        transform: scale(1) rotate(0deg);
        opacity: 1;
    }
    100% {
        transform: scale(0.7) rotate(5deg);
        opacity: 0;
    }
}

/* Transición para la revelación de respuesta */
.answer-reveal-enter-active {
    animation: slide-down 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.answer-reveal-leave-active {
    animation: slide-up 0.3s ease-in;
}

@keyframes slide-down {
    0% {
        transform: translateY(-30px) scale(0.9);
        opacity: 0;
    }
    100% {
        transform: translateY(0) scale(1);
        opacity: 1;
    }
}

@keyframes slide-up {
    0% {
        transform: translateY(0) scale(1);
        opacity: 1;
    }
    100% {
        transform: translateY(-30px) scale(0.9);
        opacity: 0;
    }
}

/* Transición para botones de acción */
.buttons-fade-enter-active {
    animation: bounce-in 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.2s both;
}

.buttons-fade-leave-active {
    animation: fade-out 0.2s ease-in;
}

@keyframes bounce-in {
    0% {
        opacity: 0;
        transform: translateY(20px) scale(0.8);
    }
    50% {
        transform: translateY(-5px) scale(1.05);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
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

/* Animación de brillo */
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
</style>
