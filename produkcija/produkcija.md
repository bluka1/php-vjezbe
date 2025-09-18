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


## Kontinuirana Integracija (Continuous Integration - CI)
Do sada smo ručno deployali aplikaciju i to je u redu za početak, ali u stvarnom svijetu, taj proces želimo automatizirati. Tu na scenu stupa Kontinuirana Integracija (CI).

### Što je kontinuirana integracija?
CI je praksa u razvoju softvera gdje programeri redovito (često i više puta dnevno) spajaju (integriraju) svoje promjene koda u centralni repozitorij. Nakon svakog spajanja, automatski se pokreće proces buildanja i testiranja.

#### Zašto je CI važan? Koje probleme rješava?
Bez CI-a, timovi često rade danima/tjednima na svojim granama (branchevima) i sve to spajaju na kraju. To dovodi do tzv. "pakla integracije" (integration hell), gdje se rješavaju stotine konflikata, a bugove je teško pronaći.

Prednosti CI-a:
- rano otkrivanje grešaka - ako vaša promjena "pokvari" testove, saznat ćete to unutar nekoliko minuta, a ne tjednima kasnije
- manje konflikata - čestim spajanjem malih promjena, konflikti su rjeđi i lakši za riješiti
- automatizirani testovi - CI osigurava da se testovi uvijek pokreću, što povećava kvalitetu koda
- uvijek spremna verzija - u svakom trenutku, master grana repozitorija je testirana i spremna za isporuku
- brža isporuka - automatizacija smanjuje ručni rad i ubrzava cijeli proces od pisanja koda do produkcije

Mane (izazovi):
- početno ulaganje resursa - potrebno je vrijeme za postavljanje i konfiguraciju CI pipelinea
- kultura tima - zahtijeva disciplinu tima da pišu testove i redovito commitaju kod

## Alati za Kontinuiranu Integraciju
CI proces izvršava specijalizirani softver – CI server. Postoje mnogi alati, a dijele se u dvije glavne kategorije:
- samostalno hostani (Self-hosted) - vi ste odgovorni za instalaciju, održavanje i skaliranje softvera na vlastitim serverima
- cloud-based (SaaS) - usluge koje rade "u oblaku"; vi samo povežete svoj repozitorij i konfigurirate proces, a oni se brinu za servere i infrastrukturu
    - Jenkins - tata svih CI alata
        - open-source, nevjerojatno moćan i fleksibilan s tisućama pluginova
        - mana mu je što može biti kompleksan za početno postavljanje i održavanje
    - Travis CI - jedan od prvih popularnih cloud alata, poznat po jednostavnosti i odličnoj integraciji s GitHubom, pogotovo za open-source projekte
    - GitHub Actions - mdoerno, moćno i izuzetno popularno rješenje integrirano direktno u GitHub
        - omogućuje da sve automatiziramo, od CI-a do kompletnog deploymenta, direktno iz našeg repozitorija
        - zbog svoje jednostavnosti i integracije, ovo je danas često najbolji izbor za početak

## Postavljanje CI Pipelinea
1. Kreiranje Workflow datoteke
- unutar vašeg Laravel projekta (u rootu), kreirajte novi direktorij i datoteku na sljedećoj putanji:

`.github/workflows/laravel.yml`

Važno je da se folder zove točno .github, a unutar njega postoji workflows.

