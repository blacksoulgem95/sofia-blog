---
extends: _layouts.post
section: content
title: "Mongobleed Vulnerability: perché è il nuovo Heartbleed di MongoDB"
date: 2025-12-28
description: "Mongobleed: come Babbo Natale ci regala 300 miliardi di dollari su Rainbow Six Siege"
cover_image: /assets/images/mongobleed/image.png
featured: true
categories: [ software, databasse, security, it ]
---

Il giorno di Natale è stata resa pubblica una vulnerabilità critica che colpisce **MongoDB**, uno dei database NoSQL più utilizzati al mondo. Il nome informale è **Mongobleed**, e il motivo per cui se ne sta parlando così tanto è semplice:

👉 permette a un attaccante **non autenticato** di leggere porzioni di **memoria interna del server**.

Se questa frase ti fa venire in mente *Heartbleed*, non sei fuori strada. Il parallelo è tutt’altro che forzato.

## Un déjà‑vu chiamato Heartbleed

Nel 2014 Heartbleed ha segnato un prima e un dopo nella sicurezza informatica. Un bug in OpenSSL permetteva a chiunque di chiedere a un server: *“Mandami X byte di memoria”*, anche se quei byte non esistevano davvero.

Il server si fidava.

Risultato? Chiavi private, password, token e dati sensibili finivano letteralmente **spediti sulla rete**.

La vulnerabilità Mongobleed segue **lo stesso principio concettuale**:

* il server si fida di una dimensione dichiarata dal client
* alloca memoria sulla base di quella dimensione
* restituisce più dati di quelli legittimi

Non è un bug “strano”. È un bug **classico**. Ed è proprio questo il problema.

## MongoDB, BSON e ZLIB: il contesto tecnico

MongoDB comunica usando **BSON** (*Binary JSON*), un formato binario strutturato. Per ottimizzare le prestazioni, il protocollo supporta la **compressione ZLIB**.

Fin qui tutto normale.

Il punto critico è che **ZLIB viene usato anche prima dell’autenticazione**: già durante l’handshake iniziale, quando il client non ha ancora dimostrato chi è.

Questo significa che:

> chiunque possa parlare il protocollo MongoDB può arrivare al codice vulnerabile.

Niente password. Niente account. Niente privilegi.

## Come funziona l’exploit (senza magia nera)

Vediamolo passo per passo.

### 1. Il messaggio malevolo

L’attaccante invia un messaggio `opCompressed` dichiarando una dimensione *decompressa* molto più grande di quella reale.

Esempio:

* dati reali: 20 byte
* dimensione dichiarata: 8.192 byte

### 2. Allocazione della memoria

MongoDB si fida della dimensione dichiarata e alloca un buffer di quella grandezza usando **glibc** (la libreria C standard).

### 3. Decompressione

ZLIB scrive i dati reali nel buffer.

Il resto dello spazio?
👉 **memoria non inizializzata**.

### 4. Il leak

MongoDB tratta l’intero buffer come valido e lo rimanda indietro nella risposta.

Risultato: il client riceve **pezzi arbitrari della memoria del processo MongoDB**.

## “È solo memoria non inizializzata”… davvero?

Qui casca l’asino.

La memoria non inizializzata **non è vuota**. Contiene quello che c’era prima:

* hash di password
* query di altri utenti
* token API
* chiavi crittografiche
* metadati di operazioni precedenti

Allocator come `malloc` **non azzerano la memoria per default**. Sarebbe troppo costoso in termini di performance.

Su un server con traffico reale, questo bug diventa una **miniera di dati sensibili**.

## Proof‑of‑Concept: facilità imbarazzante

Il Proof‑of‑Concept pubblico è uscito lo stesso giorno della disclosure.

* Docker Compose
* uno script Python
* qualche probe con buffer di dimensioni crescenti

Fine.

Niente exploit kernel.
Niente chain complesse.
Niente reverse engineering profondo.

La semplicità è ciò che rende questa vulnerabilità **estremamente pericolosa**.

## Impatti reali: il caso Ubisoft

Non stiamo parlando di teoria.

Diversi gruppi hanno sfruttato Mongobleed contro infrastrutture **Ubisoft**, in particolare i server di *Rainbow Six Siege*.

Da lì:

* accesso a repository Git interni
* esfiltrazione di codice sorgente
* manipolazione di asset e valute di gioco generando moneta in game

Quattro gruppi distinti. Incidenti multipli. Danni reali.

Un memory leak raramente resta “solo” un memory leak.

## Mitigazione: cosa fare adesso

La soluzione è tanto noiosa quanto efficace:

👉 **aggiornare MongoDB immediatamente**.

* MongoDB Atlas (servizio gestito) era già patchato prima della divulgazione
* le istanze self‑hosted non aggiornate restano vulnerabili

Non risultano problemi di backward compatibility rilevanti.

Rimandare significa semplicemente **lasciare la porta aperta**.

## Una nota su C++ e sicurezza della memoria

MongoDB è scritto principalmente in **C++**, e questa è una vulnerabilità figlia diretta della *memory unsafety*.

Un’implementazione in Rust probabilmente avrebbe causato un panic e il crash del processo.

È un trade‑off:

* C++ → continuità del servizio, rischio di leak silenziosi
* Rust → crash rumoroso, ma niente esfiltrazione

In certi contesti, perdere disponibilità è preferibile a perdere **segreti**.

> ⚠️ **Attenzione:**  
Questo **non significa che Rust sia "meglio" di C++**.  
- C e C++ sono generalmente **più efficienti di Rust**: efficienza che è fondamentale per database ad alte prestazioni.
- **Si può scrivere codice sicuro ed efficiente anche in C!** Un esempio? Il nostro Salvatore Sanfilippo e il suo *Redis*.

La chiave resta sempre la stessa:
- **Non fidarti mai dell’utente.**
- **Verifica sempre** che la memoria che utilizzi sia esattamente quella che vuoi utilizzare.

## Conclusione

Mongobleed è un promemoria brutale:

> la memoria resta uno dei punti deboli più pericolosi dei sistemi moderni.

Se gestisci database esposti a Internet, questo tipo di bug **non è opzionale da capire**.

Aggiorna. Verifica. E non dare mai per scontato che “è solo memoria spazzatura”.

Perché, quasi sempre, non lo è.

---
**Proof of Concept della vulnerabilità CVE-2025-14847**: [disponibile qui su GitHub](https://github.com/joe-desimone/mongobleed)