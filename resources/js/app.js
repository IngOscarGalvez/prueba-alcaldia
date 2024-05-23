import './bootstrap';


import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

// admin lte
import 'admin-lte/dist/css/adminlte.css';
import 'admin-lte/dist/js/adminlte.js';
// bootstrap
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.js';
// jquery
import $ from 'jquery';
// fontawesome
import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';
// material Icons
import 'material-icons/iconfont/material-icons.css';



window.$ = window.jQuery = $;

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Reflect';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, app, props, plugin}) {
        return createApp({render: () => h(app, props)})
            .use(plugin)
            .use(ZiggyVue,Ziggy)
            .mount(el);

    },
}).then(() => {
    InertiaProgress.init({});
})