2. Definiranje osnovne strukture
- otvorite `laravel.yml` i zalijepite osnovnu strukturu - ovo definira kada će se akcija pokrenuti
```yml
name: Laravel CI

# okidač - ova akcija će se pokrenuti na svaki 'push' na 'main' granu i na svaki 'pull request' koji cilja 'main' granu
on:
  push:
    branches: [ "main" ]
  pull_request:
    branches: [ "main" ]

# dozvole za GITHUB_TOKEN za deployment (ako će trebati kasnije)
permissions:
  contents: read

jobs:
  # ovdje ćemo definirati zadatke koje treba obaviti na svaki push i na svaki PR
```
3. Definiranje "laravel-tests" posla
- sada moramo definirati što točno naš CI treba raditi
```yml
jobs:
  laravel-tests:
    # definiramo na kojem operativnom sustavu će se posao izvršavati
    runs-on: ubuntu-latest

    # koraci (steps) koje treba izvršiti redom
    steps:
      # preuzimanje koda - koristi gotovu akciju 'actions/checkout' da preuzme kod iz repozitorija
      - name: Checkout code
        uses: actions/checkout@v4

      # postavljanje PHP okruženja - koristimo gotovu akciju za postavljanje specifične verzije PHP-a
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.4' # možete odabrati verziju koja vam treba
          extensions: mbstring, dom, fileinfo, mysql
          coverage: none

      # kopiranje .env datoteke - na CI serveru nemamo .env, pa kopiramo .env.example
      - name: Copy .env file
        run: php -r "file_exists('.env') || copy('.env.example', '.env');"

      # Instalacija Composer ovisnosti - koristimo --no-progress i --prefer-dist za bržu instalaciju na CI
      - name: Install Dependencies
        run: composer install -q --no-progress --prefer-dist --optimize-autoloader

      # generiranje ključa aplikacije
      - name: Generate key
        run: php artisan key:generate

      # kreiranje baze podataka za testiranje - kreiramo SQLite bazu u memoriji, što je najbrže za testove
      - name: Create Database
        run: |
          mkdir -p database
          touch database/database.sqlite
    
      # pokretanje migracija - postavljamo .env varijable za testiranje unutar samog koraka
      - name: Run Migrations
        env:
          DB_CONNECTION: sqlite
          DB_DATABASE: database/database.sqlite
        run: php artisan migrate

      # pokretanje testova
      - name: Execute tests (PHPUnit)
        env:
          DB_CONNECTION: sqlite
          DB_DATABASE: database/database.sqlite
        run: php artisan test
```

4. Commit i Push
- spremamo `laravel.yml` datoteku te ju commitamo i pushamo promjene na GitHub repozitorij
```bash
git add .github/workflows/laravel.yml
# ili
git add .
git commit -m "Add Laravel CI workflow"
git push origin main
```
5. Praćenje akcije na GitHubu
- otvorite vaš repozitorij na GitHubu
- kliknite na tab "Actions"
- vidjet ćete vaš novi "Laravel CI" workflow kako se pokreće
- kliknite na njega da vidite detalje izvršavanja svakog koraka

Ako svi koraci prođu i na kraju vidite zelenu kvačicu, čestitamo! Uspješno ste postavili svoj prvi CI pipeline. Ako negdje zapne, GitHub Actions će vam ispisati točnu grešku kako biste je mogli ispraviti.

Ovo je temelj na koji se kasnije nadograđuje Kontinuirana Isporuka (Continuous Deployment - CD), gdje biste nakon uspješnih testova dodali korak koji automatski deploya aplikaciju na server.

## Kontinuirana isporuka (Continuous Delivery - CD)
Postavili smo kontinuiranu integraciju i to je odlično no što ako bismo, nakon što integracija bude uspješna, mogli automatski i isporučiti taj kod na server?

To je ideja iza kontinuirane isporuke (Continuous Delivery) i kontinuiranog deployanja (Continuous Deployment).

### Koja je razlika? CI vs CD
- kontinuirana integracija (CI) je faza testiranja; automatizirano provjeravamo je li kod ispravan -> rezultat - imamo verziju koda koja je provjereno ispravna i spremna za isporuku

- kontinuirana isporuka (Continuous Delivery) - faza isporuke; nakon što CI prođe, automatski se pokreće proces koji priprema i isporučuje kod u produkcijsko okruženje, ali zahtijeva ručno odobrenje (jedan klik) za konačno puštanje u rad -> rezultat - aplikacija je na produkcijskom serveru, spremna da postane aktivna kada mi to odlučimo

- kontinuirano deployanje (Continuous Deployment) - najviša razina automatizacije; nakon što CI prođe, kod se potpuno automatski, bez ikakve ljudske intervencije, pušta u rad na produkciji

Za većinu timova, Continuous Delivery je zlatni standard jer pruža savršeni balans između automatizacije i kontrole.

