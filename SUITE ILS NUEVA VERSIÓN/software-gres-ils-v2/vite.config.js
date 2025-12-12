import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/gres-mec.js',
                'resources/js/gres-equipos-mec.js',
                'resources/js/gres-equipos-colab.js'
            ],
            refresh: true,
        }),
    ],
    optimizeDeps: {
        include: ['alpinejs'], // Excluye Alpine.js si lo usas
    },
    build: {
        commonjsOptions: {
            transformMixedEsModules: true, // Permite transformar módulos mixtos
        }
    }
});
