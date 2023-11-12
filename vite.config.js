import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/assets/css/icons/font/bootstrap-icons.scss',
                'resources/assets/css/app.css',
                'resources/assets/css/styles.scss',
                'resources/assets/js/app.js',
                'resources/assets/js/main.ts',
            ],
            refresh: true,
            buildDirectory: './dist'
        }),
    ],
});