Prednosti CD-a
- brža isporuka vrijednosti - nove funkcionalnosti i ispravci bugova dolaze do korisnika puno brže
- manji rizik - deployanje malih, čestih promjena je puno manje rizično od jednog velikog deploya svakih par mjeseci; ako nešto pođe po zlu, točno znate koja mala promjena je uzrokovala problem
- povećana produktivnost programera - programeri se mogu fokusirati na pisanje koda, a ne na kompleksne i stresne procedure ručnog deployanja

### Alati za Kontinuiranu Isporuku
Kao i kod CI-a, za CD se koriste isti alati, samo se pipeline proširuje s dodatnim koracima za deployment.

Jenkins, Travis CI, itd.: Svi ovi alati podržavaju CD, često kroz plugine ili skripte.

Buddy.works: Alat koji je posebno fokusiran na jednostavnost kreiranja CD pipelinea s vizualnim sučeljem.

GitHub Actions: Budući da smo ga već koristili za CI, prirodno je da ga proširimo i za CD. Njegova najveća prednost je potpuna integracija s kodom i korištenje istih YAML datoteka za definiranje cijelog procesa.

Da bismo automatizirali deployment, naš CI/CD alat mora imati siguran način da pristupi produkcijskom serveru. To se nikada ne radi spremanjem lozinki u kod. Umjesto toga, koriste se Secrets (tajne).

U GitHub Actions, "Secrets" su enkriptirane varijable koje možete definirati na razini repozitorija i onda ih sigurno koristiti unutar vašeg workflowa. U njih ćemo spremiti SSH ključ i podatke za spajanje na naš server.

### Postavljanje CD Pipelinea
Nadogradit ćemo naš postojeći CI pipeline. Dodat ćemo novi "posao" (job) koji će se pokrenuti samo ako testovi prođu, i automatski će deployati našu aplikaciju na server.

1. Generiranje i spremanje SSH ključa

Da bi se GitHub mogao spojiti na vaš server, treba mu SSH ključ koji nema lozinku.
Na vašem lokalnom računalu, kreirajte novi par ključeva samo za ovu svrhu:

`ssh-keygen -t rsa -b 4096 -f github-actions-key -N ""`

- `-t rsa` definira RSA algoritam (najčešći za SSH)
- `-b 4096` definira broj bitova tj. duljinu ključa - 4096 je prilično sigurno i preporučljivo
- `-f` definira ime datoteke
- `-N ""` postavlja praznu lozinku

- ovo će stvoriti dvije datoteke - `github-actions-key` (privatni ključ) i `github-actions-key.pub` (javni ključ)

2. Dodavanje javnog ključa na server
- sada moramo reći serveru da "vjeruje" ovom novom ključu

- iz foldera u kojem smo generirali ssh ključ kopiramo sadržaj javnog ključa u `~/.ssh/authorized_keys` na serveru

`scp -i /putanja/do/ssh-kljuca-za-prod-server github-actions-key.pub root@IP_ADRESA_SERVERA:~/.ssh/authorized_keys`

3. Spremanje tajni (Secrets) u GitHub
- na vašem GitHub repozitoriju, idite na `Settings > Secrets and variables > Actions`

- kliknite `New repository secret` i dodajte sljedeće tri tajne:

```bash
# otvorite datoteku github-actions-key (privatni ključ) na vašem računalu, kopirajte cijeli sadržaj (uključujući -----BEGIN... i -----END...) i zalijepite ga ovdje pod SSH_PRIVATE_KEY
SSH_PRIVATE_KEY: 

SSH_HOST: IP adresa vašeg servera

SSH_USER: korisničko ime za spajanje na server (vjerojatno root)
```

4. Proširenje laravel.yml workflowa
- otvoramo `.github/workflows/laravel.yml` datoteku i dodajemo novi deploy posao nakon laravel-tests posla

