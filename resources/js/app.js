import '../css/app.css';
import 'primeicons/primeicons.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// 1. Importer PrimeVue et le thème Aura
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura'; 
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';

createInertiaApp({
    title: (title) => `${title} - My App`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                // Configuration du thème Aura
                theme: {
                    preset: Aura,
                    options: {
                        prefix: 'p',
                        darkModeSelector: 'none', // Force le mode clair pour éviter les textes blancs sur fond blanc
                        cssLayer: false
                    }
                }
            })
            .use(ToastService)
            .use(ConfirmationService)
            .mount(el);
    },
});