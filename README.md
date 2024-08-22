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

Attendere che i servizi siano tutti operativi (solitamente qualche secondo) altrimente è probabile che venga restituito l'errore 504 Gateway Time-out. Nel caso accadesse, provare a fare refresh sul browser.

```bash
docker-compose up --build -d
```

### Arresto

```bash
docker-compose down
```

## Utilizzo e informazioni  
Una volta avviato, il servizio è raggiungibile all'indirizzo http://localhost/.

Gli endpoint di create e update possono essere chiamati sia da CURL che da pagina PHP che ho realizzato appositamente per lo scopo.

Ad ogni errore nelle chiamate endpoint (token errato, formato dati errato, stringhe vuote, etc) viene restituito un json contenente l'errore, come ad esempio: _{"error":"Numeric Id expected"}_.

Ad ogni azione andata a buon fine viene restituito un json con un messaggio, tipo _{"message":"Created", "newid"=>5}_.
  
Ho utilizzato un Token come autorizzazione alle operazione di creazione, modifica e cancellazione. Il token è molto semplice in realtà, è un banale MD5 della data odierna (in php: _md5(date("Ymd")_).

Utilizzare http://localhost/token_generate.php per visualizzare il token da chiamare con i CURL (successivamente, negli esempi, il token viene visualizzato con la parola TOKEN).

La creazione del profile ha la rimozione del prefisso internazionale, sia esso scritto con il + che con lo 00 iniziali (per farlo ho realizzato una funzione ad-hoc con RegEx).
 
## Chiamate agli endpoint  
La chiamata all'endpoint http://localhost/ visualizza le due tabelle (profiles e profile_attributes) per agevolare la visualizzazione di ciò che è contenuto nel database e il file di log, in formato semplificato.
 
**Visualizzazione di tutti i profiles** (compresi i relativi attributes):  
http://localhost/profile/
 
**Visualizzazione di uno specifico profile** (compresi i suoi relativi attributes):  
http://localhost/profile/1/
 
**Creazione di un profile**  
Eventualmente si può anche usare il file http://localhost/create_profile.php (con le dovute modifiche):  
```
curl -X PUT http://localhost/profile/ 
     -H 'Content-Type: application/json' 
     -H 'Accept: application/json' 
     -H 'X-Token: TOKEN' 
     -d '{"name": "Paolo", "lastname": "Rossi", "phone": "+413311002167"}'
```

**Modifica di un profile** (indicare l'ID)  
Eventualmente si può anche usare il file http://localhost/update_profile.php (con le dovute modifiche): 
```
curl -X PATCH http://localhost/profile/1/
     -H 'Content-Type: application/json'
     -H 'Accept: application/json'
     -H 'X-Token: TOKEN'
     -d '{"name": "Paolo", "lastname": "Rossi", "phone": "+413311002167"}'
```

**Cancellazione di un profile** (indicare l'ID)  
Eventualmente si può anche usare il file http://localhost/delete_profile.php (con le dovute modifiche): 
```
curl -X DELETE http://localhost/profile/1/
     -H 'Content-Type: application/json'
     -H 'Accept: application/json'
     -H 'X-Token: TOKEN'
```

**Creazione di un profile attribute**  
Eventualmente si può anche usare il file http://localhost/create_attribute.php (con le dovute modifiche):  
```
curl -X PUT http://localhost/attribute/ 
     -H 'Content-Type: application/json' 
     -H 'Accept: application/json' 
     -H 'X-Token: TOKEN' 
     -d '{"attribute": "Ingegnere", "profile_id": 1}'
```

**Modifica di un profile attribute** (indicare l'ID)  
Eventualmente si può anche usare il file http://localhost/update_attribute.php (con le dovute modifiche): 
```
curl -X PATCH http://localhost/attribute/1/
     -H 'Content-Type: application/json'
     -H 'Accept: application/json'
     -H 'X-Token: TOKEN'
     -d '{"attribute": "Ingegnere", "profile_id": 1}'
```

**Cancellazione di un profile attribute** (indicare l'ID)  
Eventualmente si può anche usare il file http://localhost/delete_attribute.php (con le dovute modifiche): 
```
curl -X DELETE http://localhost/attribute/1/
     -H 'Content-Type: application/json'
     -H 'Accept: application/json'
     -H 'X-Token: TOKEN'
```

## Middleware  
Ho creato un middleware di base che registra tutte le operazioni nel file _storage/logs/access.log_ che viene anche visualizzato nella pagina con endpoint http://localhost/.

I dati che vengono registrati sono dati "base" (non sono entrato nel dettaglio), come ad esempio data e ora, tipo di chiamata e url.

Qui sotto un esempio di riga del file log.

```
2024-08-04 01:13:29	GET	/profile/2/
2024-08-04 01:13:33	GET	/profile/1/
2024-08-04 01:13:36	GET	/profile/
```
