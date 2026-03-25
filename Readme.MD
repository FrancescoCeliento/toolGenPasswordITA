# Generatore di Password

Un'applicazione web leggera e immediata per generare password robuste. Il tool offre due approcci distinti: una password **"Human-friendly"** (basata su termini italiani, facile da ricordare) e una **"Strong"** (completamente casuale e ad alta entropia).

Il progetto è pensato per chi desidera sicurezza senza rinunciare alla praticità, con la garanzia che **nessuna password viene memorizzata sul server**.

## Caratteristiche principali

* **Doppia Modalità**:
    * **Human-friendly**: Utilizza sostantivi italiani estratti da un dizionario locale, combinati con caratteri speciali e numeri. Ideale per chi deve digitare spesso la password a memoria.
    * **Strong**: Generazione puramente casuale che include maiuscole, minuscole, numeri e simboli critici.
* **Logica Adattiva**: Per lunghezze superiori ai 19 caratteri, la modalità "Human" concatena automaticamente due parole diverse per mantenere un'alta sicurezza.
* **Privacy-First**: Il processo avviene interamente lato server in fase di rendering e non salva log o database delle chiavi generate.
* **Interfaccia Responsiva**: Design pulito con funzioni "Copia in un click" ottimizzate anche per dispositivi mobili.

---

## Dettagli Tecnici e Logica

### Funzionamento della Password "Human"
Lo script legge da file di testo (`.txt`) organizzati per lunghezza della parola (es. `_8_letter.txt`).
* **Componenti**: Una o due parole italiane + 3 caratteri speciali + un numero a 2 cifre.
* **Manipolazione**: Una lettera della parola viene trasformata casualmente in MAIUSCOLA per aumentare la complessità contro attacchi dictionary-based.
* **Shuffle**: Tutti i componenti (parole, simboli, numeri) vengono rimescolati (`shuffle`) per evitare che la struttura sia sempre "Parola-Simbolo-Numero".

### Funzionamento della Password "Strong"
Utilizza quattro set di caratteri diversi:
* Lettere minuscole e maiuscole (escludendo caratteri ambigui come `l`, `I`, `O`, `0` in base alla configurazione del set).
* Numeri e Simboli (`!@#$%&*?`).
* **Garanzia**: Lo script assicura che almeno un carattere per ogni categoria sia presente nella password finale.

---

## Struttura del Progetto

* `index.php`: Il cuore dell'applicazione (logica PHP + interfaccia HTML/CSS/JS).
* `style.css`: File per lo stile e il layout del generatore.
* `661562_parole_italiane_[n]_letter.txt`: File di dizionario (per il funzionamento della modalità Human).

---

## Installazione

1.  Clona la repository sul tuo server web (Apache/Nginx con supporto PHP).
3.  Configura i permessi di lettura per i file `.txt`.
4.  Accedi via browser all'indirizzo del tuo server.

---

## Requisiti

* **PHP**: 7.4 o superiore.

---

## Contributi e Crediti

Sviluppato da **Dummy-X**.
* **Sito Web**: [selectallfromdual.com](https://www.selectallfromdual.com)
* **Software Consigliato**: [KeePass](https://www.selectallfromdual.com/blog/286) per la gestione sicura delle tue password.