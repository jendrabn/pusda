import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
  plugins: [
    laravel({
      input: ["resources/scss/front/style.scss", 'resources/scss/adminlte4/adminlte.scss'],
      refresh: true,
    }),
  ],
});
