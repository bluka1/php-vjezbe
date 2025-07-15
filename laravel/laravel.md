# Laravel

## Uvod u svijet radnih okvira (frameworka)
Danas se pomoću frameworka grade moderne, robusne i profesionalne web aplikacije.
Laravel omogućuje da pišemo organiziran i lako proširiv kôd, onakav kakav pokreće kompleksne aplikacije u stvarnom svijetu.

Medutim, što je framework? Razmislite o gradnji kuće. Nitko ne počinje tako da sam peče cigle i kuje čavle. Koristimo gotove materijale, alate i ono najvažnije - nacrt. Framework je upravo to: set alata, gotovih komponenti i pravila (nacrt) za izradu softvera.

Zašto bismo koristili framework kad možemo sve pisati sami u čistom PHP-u? Čisti PHP i proceduralni pristup je odličan za jednostavne skripte. Ali kada aplikacija raste, kod može postati nepregledan, nesiguran i težak za održavanje. Framework rješava te probleme. A izmedu ostalog, ne trebamo izmišljati toplu vodu kad već postoji.

## Radno okruženje za Laravel
Da bi naša aplikacija radila, potreban joj je "dom". To zovemo radno okruženje. U svijetu PHP-a, to je najčešće tzv. LAMP ili LEMP :
- Linux - operativni sustav na serveru
- Apache / Engine-X (Nginx) - web server, program koji prima zahtjeve s interneta i poslužuje našu aplikaciju
- MySQL/MariaDB - sustav za upravljanje bazama podataka
- PHP - programski jezik u kojem pišemo aplikaciju

## Prednosti Laravela u odnosu na druge frameworke
Dok postoje i drugi sjajni PHP frameworci, Laravel se ističe u nekoliko ključnih područja:
- Developer Experience (DX) i elegancija - Laravel je poznat po tome što je "framework za programere koji vole lijepe stvari" - sintaksa je čista, intuitivna i omogućuje vam da s manje koda postignete više. U usporedbi sa Symfonyjem, koji je izuzetno moćan ali i kompleksniji i zahtijeva više konfiguracije, Laravel nudi brži start i ugodniji rad na svakodnevnim zadacima.
- "baterije uključene" - Laravel dolazi s ogromnim brojem ugrađenih funkcionalnosti koje su odmah spremne za korištenje – autentikacija, rad s bazom (Eloquent ORM), redovi čekanja, slanje e-mailova... Dok okviri poput CodeIgnitera nude veću brzinu zbog svoje jednostavnosti, često im nedostaju napredne mogućnosti koje Laravel nudi "out-of-the-box"
- ekosustav - Oko Laravela je izgrađen nevjerojatan ekosustav službenih alata koji olakšavaju cijeli životni ciklus aplikacije, od razvoja do produkcije - alati poput Forge (za upravljanje serverima), Vapor (za serverless deployment) i Nova (za administrativne panele) su nešto što drugi okviri nemaju na toj razini integracije

## Instalacija i struktura projekta
Srce svake Laravel aplikacije je njena struktura i način na koji obrađuje zahtjeve.
Analogija: zamislite da je zahtjev korisnika (klik na link) pismo koje putuje poštom.

1. Poštanski ured (`public/index.php`) - svako pismo (zahtjev) prvo stiže ovdje. Ovo je jedina javno dostupna točka aplikacije.

2. Priprema aplikacije (Bootstrap/Kernel) - zahtjev pokreće "bootstrapping" proces, gdje se učitavaju svi dijelovi aplikacije. Konceptualno, ovo je uloga kernela koji priprema sve za daljnju obradu.

3. Adresar (Router) - pripremljena aplikacija prosljeđuje zahtjev routeru, koji gleda adresu (URL) i zna točno kojem "poštaru" (kontroleru) treba uručiti pismo.

Pokretanje Laravel projekta:
- `composer create-project laravel/laravel ime-projekta` - composer preuzima sve potrebne klase i ovisnosti i slaže ih u predefiniranu strukturu direktorija

Pokretanje servera:
- `php artisan serve`

Struktura direktorija:
- `app/` - središte aplikacije - modeli, kontroleri...
    - `Http/Controllers` - kontroleri koji obrađuju zahtjeve
    - `Models` - klase koje komuniciraju s našom bazom podataka
    - `Providers` - ovdje registriramo razne servise unutar aplikacije
- `bootstrap/` - datoteke za "podizanje" (bootstrapping) aplikacije
- `config/` - sve konfiguracijske datoteke aplikacije
    - `app.php` - glavna konfiguracija - ime aplikacije, vremenska zona, lokalizacija...
    - `database.php` - sve konekcije prema bazama podataka (MySQL, PostgreSQL, SQLite...)
    - `filesystems.php` - konfiguracija za rad s datotekama - ovdje definirate "diskove", npr. lokalni disk (local) ili vanjski servis poput Amazon S3
    - `services.php` - mjesto za pohranu podataka za spajanje na vanjske servise (npr. API ključevi za Slack, Notion itd.)
    - *** Važno *** - vrijednosti iz ovih datoteka se najčešće dohvaćaju iz .env datoteke pomoću env() funkcije, kako bi osjetljivi podaci ostali odvojeni od koda
