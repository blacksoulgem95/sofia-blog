import jigsaw from "@tighten/jigsaw-vite-plugin";
import {defineConfig} from "vite";
import tailwindcss from "@tailwindcss/vite";
import fs from 'fs';

// Rileva se siamo in ambiente WSL
const isWsl = (() => {
    try {
        return fs.readFileSync('/proc/version', 'utf8').toLowerCase().includes('microsoft');
    } catch (e) {
        return false;
    }
})();

console.log("Running in WSL: ", isWsl ? "Yes" : "No")

/**
 * Ottimizzazioni per avvio più rapido:
 * - Disabilita sourcemap CSS in dev (meno lavoro di trasformazione)
 * - Riduce i watcher ignorando cartelle pesanti
 * - Configura polling ottimizzato per WSL
 * - Guida optimizeDeps per ridurre la scansione iniziale
 */
export default defineConfig({
    plugins: [
        jigsaw({
            input: [
                "source/_assets/js/main.js",
                "source/_assets/css/main.css"
            ],
            // Indica a Jigsaw di aggiornare la pagina quando cambiano questi tipi di file
            refresh: [
                "source/_assets/**/*.css",
                "source/_assets/**/*.scss",
                "source/_assets/**/*.sass",
                "source/_assets/**/*.less",
                "source/_assets/**/*.styl",
                "source/_assets/**/*.html",
                "source/_assets/**/*.php",
                "source/_assets/**/*.md",
                "source/_assets/**/*.blade.php",
                "source/**/*.blade.php"
            ],
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
        // Abilita tutte le origini per accedere da altri dispositivi
        host: '0.0.0.0',

        // Configurazione HMR più robusta
        hmr: {
            // Forza uso di WebSockets per compatibilità migliore
            protocol: 'ws',
            // Mantiene la connessione attiva
            timeout: 120000,
        },

        watch: {
            // Polling è necessario in WSL2 perché gli eventi del file system
            // non vengono propagati correttamente tra Windows e WSL
            usePolling: true,
            // Riduciamo l'intervallo per una maggiore reattività
            interval: 50,
            // Abilita globbing per poter usare pattern come **/*.css
            disableGlobbing: false,
            // Specificare esplicitamente i file da osservare (importante per WSL)
            include: [
                // Osserva tutti i file CSS
                "source/**/*.css",
                "source/**/*.scss",
                "source/**/*.sass",
                // Osserva file di template e contenuto
                "source/**/*.html",
                "source/**/*.php",
                "source/**/*.md",
                "source/**/*.blade.php",
                // Osserva file JavaScript/TypeScript
                "source/**/*.js",
                "source/**/*.ts",
                "source/**/*.jsx",
                "source/**/*.tsx",
                // Osserva altri tipi di asset
                "source/**/*.json",
                "source/**/*.yaml",
                "source/**/*.yml",
                // Osserva file di configurazione
                "tailwind.config.js",
                "config.php",
                "bootstrap.php",
            ],
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
                "**/cache/**",
            ],
        },

        // Disabilita il controllo di accesso stretto per WSL
        fs: {
            strict: false,
        },
    },
    build: {
        sourcemap: false,
        // Minificatore CSS rapido per build (non impatta dev ma velocizza le build)
        cssMinify: "lightningcss",
    },

    // Log aggiuntivi per debug in WSL
    logLevel: 'debug',

    // Impedisci a Vite di modificare le headers HTTP
    // Questo può causare problemi con alcuni server proxy in WSL
    clearScreen: false,

    // Configurazioni specifiche per WSL
    ...(isWsl ? {
        // In WSL, facciamo un'osservazione più aggressiva per i file CSS
        server: {
            watch: {
                usePolling: true,
                interval: 30, // polling più frequente in WSL
                alwaysStat: true, // Forza controllo sullo stato dei file
                awaitWriteFinish: {
                    stabilityThreshold: 50, // attendi 50ms dopo l'ultima modifica
                    pollInterval: 10, // controlla ogni 10ms
                },
            }
        }
    } : {}),
});

// Script di utilità per cancellare la cache di Vite - può essere eseguito con:
// node -e "require('./vite.config.js').clearViteCache()"
export function clearViteCache() {
    const path = require('path');
    const fs = require('fs');

    const cacheDir = path.resolve(__dirname, 'node_modules/.vite');

    if (fs.existsSync(cacheDir)) {
        console.log('Eliminazione della cache di Vite...');
        fs.rmSync(cacheDir, {recursive: true, force: true});
        console.log('Cache di Vite eliminata con successo!');
    } else {
        console.log('Cache di Vite non trovata.');
    }
}
