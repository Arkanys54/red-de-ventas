import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        // Optimización para producción (esbuild va integrado en Vite, sin dependencias extra)
        minify: 'esbuild',
        // Chunk splitting para mejor caching
        rollupOptions: {
            output: {
                manualChunks: {
                    'vendor': ['bootstrap'],
                },
            },
        },
        // Aumentar límite de chunk para advertencias
        chunkSizeWarningLimit: 1000,
        // Source maps solo en desarrollo
        sourcemap: false,
    },
    server: {
        hmr: {
            host: 'localhost',
        },
    },
});
