// Retro CRT editor per blocchi di codice
document.addEventListener('DOMContentLoaded', () => {
    // Trova tutti i blocchi pre>code
    const codeBlocks = document.querySelectorAll('pre > code');

    codeBlocks.forEach((codeBlock, index) => {
        const pre = codeBlock.parentElement;

        // Estrai la lingua dal classname (se presente)
        let language = 'text';
        codeBlock.classList.forEach(className => {
            if (className.startsWith('language-')) {
                language = className.replace('language-', '');

                // Assicuriamoci che la classe language sia correttamente impostata
                // per consentire all'autoloader di caricare il linguaggio corretto
                if (!codeBlock.classList.contains(`language-${language}`)) {
                    codeBlock.classList.add(`language-${language}`);
                }
            }
        });

        // Genera un ID unico per questo blocco di codice
        const blockId = `code-block-${index}`;
        codeBlock.id = blockId;

        // Crea il wrapper dell'editor retro CRT
        const editorWrapper = document.createElement('div');
        editorWrapper.className = 'vscode-editor';

        // Aggiungi un attributo data-language per styling condizionale
        editorWrapper.setAttribute('data-language', language);

        // Fix avanzato per l'indentazione sulla prima riga
        setTimeout(() => {
            const codeElements = editorWrapper.querySelectorAll('pre code');
            codeElements.forEach(codeEl => {
                // Assicurati che non ci sia indentazione
                codeEl.style.textIndent = '0';
                codeEl.style.paddingLeft = '0';
                codeEl.style.marginLeft = '0';

                // Se Prism ha già evidenziato, normalizza il primo token
                const firstToken = codeEl.querySelector('.token:first-child');
                if (firstToken) {
                    firstToken.style.marginLeft = '0';
                    firstToken.style.paddingLeft = '0';
                    firstToken.style.textIndent = '0';
                    firstToken.style.display = 'inline';
                }

                // Normalizza il contenuto testo
                const codeContent = codeEl.innerHTML;
                if (codeContent && codeContent.trim()) {
                    // Se ci sono spazi iniziali, li rimuoviamo
                    codeEl.innerHTML = codeContent.replace(/^(\s+)/, '');
                }
            });
        }, 10);

        // Secondo fix dopo che Prism ha completato l'evidenziazione
        setTimeout(() => {
            const codeElements = editorWrapper.querySelectorAll('pre code');
            codeElements.forEach(codeEl => {
                // Normalizza nuovamente dopo l'evidenziazione di Prism
                const tokens = codeEl.querySelectorAll('.token');
                if (tokens.length > 0) {
                    tokens[0].style.marginLeft = '0';
                    tokens[0].style.paddingLeft = '0';
                    tokens[0].style.textIndent = '0';
                    tokens[0].style.display = 'inline';
                }
            });
        }, 300);

        // Crea la barra del titolo
        const titleBar = document.createElement('div');
        titleBar.className = 'vscode-editor-titlebar';

        // Crea un titolo più retro per il terminale
        const fileTitle = 'file';

        // Aggiungi i pulsanti di controllo
        titleBar.innerHTML = `
            <div class="vscode-editor-controls">
                <span class="vscode-editor-control close"></span>
                <span class="vscode-editor-control minimize"></span>
                <span class="vscode-editor-control maximize"></span>
            </div>
            <div class="vscode-editor-title">
                <span class="vscode-editor-filename">${fileTitle}.${language}</span>
            </div>
            <div class="vscode-editor-actions">
                <button class="vscode-editor-copy-btn" data-target="${blockId}">COPY</button>
            </div>
        `;

        // Crea il contenitore per i numeri di riga
        const lineNumbers = document.createElement('div');
        lineNumbers.className = 'vscode-editor-line-numbers';

        // Conta le linee di codice
        const lines = codeBlock.textContent.split('\n');
        const lineCount = lines.length;

        // Misura l'altezza di una linea di codice per calibrare
        const testLineHeight = document.createElement('div');
        testLineHeight.style.position = 'absolute';
        testLineHeight.style.visibility = 'hidden';
        testLineHeight.style.fontFamily = '"Perfect DOS VGA 437", "MS Gothic", "Terminal", "Courier New", monospace';
        testLineHeight.style.fontSize = '14px';
        testLineHeight.style.lineHeight = '1.6';
        testLineHeight.textContent = 'X';
        document.body.appendChild(testLineHeight);
        const lineHeight = testLineHeight.offsetHeight;
        document.body.removeChild(testLineHeight);

        // Genera i numeri di riga
        for (let i = 1; i <= lineCount; i++) {
            const lineNumber = document.createElement('div');
            lineNumber.className = 'vscode-editor-line-number';
            lineNumber.textContent = i;
            // Imposta esplicitamente l'altezza di ciascun numero di riga
            lineNumber.style.height = `${lineHeight}px`;
            lineNumbers.appendChild(lineNumber);
        }

        // Crea il contenitore per il codice
        const codeContainer = document.createElement('div');
        codeContainer.className = 'vscode-editor-code-container';

        // Aggiunge attributi al pre esistente per garantire l'allineamento
        pre.style.lineHeight = '1.6';
        pre.style.tabSize = '4';

        // Aggiunge una classe all'editor per l'allineamento
        editorWrapper.classList.add('line-sync');

        // Sincronizza lo scorrimento verticale tra il contenitore del codice e i numeri di riga
        let lastScrollTop = 0;
        codeContainer.addEventListener('scroll', () => {
            const scrollTop = codeContainer.scrollTop;

            // Calcola l'offset esatto per l'allineamento
            const offset = scrollTop;

            // Applica l'offset usando translateY per prestazioni migliori
            lineNumbers.style.transform = `translateY(-${offset}px)`;

            // Salva l'ultimo valore di scroll per riferimento
            lastScrollTop = scrollTop;

            // Verifica l'allineamento dopo lo scroll
            checkLineAlignment(codeContainer, lineNumbers);
        });

        // Funzione per verificare e correggere l'allineamento delle linee
        function checkLineAlignment(codeContainer, lineNumbers) {
            // Implementa una correzione di allineamento se necessario
            requestAnimationFrame(() => {
                // Assicura che i numeri di riga siano allineati con il codice
                const codeLines = codeContainer.querySelectorAll('pre code .token-line, pre code .line');
                const numberLines = lineNumbers.querySelectorAll('.vscode-editor-line-number');

                // Se non ci sono token-line, prova a usare le linee di testo
                if (codeLines.length === 0 && numberLines.length > 0) {
                    // Misura l'offset di ogni linea di testo per calibrare
                    const preRect = codeContainer.querySelector('pre').getBoundingClientRect();
                    const preTop = preRect.top;

                    // Regola ogni numero di riga singolarmente se necessario
                    Array.from(numberLines).forEach((numLine, i) => {
                        // Calcola la posizione ideale
                        const idealPos = i * lineHeight;
                        // Imposta l'altezza esatta
                        numLine.style.height = `${lineHeight}px`;
                    });
                }
            });
        }

        // Estrai il pre esistente
        pre.parentNode.insertBefore(editorWrapper, pre);

        // Sposta il pre all'interno del contenitore del codice
        codeContainer.appendChild(pre);

        // Assembla l'editor
        editorWrapper.appendChild(titleBar);
        editorWrapper.appendChild(document.createElement('div')).className = 'vscode-editor-content';
        editorWrapper.querySelector('.vscode-editor-content').appendChild(lineNumbers);
        editorWrapper.querySelector('.vscode-editor-content').appendChild(codeContainer);

        // Aggiungi funzionalità di copia
        const copyButton = editorWrapper.querySelector('.vscode-editor-copy-btn');
        copyButton.addEventListener('click', () => {
            const codeText = codeBlock.textContent;
            navigator.clipboard.writeText(codeText).then(() => {
                // Effetto "glitch" quando viene copiato
                copyButton.textContent = 'COPIED!';
                copyButton.style.animation = 'text-flicker 0.5s';

                // Reset dopo 2 secondi
                setTimeout(() => {
                    copyButton.textContent = 'COPY';
                    copyButton.style.animation = '';
                }, 2000);
            });
        });

        // Aggiungi effetto di accensione
        setTimeout(() => {
            editorWrapper.classList.add('crt-on');

            // Aggiungi un po' di flicker casuale agli elementi del codice
            const codeElements = editorWrapper.querySelectorAll('.token');
            codeElements.forEach(el => {
                if (Math.random() > 0.8) {
                    el.style.animation = `text-flicker ${Math.random() * 5 + 2}s infinite`;
                }
            });

            // Riallinea i numeri di riga dopo che il contenuto è stato renderizzato completamente
            realignLineNumbers(lineNumbers, codeContainer);
        }, 100);
    });

    // Utilizziamo la funzione di inizializzazione di Prism.js personalizzata
    document.addEventListener('DOMContentLoaded', () => {
        // Assicuriamoci che tutti i blocchi di codice siano pronti
        setTimeout(() => {
            if (window.initPrism && typeof window.initPrism === 'function') {
                window.initPrism();
            }
        }, 500);
    });

    // Funzione globale per riallineare i numeri di riga
    function realignLineNumbers(lineNumbers, codeContainer) {
        // Attendiamo che Prism.js abbia terminato l'evidenziazione della sintassi
        setTimeout(() => {
            // Calcola l'altezza effettiva di una linea
            const codeRect = codeContainer.querySelector('pre').getBoundingClientRect();
            const lineNumbersRect = lineNumbers.getBoundingClientRect();

            // Imposta un'altezza di linea coerente per tutto
            const style = document.createElement('style');
            style.textContent = `
                .vscode-editor-code-container pre,
                .vscode-editor-code-container pre code,
                .vscode-editor-line-numbers,
                .vscode-editor-line-number {
                    line-height: 1.6 !important;
                    font-size: 14px !important;
                }

                .vscode-editor-line-number {
                    height: 1.6em !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: flex-end !important;
                }

                .vscode-editor-code-container pre {
                    padding-top: 12px !important;
                    padding-bottom: 12px !important;
                }

                .vscode-editor-line-numbers {
                    padding-top: 12px !important;
                    padding-bottom: 12px !important;
                }
            `;

            document.head.appendChild(style);

            // Forza un ricalcolo
            codeContainer.scrollTop = 0;
            lineNumbers.style.transform = 'translateY(0)';

            // Aggiunge un'osservatore per mantenere l'allineamento quando cambia il contenuto
            if ('ResizeObserver' in window) {
                const resizeObserver = new ResizeObserver(() => {
                    // Riapplica lo scroll corretto
                    lineNumbers.style.transform = `translateY(-${codeContainer.scrollTop}px)`;
                });

                resizeObserver.observe(codeContainer.querySelector('pre'));
            }
        }, 300); // Attendiamo che l'evidenziazione sia completata
    }

    // Aggiungi un suono retro CRT quando l'utente interagisce con gli editor
    document.addEventListener('click', function(e) {
        if (e.target.closest('.vscode-editor')) {
            try {
                // Crea un piccolo 'bzzzt' come suono di interazione CRT
                // Verifica se l'API Web Audio è supportata
                if (window.AudioContext || window.webkitAudioContext) {
                    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                    const oscillator = audioContext.createOscillator();
                    const gainNode = audioContext.createGain();

                    oscillator.type = 'sawtooth';
                    oscillator.frequency.setValueAtTime(60, audioContext.currentTime);
                    gainNode.gain.setValueAtTime(0.05, audioContext.currentTime);

                    oscillator.connect(gainNode);
                    gainNode.connect(audioContext.destination);

                    oscillator.start();
                    gainNode.gain.exponentialRampToValueAtTime(0.001, audioContext.currentTime + 0.1);
                    oscillator.stop(audioContext.currentTime + 0.1);
                }
            } catch (e) {
                // Ignora errori di audio - alcuni browser potrebbero non supportare l'API
                console.log('Audio not supported');
            }
        }
    }, false);
});
