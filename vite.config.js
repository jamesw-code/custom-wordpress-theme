import { defineConfig } from "vite";

export default defineConfig({
    build: {
        outDir: "./jwctechtheme/build",
        emptyOutDir: true,
        manifest: true,
        rollupOptions: {
            input: "./src/main.js"
        }
    }
});
