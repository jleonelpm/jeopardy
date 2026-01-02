<template>
    <div class="flex flex-col items-center">
        <div class="relative">
            <!-- Círculo de progreso SVG -->
            <svg class="w-28 h-28 transform -rotate-90" viewBox="0 0 100 100">
                <!-- Círculo de fondo -->
                <circle
                    cx="50"
                    cy="50"
                    r="45"
                    fill="none"
                    stroke="currentColor"
                    :class="backgroundCircleClass"
                    stroke-width="8"
                />
                <!-- Círculo de progreso -->
                <circle
                    cx="50"
                    cy="50"
                    r="45"
                    fill="none"
                    stroke="currentColor"
                    :class="progressCircleClass"
                    stroke-width="8"
                    :stroke-dasharray="circumference"
                    :stroke-dashoffset="dashOffset"
                    stroke-linecap="round"
                    class="transition-all duration-1000 ease-linear"
                />
            </svg>

            <!-- Tiempo restante en el centro -->
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <div
                    class="text-4xl font-black"
                    :class="[textClass, { 'animate-pulse-fast': timeRemaining <= 5 }]"
                >
                    {{ timeRemaining }}
                </div>
            </div>
        </div>

        <!-- Icono y texto -->
        <div class="flex items-center gap-1 mt-2">
            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
            </svg>
            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide">segundos</p>
        </div>
    </div>
</template>

<script>
import { ref, computed, onMounted, onUnmounted } from 'vue';

export default {
    name: 'Timer',
    props: {
        duration: {
            type: Number,
            required: true,
        },
    },
    emits: ['timeout'],
    setup(props, { emit }) {
        const timeRemaining = ref(props.duration);
        const circumference = 2 * Math.PI * 45; // radio = 45
        let interval = null;

        const dashOffset = computed(() => {
            const progress = timeRemaining.value / props.duration;
            return circumference * (1 - progress);
        });

        const backgroundCircleClass = computed(() => {
            if (timeRemaining.value > 10) {
                return 'text-green-900';
            } else if (timeRemaining.value > 5) {
                return 'text-yellow-900';
            } else {
                return 'text-red-900';
            }
        });

        const progressCircleClass = computed(() => {
            if (timeRemaining.value > 10) {
                return 'text-green-400';
            } else if (timeRemaining.value > 5) {
                return 'text-yellow-400';
            } else {
                return 'text-red-500';
            }
        });

        const textClass = computed(() => {
            if (timeRemaining.value > 10) {
                return 'text-green-400';
            } else if (timeRemaining.value > 5) {
                return 'text-yellow-400';
            } else {
                return 'text-red-500';
            }
        });

        const startTimer = () => {
            interval = setInterval(() => {
                timeRemaining.value--;

                // Reproducir sonido de tick cuando quedan pocos segundos
                if (timeRemaining.value <= 5 && timeRemaining.value > 0) {
                    playTickSound();
                }

                if (timeRemaining.value <= 0) {
                    clearInterval(interval);
                    playTimeoutSound();
                    emit('timeout');
                }
            }, 1000);
        };

        const playTickSound = () => {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);

            oscillator.frequency.value = 800;
            oscillator.type = 'sine';

            gainNode.gain.setValueAtTime(0.1, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);

            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.1);
        };

        const playTimeoutSound = () => {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);

            oscillator.frequency.value = 200;
            oscillator.type = 'sawtooth';

            gainNode.gain.setValueAtTime(0.2, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);

            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.5);
        };

        onMounted(() => {
            startTimer();
        });

        onUnmounted(() => {
            if (interval) {
                clearInterval(interval);
            }
        });

        return {
            timeRemaining,
            circumference,
            dashOffset,
            backgroundCircleClass,
            progressCircleClass,
            textClass,
        };
    },
};
</script>

<style scoped>
@keyframes pulse-fast {
    0%, 100% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.15);
        opacity: 0.8;
    }
}

.animate-pulse-fast {
    animation: pulse-fast 0.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>
