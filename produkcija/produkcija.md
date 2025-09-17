# Produkcija

## Domena
Prva stvar koja nam treba da bismo bili vidljivi na internetu je adresa. U stvarnom svijetu, to je kućna adresa. U digitalnom svijetu, to je domena.

### Što je domena?

Svaki server na internetu ima svoju jedinstvenu, numeričku adresu, zvanu IP adresa (npr. 172.217.16.195). Računala se pomoću njih savršeno snalaze, ali ljudima je teško pamtiti sve te brojeve.

Analogija: telefonski imenik. Umjesto da pamtite brojeve prijatelja, pamtite njihova imena. Domena je ime, a IP adresa je telefonski broj.

Domena (npr. google.com) je lako pamtljivo ime koje služi kao "nadimak" za IP adresu.

## Hijerarhija domena
- TLD (Top-Level Domain) - vršna domena, zadnji dio imena - postoje generičke (.com, .org, .net) i nacionalne (.hr, .it, .de)
- SLD (Second-Level Domain) - drugorazinska domena, glavni dio imena koji zakupljujete (google u google.com)
- Subdomena (poddomena) - dio domene koji sami kreirate za organizaciju sadržaja (mail u mail.google.com)

### Povezivanje domene i servera
Preduvjeti:
- aktivni server (u našem primjeru Digital Ocean droplet)
- root/sudo pristup serveru putem ssh ključa
- kupljena domena

#### Konfiguracija DNS-a
1. Dodavanje A zapisa kod registrara domene
```bash 
# pronađite IP adresu vašeg servera
curl -4 icanhazip.com
```
U DNS postavkama domene dodajte:
- A zapis: @ → IP_ADRESA_SERVERA
- A zapis: www → IP_ADRESA_SERVERA

1.2 Provjera DNS propagacije
```bash
# provjerite je li DNS propagiran (je li povezana ip adresa s domenom)
dig +short vasa-domena.com
dig +short www.vasa-domena.com

# ili online na: https://whatsmydns.net/
```
2. Firewall konfiguracija
```bash
# omogućite HTTP i HTTPS promet
sudo ufw allow 'Nginx Full'  # Za Nginx

# provjerite status
sudo ufw status
```

3. Konfiguracija Nginx web servera
- otvorite konfiguraciju: `sudo nano /etc/nginx/sites-available/default`
```bash
# dodajte/uredite server blok:
server {
    listen 80;
    listen [::]:80;
    
    server_name vasa-domena.com www.vasa-domena.com;
    
    root /var/www/html;
    index index.html index.htm index.nginx-debian.html;
    
    location / {
        try_files $uri $uri/ =404;
    }
}
```
- testirajte konfiguraciju: `sudo nginx -t`
- restartajte Nginx: `sudo systemctl reload nginx`
<!-- za Apache
sudo nano /etc/apache2/sites-available/000-default.conf
konfiguracija:
apache<VirtualHost *:80>
    ServerName vasa-domena.com
    ServerAlias www.vasa-domena.com
    DocumentRoot /var/www/html
    
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

test konfiguracije: sudo apache2ctl configtest
restart servera: sudo systemctl reload apache2 -->


## Što je i kako funkcionira DNS?
DNS je kratica za "Domain Name System", što se može prevesti kao "Sustav Imena Domena". Najlakše ga je zamisliti kao divovski, globalni telefonski imenik za internet.

U stvarnom svijetu, vi pamtite imena ljudi, a ne njihove brojeve telefona. Na internetu se događa ista stvar:
- vi pamtite imena web stranica (google.com)
- računala komuniciraju putem IP adresa (142.250.184.78)

DNS je sustav koji prevodi ljudima razumljiva imena domena u računalima razumljive IP adrese.

