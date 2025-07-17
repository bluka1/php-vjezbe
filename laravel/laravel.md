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
5. to je zapravo instanca servisnog spremnika (Service Container)
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

## Servisni spremnik (Service Container) i pružatelji usluga (Service Providers)

### Servisni spremnik (Service Container)
Analogija: Zamislite ga kao izuzetno pametnu kutiju s alatima. Kada vam treba neki kompleksan alat, npr. "alat za spajanje na bazu podataka", ne morate ga sami sastavljati. Samo kažete kutiji: "Hej, daj mi alat za bazu!" i ona vam ga preda, potpuno sastavljenog i spremnog za upotrebu.
OOP veza: Ovo je praktična primjena OOP uzoraka Dependency Injection i Inversion of Control. Umjesto da naša klasa sama stvara objekte o kojima ovisi (npr. new DatabaseConnection()), mi tu odgovornost prepuštamo spremniku. On "ubrizgava" ovisnosti umjesto nas.
A kako ta pametna kutija zna sastaviti alate? Tu na scenu stupaju Pružatelji usluga.

### Pružatelji usluga (Service Provider)
Analogija: Oni su upute za sastavljanje koje dolaze s novim alatom. Kada u aplikaciju dodamo novu funkcionalnost (servis), mi napišemo i njenog Providera. To je klasa koja "uči" Servisni spremnik kako da taj novi servis izgradi i pripremi.
OOP veza: Svaki Provider je klasa koja sadrži register() i boot() metode. U register() metodi "vežemo" naš servis za spremnik, a u boot() metodi možemo koristiti već registrirane servise.

Više o samom servisnom spremniku i pružatelju usluga te kako oni funkcioniraju popratite kroz komentare iz primjera.

## Rute - vrata aplikacije
Rute su jednostavno adrese web aplikacije.
One govore Laravelu što da učini kada korisnik posjeti određeni URL. Sve web rute definiramo u datoteci `routes/web.php`.

Analogija: datoteka `routes/web.php` je adresar ili telefonski imenik vaše aplikacije. Svaki unos povezuje jedan URL (adresa) s određenom akcijom.

OOP veza - kada pišemo `Route::get(...)`, mi zapravo pozivamo statičku metodu na klasi Route.

Ta klasa je fasada (Facade) što je vrlo čest OOP uzorak. Fasada nam pruža jednostavno, čitljivo sučelje za rad s puno kompleksnijim sustavom koji se nalazi "ispod haube" (u ovom slučaju, moćna Router klasa). Dakle, prisutan je pricnip apstrakcije - ne moramo znati sve kompleksne detalje implementacije, već koristimo jednostavno sučelje.

### Rutiranje i dostupne metode 
Laravelov ruter podržava sve standardne HTTP metode. Svaka metoda ima svoju svrhu:

`Route::get($uri, $callback);` - koristi se za dohvaćanje podataka. Kada u preglednik upišete adresu, šaljete GET zahtjev

```php
Route::get('/korisnici', function () {
    // Logika za prikaz svih korisnika
});
```

`Route::post($uri, $callback);` - koristi se za slanje novih podataka na server, najčešće putem HTML forme, kako bi se kreirao novi resurs

```php
Route::post('/korisnici', function () {
    // Logika za spremanje novog korisnika u bazu
});
```

`Route::put($uri, $callback);` i `Route::patch($uri, $callback);` - koriste se za ažuriranje postojećeg resursa. PUT obično podrazumijeva zamjenu cijelog resursa, dok PATCH podrazumijeva djelomičnu izmjenu
```php
Route::put('/korisnici/1', function () {
    // Logika za ažuriranje korisnika s ID-om 1
});
```

`Route::delete($uri, $callback);` - koristi se za brisanje postojećeg resursa

```php
Route::delete('/korisnici/1', function () {
    // Logika za brisanje korisnika s ID-om 1
});
```

`Route::any($uri, $callback);` - odgovara na bilo koju HTTP metodu

`Route::match(['get', 'post'], $uri, $callback);` - odgovara samo na navedene metode


### Parametri

Parametri u rutama mogu biti obvezni i neobavezni (opcionalni).

Često želimo da dio URL-a bude dinamičan. To postižemo parametrima.

#### Obvezni parametri
Parametar je obavezan dio URL-a. Definiramo ga unutar vitičastih zagrada.

