import jigsaw from "@tighten/jigsaw-vite-plugin";
import { defineConfig } from "vite";
import tailwindcss from "@tailwindcss/vite";

const isPolling = true
/**
 * Ottimizzazioni per avvio più rapido:
 * - Disabilita sourcemap CSS in dev (meno lavoro di trasformazione)
 * - Riduce i watcher ignorando cartelle pesanti
 * - Evita polling se non necessario (più veloce localmente)
 * - Guida optimizeDeps per ridurre la scansione iniziale
 */
export default defineConfig({
  plugins: [
    jigsaw({
      input: ["source/_assets/js/main.js", "source/_assets/css/main.css"],
      refresh: true,
    }),
    tailwindcss(),
  ],
  css: {
    devSourcemap: false,
  },
  optimizeDeps: {
    // Guida Vite nel pre-bundling per ridurre il crawl iniziale
    entries: ["source/_assets/js/main.js"],
  },
  server: {
    watch: {
      usePolling: isPolling,
      interval: isPolling ? 100 : undefined,
      // Evita di osservare directory pesanti (migliora avvio e uso CPU)
      ignored: [
        "**/node_modules/**",
        "**/.git/**",
        "**/.idea/**",
        "**/vendor/**",
        "**/storage/**",
        "**/public/**",
        "**/build/**",
        "**/dist/**",
      ],
    },
  },
  build: {
    sourcemap: false,
    // Minificatore CSS rapido per build (non impatta dev ma velocizza le build)
    cssMinify: "lightningcss",
  },
});