Kada u preglednik upišete google.com, događa se sljedeći lanac događaja u djeliću sekunde:
1. vaš preglednik pita vaše računalo: "Znaš li IP adresu za google.com?"
2. ako ne zna, pita vašeg internet providera (npr. A1, T-Com...)
3. ako ni oni ne znaju, upit se šalje specijaliziranim DNS serverima po svijetu
4. ti serveri pronađu zapis koji kaže: "google.com se nalazi na IP adresi 142.250.184.78"
5. ta IP adresa se vraća vašem pregledniku
6. tek tada vaš preglednik zna na koju "numeričku adresu" treba poslati zahtjev da bi vam prikazao stranicu

Ukratko, bez DNS-a, morali bismo pamtiti i upisivati IP adrese za svaku web stranicu, što bi internet učinilo gotovo neupotrebljivim.

## DNS zapisi
U kontrolnom panelu vaše domene, podešavate "zapise" koji govore kamo usmjeriti promet:
- A zapis - najvažniji jer povezuje domenu (npr. mojprojekt.hr) s IP adresom vašeg servera
- CNAME - alias - kaže da jedna domena (npr. www.mojprojekt.hr) treba koristiti iste zapise kao i druga (npr. mojprojekt.hr).
- MX zapis - usmjerava e-mail promet na mail server
- TXT zapis - koristi se za razne verifikacije i sigurnosne postavke (npr. dokazivanje vlasništva Googleu)

### Gdje i kako zakupiti domenu?
Domene iznajmljujemo (obično na godinu dana) od tvrtki koje se zovu registrari. Cijeli sustav nadgleda neprofitna organizacija ICANN.

Popularni globalni registrari: Namecheap, GoDaddy, Google Domains.

Hrvatski registrari (za .hr domene): CARNET je glavna institucija, ali zakup se vrši preko ovlaštenih registrara (npr. Plus, Avalon).

Proces zakupa (primjer Namecheap):
- na stranici registrara potražite željeno ime domene
- ako je slobodno, dodajte ga u košaricu
- odaberite period zakupa (1, 2, 5 godina...)
- dovršite kupovinu
- nakon kupovine, u korisničkom sučelju dobivate pristup DNS postavkama gdje ćete kasnije unijeti IP adresu vašeg servera

## Serveri
Sada kada imamo adresu (domenu), treba nam i mjesto gdje će aplikacija živjeti – server.

### Što je server?
U osnovi, server je računalo koje je:

- puno snažnije od običnog računala (koristi specijalizirani hardver poput ECC RAM-a i RAID diskova za pouzdanost)
- stalno upaljeno i spojeno na internet preko vrlo brze i stabilne veze
- njegov jedini posao je da pokreće softver koji čeka zahtjeve (npr. posjet vašoj stranici) i na njih odgovara (servira web stranicu)

Analogija - ako je domena adresa pizzerije, server je sama zgrada s kuhinjom, strujom, vodom i svime potrebnim za rad

### Vrste servera (hosting)
- Shared (dijeljeni)
    - najjeftiniji
    - zamislite da iznajmljujete sobu u studentskom domu. Dijelite kuhinju i kupaonicu (CPU, RAM) s drugima
    - dobro za male, statične stranice, ali loše za Laravel jer susjedi mogu utjecati na vas (ako susjedov site ima previše posjeta, vaš se može usporiti)
    - često dolazi s cPanel sučeljem
- VPS (Virtual Private Server)
    - najbolji omjer cijene i kvalitete
    - zamislite da iznajmljujete stan u zgradi; imate svoje resurse (kuhinju, kupaonicu), ali zgradu dijelite s drugima
    - imate potpunu kontrolu (root pristup) nad svojim virtualnim serverom
    - idealno za većinu Laravel aplikacija
- Dedicated (posvećeni)
    - iznajmljujete cijelu kuću
    - svi resursi su samo vaši
    - maksimalne performanse i sigurnost
    - koristi se za vrlo posjećene aplikacije s visokim zahtjevima
- Cloud hosting (AWS, DigitalOcean, Heroku)
    – zamislite da plaćate samo one sobe u kući koje trenutno koristite
    - fleksibilno je i skalabilno
    - ako vam treba više snage, samo kliknete gumb i resursi se povećaju

