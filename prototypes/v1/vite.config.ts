import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vite.dev/config/
import { defineConfig } from 'vite'
import { resolve } from 'path'
import vue from '@vitejs/plugin-vue'
import UnoCSS from 'unocss/vite'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    UnoCSS(),
  ],

  // Vite does not support alias in html files.
  // https://github.com/vitejs/vite/issues/3000
  resolve: {
    alias: {
      // Remove this line on production.
      vue: 'vue/dist/vue.esm-bundler',

      '~': resolve(__dirname, './'),
      '@': resolve(__dirname, './src'),
    },
  },

  // Build multiple pages.
  // https://vitejs.dev/guide/build.html#multi-page-app
  build: {
    rollupOptions: {
      input: {
        'main': resolve(__dirname, 'index.html'),
        'singles': resolve(__dirname, 'singles/index.html'),
        // 'about': resolve(__dirname, 'about/index.html'),
        // '404': resolve(__dirname, '404/index.html'),
        // 'terms': resolve(__dirname, 'terms/index.html'),
        // 'privacy': resolve(__dirname, 'privacy/index.html')
      },
      output: {
        // https://rollupjs.org/guide/en/#outputmanualchunks
        manualChunks: {
          'vendors': [
            'vue'
          ]
        }
      }
    }
  },
  
})