- ... (cijeli 'laravel-tests' posao ostaje isti kao prije) ...
```yml
  deploy:
    # ovaj posao ovisi o uspješnom završetku testova
    needs: laravel-tests
    runs-on: ubuntu-latest

    steps:
      - name: Deploy to server
        # koristimo gotovu, popularnu akciju za SSH
        uses: appleboy/ssh-action@master
        with:
          host: ${{ secrets.SSH_HOST }}
          username: ${{ secrets.SSH_USER }}
          key: ${{ secrets.SSH_PRIVATE_KEY }}
          script: |
            cd /var/www/mojprojekt
            git pull origin main
            composer install --no-dev --optimize-autoloader
            php artisan migrate --force
            php artisan config:cache
            php artisan route:cache
            php artisan view:cache
```
Objašnjenje:

- `needs: laravel-tests` - govori GitHubu da ovaj posao pokrene samo ako je laravel-tests posao uspješno završio
- `uses: appleboy/ssh-action@master` - koristimo gotovu akciju koja pojednostavljuje spajanje na server
- `with` - ovdje prosljeđujemo naše tajne (secrets) akciji
- `script` - popis naredbi koje će se izvršiti na našem produkcijskom serveru jedna za drugom

5. Testiranje cijelog pipelinea
- napravimo neku malu, vidljivu promjenu u vašoj aplikaciji (npr. promijenite tekst na početnoj stranici)
- commitamo i pushamo promjenu na main granu
```bash
git add .
git commit -m "Test CD pipeline"
git push origin main
```

Otvorimo Actions tab na GitHubu i vidjet ćemo kako se prvo pokreću testovi. Ako testovi prođu, automatski će se pokrenuti deploy posao. Nakon što i on završi, otvorite vašu web stranicu u pregledniku. Trebali biste vidjeti promjenu koju ste napravili, bez da ste se ijednom ručno spajali na server!

## Završno Testiranje i Isporuka (Teorija)
Automatizacija je moćna, ali prije nego što isporučimo veliku novu funkcionalnost korisnicima, često postoji i faza završnog, ručnog testiranja. Cilj je provjeriti aplikaciju u cjelini i dobiti povratne informacije od stvarnih ljudi.

### Faze testiranja
1. Alpha testiranje
Provodi se unutar tvrtke. Vaši kolege, dizajneri, project manageri testiraju aplikaciju i traže greške ili nelogičnosti u korisničkom iskustvu. Ovo je "internal release".

2. Beta testiranje
Aplikacija se daje na korištenje ograničenoj, vanjskoj publici. To mogu biti vaši najvjerniji korisnici ili grupa ljudi koja se prijavila za testiranje. Cilj je vidjeti kako se aplikacija ponaša u stvarnim uvjetima, na različitim uređajima i mrežama, te prikupiti vrijedne povratne informacije prije službenog izlaska.

### Životni ciklus izdanja softvera (Software Release Life Cycle)
Softver prolazi kroz nekoliko faza prije nego što postane stabilan:
1. Pre-alpha - faza razvoja, prototipovi
2. Alpha - prva verzija spremna za interno testiranje; očekuju se bugovi
3. Beta - verzija s uglavnom svim funkcionalnostima, spremna za vanjsko testiranje; još uvijek može imati manje bugove
4. Release Candidate (RC) - verzija za koju se vjeruje da je spremna za produkciju; ako se u njoj ne pronađu kritični bugovi, postaje finalna verzija
5. Stable (Stabilna verzija) - službena, produkcijska verzija koja se isporučuje svim korisnicima

Ovaj strukturirani pristup osigurava da do krajnjih korisnika dođe kvalitetan i pouzdan proizvod.

## Završno testiranje – Alpha i Beta
Naša CI/CD automatizacija je fantastična za hvatanje tehničkih grešaka, ali ne može nam reći je li aplikacija ugodna za korištenje, intuitivna ili kako se ponaša na stotinama različitih uređaja u stvarnom svijetu. Zato, prije velikog izdavanja aplikacije, provodimo dvije važne faze ručnog testiranja: Alpha i Beta.

### Alpha Testiranje
Ovo je prva faza formalnog testiranja i provodi se isključivo unutar tvrtke. 

Tko testira? Zaposlenici – developeri, QA inženjeri, dizajneri, project manageri.

