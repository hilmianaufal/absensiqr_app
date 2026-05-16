import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),

    VitePWA({
      registerType: 'autoUpdate',
      includeAssets: [
        'pwa/favicon-32x32.png',
        'pwa/apple-touch-icon.png',
        'pwa/maskable-icon.png',
      ],
      manifest: {
        name: 'Absensi Jamaah Sholat - Kebon Jambu',
        short_name: 'Absensi Sholat',
        description: 'Absensi Jamaah Sholat 5 Waktu (Santri Putri) - Pondok Kebon Jambu',
        theme_color: '#16a34a',
        background_color: '#ffffff',
        display: 'standalone',
        start_url: '/',
        scope: '/',
        icons: [
          {
            src: '/pwa/icon-192.png',
            sizes: '192x192',
            type: 'image/png',
          },
          {
            src: '/pwa/icon-512.png',
            sizes: '512x512',
            type: 'image/png',
          },
          {
            src: '/pwa/maskable-icon.png',
            sizes: '512x512',
            type: 'image/png',
            purpose: 'maskable',
          },
        ],
      },
    }),
  ],
});