- `database/` - sve vezano za bazu podataka što nije model.
    - `migrations` - "kontrola verzija" za bazu - svaka datoteka opisuje jednu promjenu na bazi (kreiranje tablice, dodavanje stupca...)
    - `seeders` - klase za popunjavanje baze početnim ili testnim podacima
- `public/` - jedini direktorij dostupan javnosti - sadrži `index.php` (ulaznu točku) i assete (CSS, JS, slike, ikone...)
- `resources/` - fileovi koji se koriste u aplikaciji
    - `views` - HTML predlošci (blade datoteke)
    - `css, js` - CSS i JavaScript kod
- `routes/` - "adresar" aplikacije
    - `web.php` - rute za web sučelje - one imaju pristup sesiji i CSRF zaštiti
    - `console.php` - prostor za definiciju vlastitih artisan naredbi
- `storage/` - "skladište" za generirane datoteke
    - `app/public` - ovdje se spremaju datoteke koje generiraju korisnici (npr. avatari) i koje trebaju biti javno dostupne
    - `framework` - Laravel ovdje sprema svoje interne datoteke (cache, sesije...)
    - `logs` - ovdje se nalazi laravel.log datoteka gdje se zapisuju sve greške
- `tests/` - testovi aplikacije
- `vendor/` - svi vanjski paketi i biblioteke o kojima aplikacija ovisi, uključujući i sam Laravel framework (taj direktorij ne diramo)
- `.env`: "sef" za osjetljive podatke poput lozinke za bazu - ovu datoteku nikada ne dijelimo

## Arhitektura - detaljan životni ciklus zahtjeva (Requesta)

-> Ulazna točka svih zahtjeva
Svaki, ali baš svaki HTTP zahtjev koji dođe u vašu Laravel aplikaciju, bilo da je to posjet početnoj stranici ili slanje forme, prvo prolazi kroz jednu jedinu datoteku - `public/index.php`.

Ona je vrlo kratka i radi tri ključne stvari, koje predstavljaju početak životnog ciklusa.
-> Composer Autoloader
Prva stvar koju `index.php` radi jest da učitava autoload datoteku - `require __DIR__.'/../vendor/autoload.php';`.

Ovo je "magija" Composera. Autoloader je mehanizam koji automatski učitava PHP klase kada su potrebne, bez da mi igdje moramo pisati require ili include za svaku klasu. Kada u kodu napišemo `new UserController()`, autoloader zna gdje se ta klasa nalazi i učita je za nas. To čini kod izuzetno čistim.

-> Detaljan životni ciklus zahtjeva
Nakon što se autoloader učita, proces se nastavlja. Pratimo putovanje jednog zahtjeva, korak po korak:
1. Web server -> ulazna točka - korisnik u pregledniku upiše http://vasa-aplikacija.com/
2. Web server (Apache ili Nginx) prima taj zahtjev i, zahvaljujući konfiguraciji, preusmjerava ga na `public/index.php`
3. učitavanje autoloadera - `index.php` prvo učitava `vendor/autoload.php`
4. kreiranje instance aplikacije - zatim, `index.php` kreira instancu Laravel aplikacije
5. to je zapravo instanca servisnog spremnika (Service Container) - o tome nešto kasnije
6. obrada zahtjeva kroz aplikaciju (bootstrapping) - aplikacija zatim "podiže" (bootstraps) sve temeljne servise (u modernim verzijama Laravela - 11+, ključni dio ovog procesa, uključujući i konfiguraciju middlewarea, definiran je u datoteci `bootstrap/app.php`. Iako više nema datoteke Kernel.php, koncept "kernela" kao srca obrade zahtjeva i dalje postoji unutar samog frameworka)
7. učitavanje Servisnih Providera (bootstrapping) - aplikacija učitava sve Servisne Providere - oni "podižu" i konfiguriraju sve dijelove frameworka (bazu, rute, validaciju...)
8. slanje zahtjeva routeru - aplikacija prosljeđuje zahtjev routeru
9. router pronalazi rutu - router pregledava sve rute definirane u `routes/` datotekama i pronalazi onu koja odgovara URL-u zahtjeva
10. izvršavanje middlewarea i kontrolera - zahtjev se zatim šalje kroz lanac middlewarea koji su pridruženi toj ruti, i na kraju stiže do svoje destinacije – najčešće metode na nekom kontroleru
    - middlewarei su komadi koda koji služe provjerama prije nego zahtjev stigne do kontrolera (npr. AuthMiddleware može provjeravati je li korisnik prijavljen - tek ako je prijavljen može pristupiti kontroleru)
    - analogija: zamislimo da postoji banka u koju ne možete ući ako ne posjedujete njihovu karticu - middleware bi bio zaštitar na ulazu koji provjerava imate li vi stvarno karticu banke
11. kontroler vraća odgovor - metoda kontrolera izvršava svoju logiku (npr. dohvaća podatke iz baze) i vraća odgovor (Response objekt), najčešće u obliku HTML-a (View)
12. povratak odgovora - taj Response objekt putuje natrag kroz lanac middlewarea (u obrnutom redoslijedu) i na kraju ga aplikacija šalje natrag korisnikovom pregledniku, koji ga prikazuje kao web stranicu

Ovo se sve dogodi u milisekundama, ali razumijevanje ovih koraka pomaže nam da znamo gdje i kako intervenirati u proces obrade zahtjeva.