Gdje se testira? U kontroliranom, laboratorijskom okruženju, najčešće na posebnom "staging" serveru koji je kopija produkcije.

Cilj: pronaći i ispraviti što više bugova (od kritičnih do vizualnih), provjeriti rade li sve funkcionalnosti kako je zamišljeno i prikupiti interni feedback o korisničkom iskustvu.

Analogija: zamislite da restoran priprema novi meni. Alpha testiranje je kada kuhari pripreme sva jela, a onda ih kušaju samo vlasnik, glavni konobari i ostali kuhari. Oni daju kritike, ispravljaju recepte i odlučuju o prezentaciji prije nego što ijedan gost proba hranu.

### Beta Testiranje
Nakon što je proizvod prošao internu provjeru, spreman je za vanjski svijet, ali u ograničenom obliku.

Tko testira? Stvarni korisnici – odabrana grupa ljudi izvan tvrtke koja je pristala isprobati proizvod prije svih.

Gdje se testira? U stvarnom, produkcijskom okruženju.

Cilj: dobiti povratne informacije od stvarne publike. Kako se aplikacija ponaša na njihovim uređajima, brzinama interneta? Je li im logična za korištenje? Pronalaze li bugove koje interni tim nije primijetio?

Analogija: Restoran je sada siguran u svoj novi meni. Beta testiranje je "ekskluzivna večer za prijatelje restorana". Pozovu odabranu grupu stalnih gostiju da besplatno isprobaju novi meni i daju iskrene komentare. Na temelju njihovih reakcija, restoran radi zadnje finese prije službenog otvaranja.

| Kriterij      | Alpha Testiranje                         | Beta Testiranje                                    |
|---------------|------------------------------------------|----------------------------------------------------|
| Tko?          | Interni tim (zaposlenici)                | Eksterni tim (stvarni korisnici)                   |
| Gdje?         | Staging/Test okruženje                   | Produkcijsko okruženje                             |
| Fokus         | Funkcionalnost, pronalaženje svih bugova | Upotrebljivost, performanse, feedback od korisnika |
| Pouzdanost    | Proizvod može biti nestabilan            | Proizvod je uglavnom stabilan                      |

## Životni Ciklus Izdanja Softvera
Rijetko kada softver ide direktno iz faze "pišem kod" u fazu "dostupno svima". On prolazi kroz jasno definiran životni ciklus, slično kao što proizvod prolazi kroz faze od prototipa do masovne proizvodnje.

Faze životnog ciklusa
- pre-alpha - najranija faza
    - uključuje sve aktivnosti prije formalnog testiranja – analiza zahtjeva, dizajn, razvoj, izrada prototipova
- alpha - prva verzija softvera koja se može testirati
    - često je puna bugova, nestabilna i nedostaju joj neke planirane funkcionalnosti
    - ovo je verzija koja se daje Alpha testerima (internom timu)
- beta - verzija koja je "feature-complete"
    – sve glavne funkcionalnosti su razvijene
    - sada je fokus na ispravljanju bugova, optimizaciji performansi i prikupljanju povratnih informacija od vanjskih, Beta testera
- zatvorena Beta (Closed Beta) - dostupna samo ograničenom broju pozvanih korisnika
- otvorena Beta (Open Beta) - svatko se može prijaviti i sudjelovati u testiranju
- Release Candidate (RC) - kandidat za izdanje - verzija za koju se vjeruje da je potpuno stabilna i spremna za produkciju
    - više se ne dodaju nove funkcionalnosti, samo se ispravljaju kritični bugovi ako se pronađu
    - ako RC verzija prođe finalne provjere bez problema, ona postaje finalna verzija
- Stable (stabilna verzija) / General Availability (GA) - službena, finalna, produkcijska verzija koja se isporučuje svim korisnicima
    - prošla je sve faze testiranja i smatra se pouzdanom

Ovaj strukturirani pristup osigurava da do krajnjih korisnika stigne kvalitetan, testiran i pouzdan proizvod, smanjujući rizik od velikih problema nakon izdavanja aplikacije.