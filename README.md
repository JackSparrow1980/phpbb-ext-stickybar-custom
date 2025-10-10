# StickyBar (Custom Fork)

## English

### Overview
Unofficial custom fork of HiFiKabin's StickyBar extension for phpBB. This build focuses on improving the behaviour of the prosilver navigation bar and dropdown menus when switching between the default navbar and the sticky version.

### Key changes compared to the original project
- Fixes layout glitches when the navbar becomes sticky.
- Ensures dropdowns (notifications, private messages, quick links, profile) remain usable.
- Publishes releases with the `-custom` suffix to distinguish them from the official extension.

### Installation
1. Copy this repository to `phpBB/ext/hifikabin/stickybar`.
2. In the ACP go to **Customise → Extensions** and enable **Sticky navigation bar**.

### Version check
This fork serves its own version manifest from the `versioncheck/` directory of the repository. If you re-host the package, make sure the manifest is accessible to phpBB.

### Credits & License
- Original author: **HiFiKabin** — <https://github.com/HiFiKabin/stickybar>
- Current maintainer (custom fork): **JackSparrow1980**
- License: GPL-2.0 (inherits from the upstream project)

---

## Italiano

### Panoramica
Fork personalizzato non ufficiale dell'estensione StickyBar di HiFiKabin per phpBB. Questa versione punta a migliorare il comportamento della barra di navigazione di prosilver e dei menu a tendina durante il passaggio tra la modalità standard e quella "sticky".

### Differenze principali rispetto al progetto originale
- Correzione dei problemi di layout quando la barra diventa fissa.
- Migliore usabilità dei menu a tendina (notifiche, messaggi privati, collegamenti rapidi, profilo).
- Rilasci contrassegnati dal suffisso `-custom` per distinguerli dalle versioni ufficiali.

### Installazione
1. Copia questa cartella in `phpBB/ext/hifikabin/stickybar`.
2. Nel PCA vai su **Personalizza → Estensioni** e abilita **Sticky navigation bar**.

### Controllo versioni
Questo fork utilizza un proprio manifesto di aggiornamento presente nella cartella `versioncheck/` del repository. Se distribuisci il pacchetto altrove, verifica che il file sia raggiungibile da phpBB.

### Crediti e licenza
- Autore originale: **HiFiKabin** — <https://github.com/HiFiKabin/stickybar>
- Maintainer attuale (fork personalizzato): **JackSparrow1980**
- Licenza: GPL-2.0 (come il progetto originale)
