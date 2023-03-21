import { defineConfig } from "vite";
import symfonyPlugin from "vite-plugin-symfony";

/* if you're using React */
// import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [
    /* react(), // if you're using React */
    symfonyPlugin(),
  ],
  build: {
    target: 'esnext',
    rollupOptions: {
      input: {
        app: "./assets/js/app.js",
      },
      output: {
        assetFileNames: (assetInfo) => {
          let extType = assetInfo.name.split(".").at(1);
          if (/png|jpe?g|svg|gif|webp|avif|tiff|bmp|ico/i.test(extType)) {
            extType = "img";
          } else if (/otf|ttf|woff|woff2/i.test(extType)) {
            extType = "fonts";
          }
          return `assets/${extType}/[name]-[hash][extname]`;
        },
      },
    },
  },
});