### Gdje i kako zakupiti server?
Za početnike i većinu Laravel projekata, VPS hosting je najbolji izbor.

Popularni pružatelji usluga: DigitalOcean, Hetzner, Linode. Poznati su po odličnim cijenama, performansama i dobroj dokumentaciji.

#### Proces zakupa (DigitalOcean)
- registrirajte se na DigitalOcean
- kreirajte novi "Droplet" (njihov naziv za VPS)
- odaberite operativni sustav - uvijek birajte LTS (Long-Term Support) verziju Ubuntua (npr. Ubuntu 22.04)
- odaberite plan - za početak, plan od $5-$10 mjesečno je više nego dovoljan
- odaberite regiju - birajte regiju koja je geografski najbliža vašim korisnicima (npr. Frankfurt ili Amsterdam za Europu)
- postavite autentikaciju - odaberite SSH ključ(puno sigurnije od lozinke)
- kliknite "Create Droplet"

Nakon nekoliko minuta, vaš server će biti kreiran i dobit ćete njegovu IP adresu. Tu IP adresu ćete kopirati i unijeti u A zapis u DNS postavkama vaše domene.

---
### Generiranje SSH ključeva (na lokalnom računalu) (kopirano iz kasnijeg dijela teksta)
```bash
ssh-keygen
# ili
ssh-keygen -t rsa -b 4096 -C "your_email@example.com"
# i prihvatite zadanu lokaciju (~/.ssh/id_rsa) i po želji dodajte lozinku
```
Ako niste dodali prilikom kreiranja Dropleta, javni ključ (`id_rsa.pub`) dodajte na server u `~/.ssh/authorized_keys` za korisnika kojim se spajate.

```bash
# dodajemo javni SSH ključ s lokalnog računala u authorized_keys na serveru (omogućuje SSH bez lozinke)
cat ~/.ssh/id_rsa.pub | ssh korisnik@IP_ADRESA_SERVERA "cat >> ~/.ssh/authorized_keys"
```
---

## Prijenos projekta
### FTP (File Transfer Protocol) - stari način
Ovo je klijent-server protokol star gotovo kao i internet, služi za prijenos datoteka. Najpoznatiji alat je FileZilla. Koristi dvije odvojene veze:
- kontrolna veza (Port 21) - služi za slanje naredbi (npr. "prijavi me", "daj mi popis datoteka", "preuzmi ovu datoteku")
- podatkovna veza (Port 20) - kroz ovu vezu se odvija stvarni prijenos sadržaja datoteka

Nedostaci FTP-a:
- spor - prijenos tisuća malih Laravel datoteka može trajati dugo
- nema povijesti - ne znate što ste zadnje promijenili
- prekid rada (downtime) - vaša stranica je "pokvarena" dok se sve datoteke ne prebace
- nesiguran - standardni FTP šalje vaše korisničko ime i lozinku u čistom tekstu, što znači da ih netko može presresti

Sigurnije alternative:
- SFTP (Secure File Transfer Protocol) - koristi SSH vezu za siguran prijenos i njega ćete najčešće koristiti ako morate raditi s FTP-om
- FTPS (FTP over SSL) - koristi SSL certifikate za enkripciju

### Git (moderni, puno bolji način)
Deployment preko Git-a je današnji industrijski standard. On prebacuje samo ono što se promijenilo i to instantno i pouzdano.

Proces prijenosa:
- lokalno - svoj kod "pushate" na online repozitorij (GitHub, GitLab)
- na serveru
    - prijavite se na server putem SSH-a (Secure Shell - sigurna naredbena linija)
    - prvi put klonirate repozitorij s git clone, a svaki sljedeći put, samo pokrenete git pull da preuzmete najnovije promjene

Prednosti:
- brzina - preuzimaju se samo izmijenjene datoteke
- pouzdanost - nema "polovičnih" prijenosa
- povijest i vraćanje (rollback) - ako nešto pođe po zlu, lako se možete vratiti na prethodnu verziju
- automatizacija - otvara vrata za CI/CD (kontinuiranu integraciju i isporuku)

