import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/home.css',
                'resources/css/login.css',
                'resources/css/pdf.css',
                'resources/css/reset.css',
                'resources/css/welcome.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
