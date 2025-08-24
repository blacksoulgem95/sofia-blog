import Alpine from "alpinejs";
import Fuse from "fuse.js";
// Importazione di Prism.js per l'evidenziazione della sintassi
import Prism from 'prismjs';

// Importazione esplicita dei file CSS per garantire che Vite li osservi
import '../css/main.css';

// Importazione di componenti base necessari per evitare errori
// markup-templating è richiesto da PHP per evitare l'errore "tokenizePlaceholders"
import 'prismjs/components/prism-markup';
import 'prismjs/components/prism-markup-templating';

// Importazione dell'autoloader per caricare i linguaggi dinamicamente
import 'prismjs/plugins/autoloader/prism-autoloader';
// Importazione del nostro script per l'editor VS Code
import './vscode-editor.js';

// Configura l'autoloader per caricare i linguaggi da CDN
Prism.plugins.autoloader.languages_path = 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/';

// Rendi Prism disponibile globalmente
window.Prism = Prism;

// Rendi disponibili altre librerie
window.Fuse = Fuse;
window.Alpine = Alpine;

// Inizializzazione di Prism
document.addEventListener('DOMContentLoaded', () => {
    // Attendiamo che il DOM e l'autoloader siano pronti
    setTimeout(() => {
        try {
            Prism.highlightAll();
            console.log('Prism.js inizializzato con successo');
        } catch (e) {
            console.error('Errore durante l\'inizializzazione di Prism:', e);
        }
    }, 300);
});

Alpine.start();