## Deploy Laravel Aplikacije

Preduvjeti
- server je spreman
- Laravel projekt je na Githubu
- imate ssh pristup serveru

### Kako pripremiti server (Ubuntu)

#### 1. Instalacija Nginx
```bash
sudo apt update
sudo apt install nginx
sudo systemctl enable nginx
sudo systemctl start nginx
```

#### 2. Instalacija PHP (npr. PHP 8.4) i potrebnih ekstenzija
```bash
# instalira paket koji omogućuje upravljanje dodatnim repozitorijima (PPA)
sudo apt install software-properties-common

# dodaje popularni PPA repozitorij s najnovijim PHP verzijama i ekstenzijama
sudo add-apt-repository ppa:ondrej/php
```bash
# prvo ažuriramo popis paketa na serveru – važno je da instaliramo najnovije verzije i sigurnosne zakrpe
sudo apt update

# instaliramo PHP 8.4 i potrebne ekstenzije
# - php8.4 - glavni PHP paket (programski jezik koji pokreće Laravel)
# - php8.4-fpm - FastCGI Process Manager – omogućuje PHP-u da radi s Nginxom (umjesto Apache mod_php)
# - php8.4-mbstring - ekstenzija za rad s multibyte stringovima (potrebno za Laravel i mnoge PHP pakete)
# - php8.4-xml - omogućuje rad s XML podacima (koristi se za parsing, validaciju itd.)
# - php8.4-mysql - omogućuje PHP-u povezivanje s MySQL bazom podataka
# - php8.4-zip - omogućuje rad sa ZIP arhivama (npr. Composer koristi za instalaciju paketa)
# - php8.4-curl - omogućuje HTTP zahtjeve iz PHP-a (koristi se za API pozive, Composer itd.)
sudo apt install php8.4 php8.4-fpm php8.4-mbstring php8.4-xml php8.4-mysql php8.4-zip php8.4-curl
```

#### 3. Instalacija Composer-a

```bash
# instaliramo curl i unzip, pakete potrebne za preuzimanje i instalaciju Composer-a
sudo apt install curl unzip

# preuzimamo Composer instalacijsku skriptu i pokrećemo ju
curl -sS https://getcomposer.org/installer | php

# premještamo composer.phar u /usr/local/bin i preimenujemo ga u 'composer' radi lakšeg pozivanja iz bilo kojeg direktorija
sudo mv composer.phar /usr/local/bin/composer
```

#### 4. Instalacija Git-a
```bash
sudo apt install git
```

#### 5. Instalacija MySQL-a
```bash
sudo apt install mysql-server

################ 
# ako kod instalacije mysqla dobivate errore, izvršite ove naredbe:
# alociramo 2GB za swapfile
sudo fallocate -l 2G /swapfile
# postavljamo dozvole na swapfile
sudo chmod 600 /swapfile
# postavljamo swapfile kao swap prostor
sudo mkswap /swapfile
# omogućujemo swap prostor
sudo swapon /swapfile
################

# nastavak procesa instalacije mysqla
sudo systemctl enable mysql
sudo mysql_secure_installation

# nakon završetka sigurnosne konfiguracije, pristupite MySQL konzoli za daljnje postavljanje baze i korisnika
mysql -u root -p

# ova naredba omogućuje (enable) MySQL servis, što znači da će se MySQL automatski pokrenuti svaki put kad se sustav (server) restarta
# dodaje servis u listu servisa koji se pokreću pri bootu
sudo systemctl enable mysql