```php
Route::get('/korisnici/{id}', function ($id) {
    return 'Prikaz korisnika s ID-om: ' . $id;
});
```

Ako pokušate posjetiti `/korisnici` bez ID-a, Laravel će javiti grešku (404 Not Found), jer ruta očekuje taj parametar.

#### Opcionalni parametri
Ponekad želimo da parametar bude neobavezan. To označavamo dodavanjem upitnika ? nakon imena parametra. U tom slučaju, varijabla u funkciji mora imati zadanu (defaultnu) vrijednost.

```php
Route::get('/clanci/{kategorija?}', function ($kategorija = 'sve') {
    return 'Prikaz članaka iz kategorije: ' . $kategorija;
});
```

Sada, ako posjetite:
`/clanci/sport` -> ispisat će se "Prikaz članaka iz kategorije: sport"
`/clanci` -> ispisat će se "Prikaz članaka iz kategorije: sve"


### CSRF zaštita - što je i zašto je važna?

CSRF (Cross-Site Request Forgery) je vrsta napada gdje napadač prevari korisnika da na vašoj stranici izvrši akciju koju nije namjeravao.

Analogija: zamislite da ste prijavljeni u svoju internet banku. Napadač vam pošalje link na sliku mačića. Vi kliknete, ali u pozadini tog linka skriven je zahtjev koji vašoj banci šalje naredbu "prebaci 1000 EUR na napadačev račun". Budući da ste vi prijavljeni, banka misli da ste vi poslali taj zahtjev i izvrši ga.

Kako nas Laravel štiti?

Laravel automatski štiti sve POST, PUT, PATCH i DELETE rute definirane u `routes/web.php`. To radi tako da za svaku korisničku sesiju generira jedinstveni, tajni token.

Kada kreiramo formu u našoj aplikaciji, moramo unutar nje dodati Blade direktivu `@csrf`.

Ova direktiva će u formu dodati skriveno polje s tim tajnim tokenom. Kada se forma pošalje, Laravel provjerava odgovara li poslani token onome koji je pohranjen u sesiji. Ako ne odgovara (kao u slučaju napada), Laravel će blokirati zahtjev. Time smo sigurni da je zahtjev poslan s naše stranice i od strane našeg korisnika.

## Napredno rutiranje - imenovanje, grupiranje i prefiksi

Kako aplikacije rastu, datoteka `routes/web.php` može postati nepregledna, ali postoje tehnike kako bismo je održali čistom, organiziranom i lakom za održavanje.

### Imenovanje ruta (Named Routes)
Prva i najvažnija tehnika je imenovanje ruta.

Analogija: Zamislite da URL `/korisnici/profil/uredi` ima nadimak "uredi_profil". Puno je lakše pamtiti i koristiti nadimak nego cijelu, dugačku adresu.

Imenujemo rutu dodavanjem metode `->name()` na kraj njene definicije:

```php
Route::get('/kontaktirajte-nas', function () {
    // ...
})->name('kontakt');
```

Zašto je ovo važno?

Zato što sada u ostatku aplikacije (npr. u linkovima unutar naših pogleda) više ne moramo pisati `<a href="/kontaktirajte-nas">`. Umjesto toga, koristimo globalnu `route()` funkciju: `<a href="{{ route('kontakt') }}">`.

Ako jednog dana odlučimo promijeniti URL iz `/kontaktirajte-nas` u `/kontakt`, jedino mjesto gdje to moramo promijeniti je `routes/web.php`. Svi linkovi generirani pomoću route('kontakt') će se automatski ažurirati. To nam štedi sate posla i sprječava buduće greške.


### Grupiranje i prefiksi
Kada imamo više ruta koje dijele zajedničke karakteristike, grupiramo ih.

Analogija: Zamislite da imate puno dokumenata vezanih za administrativni panel. Nećete ih razbacati po stolu, već ćete ih sve staviti u jedan registrator s natpisom "ADMIN".

#### Prefiksi URL-a (prefix)
Recimo da sve administratorske rute trebaju počinjati s `/admin`. Umjesto da to pišemo za svaku rutu, koristimo prefix:

```php
// Bez grupe (ponavljanje)
Route::get('/admin/dashboard', ...);
Route::get('/admin/users', ...);
Route::get('/admin/settings', ...);

// S grupom (čisto i organizirano)
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', ...);
    Route::get('/users', ...);
    Route::get('/settings', ...);
});
```

Rezultirajući URL-ovi su potpuno isti, ali je naš kod puno čišći.

