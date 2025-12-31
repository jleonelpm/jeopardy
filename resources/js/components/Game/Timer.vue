<template>
    <div class="flex flex-col items-center">
        <div
            class="w-24 h-24 rounded-full flex items-center justify-center text-4xl font-bold"
            :class="timeClass"
        >
            {{ timeRemaining }}
        </div>
        <p class="text-sm text-gray-400 mt-2">segundos</p>
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
        let interval = null;

        const timeClass = computed(() => {
            if (timeRemaining.value > 10) {
                return 'bg-green-600 text-white';
            } else if (timeRemaining.value > 5) {
                return 'bg-yellow-500 text-black';
            } else {
                return 'bg-red-600 text-white animate-pulse';
            }
        });

        const startTimer = () => {
            interval = setInterval(() => {
                timeRemaining.value--;

                if (timeRemaining.value <= 0) {
                    clearInterval(interval);
                    emit('timeout');
                }
            }, 1000);
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
            timeClass,
        };
    },
};
</script>