# ova naredba odmah pokreće MySQL servis (bez čekanja na restart)
sudo systemctl start mysql
```

#### 6. Generiranje SSH ključeva (na lokalnom računalu)
```bash
ssh-keygen
# ili
ssh-keygen -t rsa -b 4096 -C "your_email@example.com"
# i prihvatite zadanu lokaciju (~/.ssh/id_rsa) i po želji dodajte lozinku
```
Ako niste dodali prilikom kreiranja Dropleta, javni ključ (`id_rsa.pub`) dodajte na server u `~/.ssh/authorized_keys` za korisnika kojim se spajate.

```bash
# dodajemo javni SSH ključ s lokalnog računala u authorized_keys na serveru (omogućuje SSH bez lozinke)
cat ~/.ssh/id_rsa.pub | ssh korisnik@IP_ADRESA_SERVERA "cat >> ~/.ssh/authorized_keys"
```
---

Nakon ovih koraka, server je spreman za deployment Laravel aplikacije.

### Deployment
1. Povezivanje i kloniranje projekta
-  moramo se prvo spojiti na server i klonirati svoj projekt u var/www direktorij

- spajanje na server
`ssh root@IP_ADRESA_SERVERA`

- navigiramo u /var/www
`cd /var/www`

- kloniramo projekt
`git clone https://github.com/vase-ime/vas-repozitorij.git`

- ulazimo u projekt
`cd mojprojekt`

2. Instalacija ovisnosti
- sada kada je kod na serveru, moramo instalirati sve PHP pakete koje projekt koristi

- instalacija samo produkcijskih ovisnosti i optimizacija autoloadera
`composer install --optimize-autoloader --no-dev`

    - `--no-dev` - zastavica sprječava instalaciju paketa koji su potrebni samo za razvoj (npr. alati za testiranje), čineći aplikaciju manjom i sigurnijom

3. Konfiguracija okruženja (.env)
- aplikacija na serveru treba znati kako se spojiti na bazu i druge važne postavke

- kopiranje `.env.example` datoteke kao osnove za novu konfiguraciju
`cp .env.example .env`

- otvaranje `.env` datoteke u nano editoru
`nano .env`

- u editoru mijenjamo sljedeće:

    - `APP_ENV=production` (jako važno za sigurnost i performanse)
    - `APP_DEBUG=false` (nikada ne ostavljajte debug upaljen u produkciji)
    - `APP_URL=http://vasa-domena.com`
    - `DB_DATABASE, DB_USERNAME, DB_PASSWORD` (unesite podatke za bazu koju ste kreirali na serveru)

- pritisnite `CTRL+O`, zatim `Y` i `Enter` te `CTRL+X` da spremite i izađete iz nano editora

4. Generiranje ključa aplikacije
- svaka Laravel aplikacija treba jedinstveni ključ za enkripciju

`php artisan key:generate`

5. Pokretanje migracija
- sada kada aplikacija zna kako se spojiti na bazu, možemo kreirati tablice

`php artisan migrate --force`
    - `--force` je potreban jer smo u produkcijskom okruženju

6. Povezivanje pohrane (Storage Link)
- ovo čini public/storage folder dostupnim javno

`php artisan storage:link`

7. Optimizacija
- keširamo konfiguraciju i rute za maksimalnu brzinu

`php artisan config:cache`

`php artisan route:cache`

8. Podešavanje dozvola
- web server (Nginx ili Apache) mora imati dozvolu za pisanje u određene foldere

- postavljanje 'www-data' (standardni web server korisnik) kao vlasnika foldera

`sudo chown -R www-data:www-data storage bootstrap/cache`

`sudo chown -R www-data:www-data database`

- postavljanje ispravne dozvole za te foldere

`sudo chmod -R 775 storage bootstrap/cache`

`sudo chmod -R 775 database`

9. Konfiguracija Web Servera
- moramo reći web serveru gdje se nalazi naša aplikacija i kako da je servira

- otvaranje konfiguracijske datoteke za Nginx

`sudo nano /etc/nginx/sites-available/default`


