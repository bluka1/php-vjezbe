# Migracija SQLite baze
Ako koristimo SQLite, migracija je vrlo jednostavna jer je cijela baza jedna datoteka (npr. `database/database.sqlite`).

1. Pronađemo SQLite datoteku na lokalnom računalu (najčešće `database/database.sqlite`).
2. Kopiramo datoteku na server (npr. pomoću scp -> scp je po defaultu dostupan na Linuxu i Macu, a u novijim verzijama i na windowsu kroz command prompt):
```bash
scp database/database.sqlite korisnik@IP_ADRESA_SERVERA:/putanja/do/projekta/database/database.sqlite
```
3. Na serveru, u `.env` datoteci postavimo:
```bash
DB_CONNECTION=sqlite
DB_DATABASE=/putanja/do/projekta/database/database.sqlite
```
4. Nema potrebe za import/export kao kod MySQL-a – dovoljno je prenijeti datoteku

# Import iz SQLite u MySQL
Ako želimo prebaciti podatke iz SQLite baze u MySQL:

Windows:
1. Preuzmite sqlite3 alat sa službene stranice: https://www.sqlite.org/download.html
2. Raspakirajte zip
 
Mac: `brew install sqlite3`

Linux: `sudo apt install sqlite3`

1. Na lokalnom računalu, eksportamo SQLite bazu u .sql datoteku:
```bash
  sqlite3 database/database.sqlite .dump > sqlite_dump.sql
```
Windows - pokrenite naredbu iz foldera gdje se nalazi sqlite3.exe
```bash
  sqlite3.exe putanja\do\projekta\database\database.sqlite ".dump" > sqlite_dump.sql
```
   
2. Prenesemo .sql datoteku na server (kao kod MySQL-a):
```bash
  scp sqlite_dump.sql root@IP_ADRESA_SERVERA:~/
```

3. Na serveru, importamo podatke u MySQL bazu:
```bash
  mysql -u produkcijski_korisnik -p produkcijska_baza < sqlite_dump.sql
```

4. Ažuriramo `.env` datoteku da koristi MySQL:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=produkcijska_baza
DB_USERNAME=produkcijski_korisnik
DB_PASSWORD=jaka-lozinka-123
```