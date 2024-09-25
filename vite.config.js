import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { fileURLToPath } from 'url'; // For aliasing

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            // Alias for CKEditor to properly resolve
            '@ckeditor/ckeditor5-build-classic': fileURLToPath(
                new URL('node_modules/@ckeditor/ckeditor5-build-classic', import.meta.url)
            ),
        },
    },
});
