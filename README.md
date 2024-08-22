# Docker con Lumen 9, Nginx, MySQL 8, e PHP 8.3

Con questa repo potete installare l'intero sistema di test per il progetto API.

Per rendere il progetto fruibile da subito senza ulteriori installazioni, ho incluso i files di configurazione già modificati e il file per la creazione automatica del database con alcuni dati di test all'interno.

## Requisiti

Sono necessari Docker e Docker Compose.

Assicurarsi che le porte 80, 3306 e 9000 non siano già utilizzate da altri servizi.

## Clona questo repo nella cartella desiderata

```bash
git clone https://github.com/bolzabeach/docker-lumen.git
cd docker-lumen
```

### Esecuzione

Attendere che i servizi siano tutti operativi (solitamente qualche secondo).

```bash
docker-compose up --build -d
```

### Arresto

```bash
docker-compose down
```