#### Prefiksi imena ruta (name)
Isto vrijedi i za imena ruta. Možemo dodati zajednički prefiks svim imenima unutar grupe:
```php
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', ...)->name('dashboard'); // Rezultat: admin.dashboard
    Route::get('/users', ...)->name('users');       // Rezultat: admin.users
});
```

Sada možemo koristiti `route('admin.dashboard')`.

#### Kombiniranje svega gore navedenog
Moć grupa leži u kombiniranju. Možemo u jednoj grupi definirati zajednički middleware, prefiks URL-a i prefiks imena:
```php
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users');
});
```

Što smo ovime dobili?
- sve rute unutar ove grupe moraju imati korisnika koji je prijavljen (auth), moraju počinjati s `/admin` i njihova imena moraju počinjati s `admin.`

## Middleware - "čuvari" aplikacije

### Uloga middlewarea
Middleware je mehanizam za filtriranje i izvršavanje koda prije ili nakon što HTTP zahtjev stigne do svoje konačne destinacije - kontrolera.

Analogija: Zamislite ga kao niz kontrolnih točaka na putu do trezora banke.
1. Prvi zaštitar provjerava imate li uopće karticu za ulaz
2. Drugi provjerava jeste li klijent banke (npr. je li korisnik prijavljen - auth middleware)
3. Treći provjerava imate li dozvolu za ulazak u taj specifični sef (npr. je li korisnik administrator - admin middleware)

Tek ako prođete sve točke, stižete do trezora (kontrolera).

OOP veza - svaki middleware je PHP klasa koja implementira handle metodu i to je savršen primjer OOP uzorka chain of responsibility (lanac odgovornosti), gdje zahtjev putuje kroz lanac objekata (middlewarea).

### Kreiranje i registracija novog middlewarea

1. kreiranje (artisan naredbom)
- ako želimo stvoriti middleware po imenu CheckAge, stvaramo ga naredbom `php artisan make:middleware CheckAge`
- ova naredba kreira datoteku `app/Http/Middleware/CheckAge.php` i unutar nje, ključna je handle metoda:
```php
public function handle(Request $request, Closure $next): Response
{
    // Logika koja se izvršava PRIJE kontrolera
    if ($request->input('age') < 18) {
      // input() je metoda na request objektu koja čita parametre iz URL-a (GET request)
      // ako ne nade tamo, provjerava polja vezana uz POST request (npr. input fieldove)
        return redirect('home'); // Ako uvjet nije zadovoljen, preusmjeri i zaustavi
    }

    // Proslijedi zahtjev sljedećem middlewareu ili kontroleru
    return $next($request);
}
```

2. registracija (u `bootstrap/app.php`)
- da bi Laravel znao za naš novi middleware, moramo mu dati nadimak (alias)
- u `bootstrap/app.php` i unutar `.withMiddleware()` metode, dodamo alias:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'check.age' => \App\Http\Middleware\CheckAge::class,
    ]);
})
```
- sada smo CheckAge klasi dali nadimak check.age

### Grupiranje(primjena na grupu ruta) i atributi
#### Primjena middlewarea na grupu ruta
Često želimo primijeniti isti set middlewarea na više ruta. Umjesto da ih pišemo na svakoj ruti, grupiramo ih:
```php
Route::middleware(['auth', 'check.age'])->group(function () {
    Route::get('/dashboard', ...);
    Route::get('/profile', ...);
});
```
- ovaj kod označava da za pristup dashboardu i profilu korisnik mora biti prijavljen (auth) i stariji od 18 godina (check.age)


#### Atributi (parametri) u middlewareu
Ponekad želimo da se naš middleware ponaša drugačije ovisno o situaciji. Za takve potrebe možemo mu proslijediti parametre.

Npr. želimo middleware koji provjerava ima li korisnik određenu ulogu (role)
```php
// CheckRole.php
public function handle(Request $request, Closure $next, string $role): Response
{
    if (! $request->user()->hasRole($role)) {
        // Preusmjeri ako korisnik nema traženu ulogu
        abort(403);
    }

    return $next($request);
}
```

- sada kod primjene middlewarea na rutu, dodajemo parametar nakon dvotočke:
```php
Route::get('/admin/posts/create', ...)
    ->middleware('role:editor');
```

- ovim govorimo: dopusti pristup ovoj ruti samo ako korisnik ima ulogu 'editor'