import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue';
import BoardGame from './components/Game/BoardGame.vue';

window.Alpine = Alpine;

Alpine.start();

// Configurar Vue
const appElement = document.getElementById('app');
if (appElement) {
    const gameId = appElement.dataset.gameId;

    if (gameId) {
        const app = createApp(BoardGame, {
            gameId: parseInt(gameId)
        });
        app.mount('#app');
        console.log('Vue mounted successfully with game ID:', gameId);
    } else {
        console.log('No game ID found, skipping Vue mount');
    }
}
