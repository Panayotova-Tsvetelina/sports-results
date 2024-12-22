import { createApp } from "vue/dist/vue.esm-bundler";
import Tournaments from './components/Tournaments.vue';
import '../css/app.css';

const app = createApp({
    components: {
        Tournaments,
    },
});

app.mount('#app');
