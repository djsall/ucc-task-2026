import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/filament/helpdesk/theme.css',
                'resources/js/pages/layout.js',
                'resources/js/auth.js',
                'resources/js/api.js',
                'resources/js/events.js',
                'resources/js/helpdesk.js',
                'resources/js/pages/auth-page.js',
                'resources/js/pages/reset-password-page.js',
                'resources/js/pages/forgot-password-page.js',
                'resources/js/pages/events-page.js',
                'resources/js/pages/helpdesk-page.js',
                'resources/js/pages/common.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
