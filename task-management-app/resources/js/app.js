import './bootstrap';
import Alpine from 'alpinejs';
;
import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import 'admin-lte/dist/js/adminlte.min.js';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import { createRouter, createWebHistory } from 'vue-router'; // Use from 'vue-router' instead of 'vue/dist/vue.esm-bundler.js'
import Routes from './routes.js';

window.Alpine = Alpine;
Alpine.start();

const app = createApp({});
const router = createRouter({
    history: createWebHistory(), // Ensure to use createWebHistory for history mode
    routes: Routes,
});

app.use(router);
app.mount('#app');
