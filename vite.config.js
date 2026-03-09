import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
        input: [
            'resources/css/app.css',           // tu CSS principal (login, etc.)
            'resources/css/app-adminlte.css',  // tu CSS de AdminLTE
            'resources/js/app.js',             // JS principal
            'resources/js/app-adminlte.js'     // JS de AdminLTE si existe
        ],
        refresh: true,  // recarga automática al cambiar Blade o CSS/JS
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
    },
    });