```bash
server {
    listen 80;
    server_name vasa-domena.com ili IP adresa servera; # preporučuje se koristiti naziv domene radi ispravnog rutanja i SSL podrške
    root /var/www/ime-projekta/public; # putanja do PUBLIC foldera!

    # ova direktiva štiti vašu aplikaciju od "clickjacking" napada tako što zabranjuje učitavanje stranice unutar iframe-a na drugim domenama
    add_header X-Frame-Options "SAMEORIGIN";
    # sprečava preglednik da pogađa MIME tipove, čime se povećava sigurnost protiv napada putem pogrešnog tipa datoteke
    add_header X-Content-Type-Options "nosniff";

    # ova direktiva je nužna za Laravel jer bez nje, zahtjevi na root URL (npr. /) neće biti ispravno proslijeđeni na Laravelovu ulaznu točku tj. front controller (index.php)
    index index.php;

    # ova direktiva osigurava ispravno prikazivanje Unicode znakova na web stranici (npr. hrvatska slova, emoji)
    charset utf-8;

    location / {
        # ključni redak za Laravel jer omogućuje "pretty URLs" (bez .php ekstenzije) i prosljeđuje sve zahtjeve na index.php, što je nužno za Laravel routing i ispravan rad aplikacije
        try_files $uri $uri/ /index.php?$query_string;
    }

    # ove direktive isključuju pristupne i error logove za favicon.ico i robots.txt
    # razlog - ove datoteke se često traže od strane preglednika i botova, pa bi nepotrebno punile logove
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    # direktiva ispod preusmjerava sve 404 greške na index.php
    # ovo je korisno za Laravel SPA aplikacije gdje frontend router treba obraditi nepostojeće URL-ove
    # PAŽNJA: preusmjeravanje svih 404 grešaka može prikriti stvarne greške, otežati debugiranje i negativno utjecati na SEO (tražilice neće vidjeti pravu 404 stranicu)
    error_page 404 /index.php;

    # Laravel PHP konfiguracija za Nginx
    # ova sekcija omogućuje ispravno prosljeđivanje PHP zahtjeva FastCGI procesu
    # FastCGI je protokol koji omogućuje (brzu) komunikaciju između web servera i aplikacija, poput PHP-a, radi učinkovitijeg procesiranja zahtjeva
    location ~ \.php$ {
      fastcgi_pass unix:/var/run/php/php8.4-fpm.sock; 
      # provjerite verziju PHP-a (npr. provjerite s php -v) i putanju do socketa (npr. ls /var/run/php/) jer može biti php7.4-fpm.sock, php8.1-fpm.sock itd.

      # $realpath_root$fastcgi_script_name automatski generira punu putanju do PHP skripte na temelju root direktive i traženog URL-a -> bolje od hardkodirane putanje jer omogućuje fleksibilnost ako promijenite root direktorij ili strukturu projekta
      fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;

      # uključuje sve potrebne FastCGI parametre za ispravan rad PHP-a
      include fastcgi_params;
    }


    # ovaj dio koda je Nginx konfiguracija koja blokira pristup svim skrivenim (dot) fajlovima, osim onima u direktoriju .well-known
    # to je sigurnosna mjera koja sprečava korisnike da pristupe fajlovima kao što su .git, .env itd.
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

- spremite datoteku i restartajte Nginx da primijeni promjene

`sudo systemctl restart nginx`

<!--  Apache2
- ako vaš server koristi Apache, proces je vrlo sličan. Potrebno je urediti "Virtual Host" datoteku

# zadana konfiguracijska datoteka za Apache
sudo nano /etc/apache2/sites-available/000-default.conf

- ključno je postaviti DocumentRoot na public folder vašeg projekta i omogućiti AllowOverride All kako bi Laravelov .htaccess radio

<VirtualHost *:80>
    ServerName vasa-domena.com
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/mojprojekt/public

    <Directory /var/www/mojprojekt/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

- nakon spremanja datoteke, moramo omogućiti Apache rewrite modul (ako već nije) i restartati server

- omogućavanje rewrite modula
sudo a2enmod rewrite

- restart Apachea
sudo systemctl restart apache2 -->

10. Finalna provjera

Otvorite vašu domenu (ili IP adresu servera) u pregledniku. Ako vidite početnu stranicu vašeg Laravel projekta, čestitamo! Uspješno ste postavili svoju prvu aplikaciju u produkciju.


## Migracija MySQL Baze (Teorija)
Naša lokalna aplikacija koristi lokalnu bazu, ali produkcijska aplikacija treba svoju, odvojenu produkcijsku bazu na serveru. Proces prebacivanja strukture i podataka iz jedne baze u drugu zovemo ***migracija*** baze podataka.

### Zašto migriramo bazu?
- odvajanje okruženja 
    - nikada ne želite da vaša produkcijska aplikacija koristi istu bazu kao i razvojna
    - testni podaci, greške i eksperimenti iz razvoja ne smiju završiti na stranici koju vide stvarni korisnici
- početno postavljanje
    - kada prvi put postavljate aplikaciju, morate prebaciti strukturu tablica i eventualne početne, esencijalne podatke (npr. listu država, početne kategorije, admin korisnika)
- sinkronizacija
    - ponekad je potrebno prebaciti i postojeće podatke s lokalnog računala ili starog servera na novi

### Metode migracije
Postoji više načina za migraciju, ali najčešći i najpouzdaniji za MySQL je korištenje alata mysqldump.

- `mysqldump` - ovo je naredba koja "uslika" stanje vaše baze (njezinu strukturu i sve podatke) i spremi sve u jednu .sql tekstualnu datoteku; ta datoteka sadrži sve SQL naredbe potrebne da se na drugom serveru stvori identična kopija originalne baze

### Migracija Baze
1. Eksportiranje lokalne baze (mysqldump)
- zamijenimo 'korisnik', 'lozinka' i 'ime_baze' s vašim podacima

`mysqldump -u vas-korisnik -p ime_baze > lokalna_baza.sql`

- u idućem koraku upišite lozinku usera
- datoteka `lokalna_baza.sql` bit će smještena u direktoriju iz kojeg ste pokrenuli ovu naredbu u terminalu (najčešće vaš trenutni radni direktorij)

2. Prijenos .sql datoteke na server
- sada trebamo tu datoteku prebaciti na server
- najjednostavniji način je korištenjem scp (Secure Copy) naredbe, koja radi preko SSH-a

- na lokalnom računalu pokrećemo:

`scp /putanja/do/lokalna_baza.sql root@IP_ADRESA_SERVERA:~/`

- ovo će kopirati datoteku u "home" direktorij na vašem serveru

3. Kreiranje baze i korisnika na serveru
- spojite se na server putem SSH-a i uđite u MySQL

`ssh root@IP_ADRESA_SERVERA`

`mysql -u root -p`

- sada, unutar MySQL-a, kreiramo novu bazu

`CREATE DATABASE produkcijska_baza;`

- kreiramo novog korisnika i postavljamo mu lozinku
`CREATE USER 'produkcijski_korisnik'@'localhost' IDENTIFIED BY 'jaka-lozinka-123';`

- dajemo novom korisniku sve ovlasti nad novom bazom
`GRANT ALL PRIVILEGES ON produkcijska_baza.* TO 'produkcijski_korisnik'@'localhost';`

- osvježavamo MySQL ovlasti
`FLUSH PRIVILEGES;`

- izlazimo iz MySQL-a
`EXIT;`

4. Importanje podataka u novu bazu
- sada kada imamo praznu bazu, vrijeme je da u nju ubacimo podatke iz naše `.sql` datoteke.

- još uvijek smo na serveru, ali izvan MySQL-a

`mysql -u produkcijski_korisnik -p produkcijska_baza < lokalna_baza.sql`

- unosimo lozinku za produkcijskog_korisnika
- nakon nekoliko trenutaka, svi podaci će biti importani

5. Ažuriranje .env datoteke

- navigiranje do foldera projekta
`cd /var/www/vas-projekt`

- otvaramo .env datoteku
`nano .env`

- unosimo podatke koje smo upravo kreirali
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=produkcijska_baza
DB_USERNAME=produkcijski_korisnik
DB_PASSWORD=jaka-lozinka-123
```
- spremimo datoteku

- vaša aplikacija je sada spojena na bazu i trebala bi biti potpuno funkcionalna!

