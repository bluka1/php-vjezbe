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

### Pridruživanje middlewarea rutama
Recimo da postoji `EnsureUserIsAdmin` middleware s aliasom `is.admin` i da naša aplikacija "zna" da postoji taj middleware, tada ga možemo početi koristiti. On se pridružuje rutama da bismo zaštitili određene dijelove naše aplikacije.

Analogija: Sada kada smo zaposlili zaštitara (`is.admin`), moramo mu reći koja vrata treba čuvati.

#### Pridruživanje jednoj ruti
Najjednostavniji način je dodati metodu `->middleware()` na kraj definicije rute:
```php
Route::get('/admin/dashboard', function () {
    return 'Dobrodošli na administratorsku ploču!';
})->middleware('is.admin');
```

Sada, prije nego što se izvrši funkcija i prikaže poruka, Laravel će prvo pokrenuti naš `EnsureUserIsAdmin` middleware.

### Pridruživanje grupi ruta
Puno češće ćemo htjeti zaštititi cijeli set ruta. Umjesto da dodajemo middleware na svaku pojedinačno, primijenit ćemo ga na cijelu grupu. To je čišće i efikasnije.

```php
Route::middleware('is.admin')->group(function () {
    Route::get('/admin/dashboard', function () {
        return 'Administratorska ploča';
    });
    Route::get('/admin/users', function () {
        return 'Popis svih korisnika';
    });
});
```

Ovdje označavamo - sve rute definirane unutar ove grupe moraju proći provjeru `is.admin` middlewarea.
Ovo je preferirani način za zaštitu cijelih sekcija aplikacije, poput kompletnog administratorskog sučelja.

## Kontroleri - "Menadžeri" vaše aplikacije
Analogija: Ako je Router recepcioner koji usmjerava pozive, Kontroler je menadžer odjela. Recepcioner ne rješava problem sam; on samo spoji klijenta s pravim menadžerom. Menadžer (Kontroler) zatim preuzima, organizira posao (dohvaća podatke od Modela) i na kraju delegira prezentaciju (šalje podatke View-u).

Svrha: Kontroleri su ključni dio MVC (Model-View-Controller) arhitekture. Njihova svrha je da grupiraju logiku vezanu za određeni dio aplikacije. Na primjer, PostController će imati svu logiku za rad s člancima.

OOP veza: Kontroler je jednostavno PHP klasa. Svaka javna metoda unutar te klase je akcija koju ruta može pozvati. Ovo je savršen primjer principa enkapsulacije – grupiranje srodnih funkcionalnosti na jedno mjesto.

### Definiranje kontrolera i povezivanje s rutama
1. Kreiranje kontrolera
`php artisan make:controller PostController`

Ovo kreira datoteku `app/Http/Controllers/PostController.php`. Unutar nje, dodajemo metode:

```php
namespace App\Http\Controllers;

class PostController extends Controller
{
    public function index()
    {
        return 'Prikaz svih članaka';
    }

    public function show(string $id)
    {
        return 'Prikaz članka s ID-om: ' . $id;
    }
}
```

2. Povezivanje ruta s kontrolerom
Sada u `routes/web.php`, umjesto funkcije, prosljeđujemo polje koje sadrži klasu kontrolera i ime metode kao string:
```php
use App\Http\Controllers\PostController;

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);
```

Ovo je puno čišće i organiziranije.

### Dependency Injection(DI) u kontrolerima
Dependency Injection (DI) je koncept prisutan u mnogim frameworcima i u drugim jezicima. To je koncept gdje se ovisnosti (drugi objekti koji su klasi potrebni) "ubrizgavaju" tj. "injectaju" u nju, umjesto da ih klasa sama stvara.

Analogija: Zamislite kuhara (kontroler) kojem ne trebaju samo recepti (metode), već i sastojci (ovisnosti). Umjesto da kuhar sam ide u dućan po sastojke (npr. `new Request()`), dostavljač (Laravelov Service Container) mu ih donese direktno na radnu površinu (kao argumente metode).

Laravel ovo radi automatski za nas. Ako u metodi kontrolera zatražimo određenu klasu (npr. `Illuminate\Http\Request`), Laravel će nam automatski stvoriti i proslijediti njen objekt.

```php
use Illuminate\Http\Request;

public function store(Request $request)
{
    // ne moramo pisati $request = new Request();
    // Laravel nam ga je automatski "ubrizgao"

    $title = $request->input('title');
    // ... logika za spremanje ...
}
```

### Resursni kontroleri (Resource Controllers)
Često za neki resurs (poput članaka, korisnika, proizvoda) trebamo isti set akcija: prikaz svih, prikaz jednog, forma za kreiranje, spremanje, forma za uređivanje, ažuriranje i brisanje. Ovo se zove `CRUD` (Create, Read, Update, Delete).

Da ne bismo ručno pisali 7 ruta i 7 metoda svaki put, Laravel nudi prečac.

1. Kreiranje resursnog kontrolera:
Dodajemo --resource zastavicu na artisan naredbu:
`php artisan make:controller ProductController --resource`

Ovo će kreirati kontroler sa svim potrebnim, već definiranim praznim metodama (index, create, store, show, edit, update, destroy).

2. Definiranje resursne rute:
U `routes/web.php`, jedna linija koda zamjenjuje sedam:
`Route::resource('products', ProductController::class);`

Ova jedna linija automatski kreira sve potrebne GET, POST, PUT/PATCH i DELETE rute i povezuje ih s odgovarajućim metodama na ProductControlleru. To je ogromna ušteda vremena.

### Pridruživanje middlewarea kontroleru
Osim toga što middleware možemo dodijeliti rutama, postoji još elegantnija opcija, a to je da ga dodijelimo kontroleru.

Prednosti tog pristupa:
- enkapsulacija logike - pravila koja se odnose na kontroler pripadaju tom kontroleru, a datoteka s rutama ostaje čista i bavi se samo definiranjem adresa
- preciznija kontrola - možemo reći da se neki middleware primijeni na sve metode u kontroleru osim na neke, ili samo na određene metode
    - to radimo unutar `__construct` metode (konstruktora) kontrolera

OOP veza: konstruktor je, kao što znamo, posebna metoda koja se izvršava čim se objekt (u ovom slučaju, kontroler) kreira. To je savršeno mjesto za postavljanje "pravila" (middlewarea) koja će vrijediti za taj objekt i sve njegove metode.

Recimo da postoji PostController. Želimo da svi mogu vidjeti popis članaka (index) i jedan članak (show), ali samo prijavljeni korisnici mogu kreirati, uređivati i brisati članke.

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        // primijeni 'auth' middleware na SVE metode OSIM 'index' i 'show'
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        return 'Svi mogu vidjeti popis članaka';
    }

    public function show(string $id)
    {
        return 'Svi mogu vidjeti članak ' . $id;
    }

    public function create()
    {
        return 'Samo prijavljeni korisnici mogu vidjeti ovu formu';
    }

    public function store(Request $request)
    {
        // samo prijavljeni korisnici mogu spremiti članak
    }

    // ... edit, update, destroy mogu koristiti samo prijavljeni korisnici
}
```

Analogija:
Ovime smo rekli: "Angažiraj zaštitara (auth) da čuva sva vrata ovog odjela (PostController), osim glavnog ulaza (index) i izložbenog prostora (show), koji su otvoreni za javnost."

Alternativno, mogli smo postići isto s metodom `only()`:
- `$this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy']);`

Ovo je izuzetno moćan i čist način za definiranje pravila pristupa unutar same klase koja je za njih zadužena.

## HTTP Zahtjevi
Iz HTTP zahtjeva možemo izvlačiti informacije, a za to se moramo upoznati s Laravelovim Request objektom.

### HTTP Zahtjev (Request)
Svaki put kad korisnik posjeti stranicu ili pošalje formu, njegov preglednik šalje HTTP zahtjev našem serveru. Taj zahtjev sadrži hrpu korisnih informacija.

Analogija: Zamislite da naručujete pizzu telefonom. Vaša narudžba (zahtjev) nije samo "dajte mi pizzu". Ona sadrži:
- URL - koju pizzeriju zovete (/pizzerija/narudzba)
- metoda - što želite učiniti (GET - pitati za meni, POST - naručiti novu pizzu)
- zaglavlja (headers) - tko zove (vaš broj telefona - vrsta preglednika)
- tijelo (body) / parametri - detalji narudžbe ("jedna velika capricciosa, bez gljiva" - `?velicina=velika&vrsta=capricciosa`)

OOP veza: Laravel sve te informacije lijepo zapakira u jedan objekt klase `Illuminate\Http\Request`. Ovo je savršen primjer enkapsulacije. Umjesto da lovimo podatke iz globalnih PHP varijabli poput `$_GET` i `$_POST`, mi radimo s čistim i moćnim objektom koji dobivamo putem Dependency Injectiona u našim metodama kontrolera.

### Slanje i dohvaćanje podataka putem GET metode
GET metoda šalje podatke kao dio URL-a, u tzv. query stringu. To je sve ono što dolazi nakon ? u URL-u. Ovo je idealno za stvari poput pretrage, filtriranja ili paginacije.

Primjer: Recimo da imamo stranicu za pretragu proizvoda. Korisnik može upisati pojam za pretragu i odabrati sortiranje. URL bi mogao izgledati ovako:
`/pretraga?pojam=laptop&sortiraj=cijeni_rastuce`

Dohvaćanje tih podataka u kontroleru:
1. Ruta (`routes/web.php`):
- definiramo jednostavnu rutu koja vodi na naš kontroler.
```php
use App\Http\Controllers\SearchController;

Route::get('/pretraga', [SearchController::class, 'index']);
```

2. Kontroler (`SearchController.php`):
- kreiramo kontroler i unutar index metode, zatražimo Request objekt (kroz DI - Dependency Injection)
```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // dohvaćanje jednog parametra iz query stringa
        $pojam = $request->query('pojam');

        // dohvaćanje drugog parametra
        // ako ne postoji, koristit će se zadana vrijednost 'naziv'
        $sortirajPo = $request->query('sortiraj', 'naziv');

        // metoda input() radi isto i za GET i za POST, pa je često praktičnija
        // $pojam = $request->input('pojam');
        // $sortirajPo = $request->input('sortiraj', 'naziv');

        // provjera postoji li parametar
        if ($request->has('pojam')) {
            return "Rezultati pretrage za pojam '{$pojam}', sortirano po: {$sortirajPo}";
        }

        return "Molimo unesite pojam za pretragu";
    }
}
```

Sada, ako posjetimo `/pretraga?pojam=monitor&sortiraj=cijeni_padajuce`, rezultat će biti:
- "Rezultati pretrage za pojam 'monitor', sortirano po: cijeni_padajuce."

Za `/pretraga?pojam=tipkovnica`, rezultat će biti:
- "Rezultati pretrage za pojam 'tipkovnica', sortirano po: naziv."

Za `/pretraga`, rezultat će biti: 
- "Molimo unesite pojam za pretragu."

### Slanje podataka (POST) i datoteke

#### Slanje i dohvaćanje podataka putem POST metode
Za razliku od GET metode gdje su podaci vidljivi u URL-u, POST metoda šalje podatke u "tijelu" (body) HTTP zahtjeva. Ovo je sigurniji i prikladniji način za slanje osjetljivih informacija ili veće količine podataka.

Analogija: Ako je GET zahtjev poštanski papirić na kojemu svi mogu pročitati sadržaj, POST zahtjev je zatvoreno pismo. Sadržaj je skriven od pogleda dok ne stigne na odredište.

- kreiranje zahtjeva:
1. Rute (`routes/web.php`)
- potrebne su nam dvije rute - jedna GET ruta da prikaže formu i jedna POST ruta da obradi poslane podatke
```php
use App\Http\Controllers\ContactController;

// prikazuje kontaktnu formu
Route::get('/contact', [ContactController::class, 'create']);

// obrađuje podatke poslane iz forme
Route::post('/contact', [ContactController::class, 'store']);
```

2. Kontroler (`ContactController.php`):
- metoda create će vratiti pogled (view), a store će obraditi podatke
```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create()
    {
        // vraća HTML pogled s formom (npr. resources/views/contact.blade.php)
        return view('contact');
    }

    public function store(Request $request)
    {
        // dohvaćanje podataka iz POST zahtjeva
        $ime = $request->input('name');
        $poruka = $request->input('message');

        // ovdje bi išla logika za spremanje u bazu ili slanje e-maila...

        return "Hvala, {$ime}! Vaša poruka je primljena. Kontaktirat ćemo Vas u najkraćem mogućem roku.";
    }
}
```

Metoda `$request->input('ime_polja')` je univerzalna i dohvaća podatke i iz GET i iz POST zahtjeva.

#### Dohvat poslanih datoteka (file uploads)
Slanje datoteka je specifičan slučaj POST zahtjeva. Forma mora imati `enctype="multipart/form-data"` atribut.

Analogija: Obično pismo (POST) može sadržavati samo tekst. Ako želite poslati paket (kutiju tj. datoteku), morate koristiti posebnu uslugu (`multipart/form-data`) koja zna kako rukovati s kutijama.

Primjer - forma za upload profilne slike
1. forma (unutar pogleda)
```html
<form action="/profile" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="avatar">
    <button type="submit">Upload</button>
</form>
```

2. kontroler
- u kontroleru, datotekama ne pristupamo putem `input()`, već putem `file()` metode
```php
public function update(Request $request)
{
    // provjera je li datoteka poslana i je li ispravna
    if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {

        // dohvaćanje objekta datoteke
        $file = $request->file('avatar');

        // dohvaćanje originalnog imena datoteke
        $originalName = $file->getClientOriginalName();

        // spremanje datoteke na disk
        // 'avatars' je poddirektorij unutar storage/app/public
        $path = $file->store('avatars', 'public');

        return "Datoteka '{$originalName}' je uspješno spremljena na putanju: {$path}";
    }

    return "Nije poslana ispravna datoteka.";
}
```

- Važno - da bi datoteke spremljene u `storage/app/public` bile dostupne javnosti, potrebno je jednom pokrenuti artisan naredbu:
    - `php artisan storage:link`

Ona kreira simboličku vezu iz `public/storage` u `storage/app/public`.


## Validacija podataka
Kad god primamo korisnikove podatke, moramo provjeriti jesu li ti podaci ispravni i sigurni. Radi toga uvodimo koncept validacije.
Nikada, ali baš nikada, ne smijemo vjerovati podacima koje dobijemo od korisnika. 
Validacija je proces provjere jesu li ti podaci u formatu koji vaša aplikacija očekuje.

Analogija: 
Zamislite da ste izbacivač u noćnom klubu (vaš kontroler). Nećete pustiti bilo koga unutra. Prvo provjeravate osobnu iskaznicu (validirate podatke). Je li osoba punoljetna (min number input)? Postoji li uopće ime na osobnoj (required input)? Je li osobna ispravna (validan ID)? 
Zatim, tek ako su svi uvjeti zadovoljeni, puštate osobu unutra (u metodu kontrolera).

OOP veza:
Kada pozovemo metodu za validaciju, mi zapravo koristimo `Validator` objekt koji enkapsulira svu kompleksnu logiku provjere pravila

### Validacija unutar kontrolera
Najjednostavniji način za validaciju je korištenje `validate()` metode direktno na `Request` objektu.

Primjer: Imamo formu za kreiranje novog blog članka. Želimo osigurati da naslov postoji, da je tekst, i da ima najmanje 3 znaka. Sadržaj također mora postojati.

1. Kontroler (`PostController.php`)
- u `store()` metodi, prije bilo kakve logike, dodajemo validaciju
```php
use Illuminate\Http\Request;

public function store(Request $request)
{
    $validatedData = $request->validate(
      [
        'title' => 'required|string|min:3|max:255',
        'content' => 'required|string'
      ],
      [
        'title.required' => 'Molimo unesite title.',
        'title.min' => 'Title mora imati najmanje 3 znaka.',
        'content.required' => 'Content je obavezan.',
      ]
    );


    // ako validacija prođe, kod se nastavlja
    // $validatedData sada sadrži samo provjerene podatke

    // ovdje bi išla logika za spremanje u bazu...

    // Post::create($validatedData);

    return "Članak je uspješno kreiran!";
}
```

Što se događa ako validacija ne prođe?

Laravel automatski radi nekoliko stvari za nas:
- zaustavlja izvršavanje koda u metodi
- preusmjerava korisnika natrag na prethodnu stranicu (na formu)
- sprema sve greške validacije u sesiju
- također sprema i stari unos (old input) kako korisnik ne bi morao ponovno ispunjavati cijelu formu

Više o validaciji u [dokumentaciji](https://laravel.com/docs/12.x/validation).
Više o pravilima validacije - [link](https://laravel.com/docs/12.x/validation#available-validation-rules).

### Prikaz grešaka u pogledu (View)

Sada u našem Blade pogledu (`create.blade.php`), možemo lako prikazati greške koristeći `@error` direktivu,`$message` varijablu te `old()` metodu
```php
<form action="/posts" method="POST">
  @csrf
  <div>
    <label for="title">Naslov</label>
    <input type="text" name="title" value="{{ old('title') }}">
    @error('title')
      <div style="color: red;">{{ $message }}</div>
    @enderror
  </div>

  <div>
    <label for="content">Sadržaj</label>
    <textarea name="content">{{ old('content') }}</textarea>
    @error('content')
      <div style="color: red;">{{ $message }}</div>
    @enderror
  </div>

  <button type="submit">Spremi</button>
</form>
```

- `old('title')` - ako validacija padne, ovo će vratiti staru vrijednost koju je korisnik unio
- `@error('title') ... @enderror` - ovaj blok će se prikazati samo ako postoji greška za polje title
- `$message` - unutar `@error` bloka, ova varijabla sadrži poruku o grešci (npr. "The title field is required.")

### Form Request validacija
Validacija u kontroleru je odlična za jednostavne forme no on može vrlo brzo postati nepregledan i zatrpan logikom koja mu tu ne pripada.

U tom slučaju, rješenje je `FormRequest`.

Analogija: 
Umjesto da menadžer odjela (kontroler) sam provjerava svaku osobu na ulazu, on zaposli zaštitara (`FormRequest` klasu). 
Sav posao provjere delegira njemu. Menadžerov posao je samo da radi s ljudima koji su već prošli provjeru.

OOP veza: 
`FormRequest` je posebna PHP klasa koja enkapsulira svu logiku validacije i autorizacije za određeni zahtjev.
To je savršen primjer Single Responsibility Principle - kontroler se bavi obradom, a `FormRequest` se bavi validacijom.

#### Kreiranje i korištenje Form Requesta

1. Kreiranje klase
- koristimo artisan naredbu `php artisan make:request StorePostRequest`
- ova naredba kreira datoteku `app/Http/Requests/StorePostRequest.php`
- unutar te datoteke su četiri važne metode koje možemo koristiti: `authorize()`, `rules()`, `messages()` i `withValidator()`

2. Definiranje pravila i poruka
- `authorize()` - ova metoda se izvršava prije validacije i služi za provjeru ima li korisnik uopće dozvolu da izvrši ovu akciju
- `rules()` - ovdje premještamo naša pravila validacije iz kontrolera
- `messages()` - (opcionalno) ovdje možemo definirati vlastite, prilagođene poruke o greškama na našem jeziku
- `withValidator()` - (opcionalno) ovdje možemo dodati kompleksniju, uvjetnu validaciju koja se izvršava nakon osnovnih pravila

```php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string',
            'is_published' => 'sometimes|boolean',
            'published_at' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Naslov je obavezno polje.',
            'title.min' => 'Naslov mora imati najmanje :min znaka.',
            'content.required' => 'Sadržaj ne smije biti prazan.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            // ako je `is_published` označeno, onda `published_at` mora postojati
            if ($this->boolean('is_published') && !$this->filled('published_at')) {
                $validator->errors()->add(
                    'published_at',
                    'Datum objave je obavezan ako je članak označen za objavu.'
                );
            }
        });
    }
}
```

3. Korištenje u kontroleru
- sada naš kontroler postaje čist
- `Illuminate\Http\Request`, koristimo `StorePostRequest` klasu
```php
use App\Http\Requests\StorePostRequest;

public function store(StorePostRequest $request)
{
    // ako kod stigne do ove točke, to znači da su
    // i autorizacija i validacija već prošle

    // dohvaćamo samo validirane podatke
    $validatedData = $request->validated();

    // Post::create($validatedData);

    return "Članak je uspješno kreiran!";
}

```
- Laravel automatski prepoznaje da se radi o Form Requestu, izvršava authorize, rules i ostale metode, i ako bilo što od toga ne prođe, automatski preusmjerava korisnika natrag, baš kao i prije
- Prednosti:
    - kontroleri su čisti i fokusirani na svoju glavnu logiku
    - validacijska logika je enkapsulirana i na jednom mjestu
    - pravila su ponovno iskoristiva (npr. isti `FormRequest` možemo koristiti i za store i za update metodu)

## HTTP Odgovori (Responses)
HTTP odgovori odnose se na to kako naša aplikacija odgovara klijentu. Svaka ruta ili metoda kontrolera mora na kraju vratiti nekakav odgovor koji će biti poslan natrag korisnikovom pregledniku.

Analogija: 
Ako je `Request` narudžba koju primite u restoranu, `Response` je jelo koje na kraju poslužite gostu. Može biti jednostavno (samo tanjur tjestenine), može biti kompleksno (meni od pet sljedova s bocom vina), a može biti i poruka "Žao nam je, nemamo više tog jela" (greška) ili uputa konobaru da gosta premjesti na drugi stol (preusmjeravanje).

OOP veza: 
Svi odgovori u Laravelu su instance klase `Illuminate\Http\Response` (ili njenih podklasa). Ovo nam omogućuje da s odgovorima radimo na čist, objektno-orijentiran način, umjesto da koristimo PHP funkcije poput `echo` ili `header()`. 

### Osnovni odgovori
Najjednostavniji odgovor je vraćanje stringa ili niza iz kontrolera. Laravel će ih automatski pretvoriti u ispravan HTTP odgovor.
```php
Route::get('/pozdrav', function () {
    return 'Hello world!'; // Laravel će ovo pretvoriti u HTTP 200 OK odgovor
});
```
```php
Route::get('/api/korisnik', function () {
    return ['ime' => 'Pero', 'prezime' => 'Perić']; // Laravel će ovo automatski pretvoriti u JSON
});
```

### Response objekt i `response()` pomoćna funkcija
Za veću kontrolu, koristimo `response()` pomoćnu funkciju koja nam daje pristup punom `Response` objektu. To nam omogućuje da prilagodimo status kod i zaglavlja (headers).
```php
Route::get('/greska', function () {
    return response('Nije pronađeno.', 404)
           ->header('Content-Type', 'text/plain');
});
```

### Preusmjeravanja (Redirects)
Jedan od najčešćih odgovora je preusmjeravanje. Nakon što korisnik uspješno spremi formu, ne želimo mu prikazati praznu stranicu, već ga želimo preusmjeriti na drugu lokaciju.

- preusmjeravanje na imenovanu rutu (najbolja praksa)
```php
public function store(Request $request)
{
    // ... logika za spremanje ...

    return redirect()->route('posts.index');
}
```

- preusmjeravanje natrag na prethodnu stranicu - ovo je izuzetno korisno. Laravel pamti odakle je korisnik došao
```php
public function update(Request $request)
{
    // ... logika za ažuriranje ...

    return back()->with('success', 'Profil je uspješno ažuriran!');
}
```
- metoda `with()` "bljesne" (flashes) podatke u sesiju. To znači da će varijabla success biti dostupna samo u sljedećem HTTP zahtjevu, što je idealno za prikazivanje poruka o uspjehu.

### Ostale vrste odgovora
Laravel nudi pomoćne funkcije za kreiranje specifičnih vrsta odgovora:
- View odgovori - najčešći odgovor za web stranice
```php
public function show($id)
{
    $post = Post::findOrFail($id);
    return view('posts.show', ['post' => $post]);
}
```
- JSON odgovori - standard za API-je; automatski postavlja `Content-Type` zaglavlje na `application/json`
```php
public function showApi($id)
{
    $post = Post::findOrFail($id);
    return response()->json($post);
}
```
- file download odgovori - kada želite da preglednik pokrene preuzimanje datoteke
```php
public function downloadInvoice($id)
{
    // ... logika za dohvat putanje do računa ...
    $pathToInvoice = storage_path('app/invoices/invoice-'.$id.'.pdf');

    return response()->download($pathToInvoice);
}
```

## Pogledi (Views)
Pogledi su V u MVC (Model-View-Controller) arhitekturi. Njihova jedina svrha je da prikazuju podatke u HTML formatu. Sva logika za dohvaćanje i obradu podataka pripada kontroleru, a pogled je tu samo da te podatke lijepo prezentira.

### Kreiranje i vraćanje pogleda
Svi pogledi u Laravelu se nalaze u `resources/views` direktoriju. To su datoteke s `.blade.php` ekstenzijom.

1. kreiranje pogleda
```php
// pozdrav.blade.php
<!DOCTYPE html>
<html>
<head>
    <title>Dobrodošlica</title>
</head>
<body>
    <h1>Pozdrav iz našeg prvog pogleda!</h1>
</body>
</html>
```

- pogled možemo kreirati manualno izradom datoteke ili pomoću naredbe - `php artisan make:view folder.ime`

2. vraćanje pogleda iz kontrolera
U kontroleru koristimo `view()` pomoćnu funkciju kako bismo vratili view

```php
// u kontroleru - npr. WelcomeController.php
public function show()
{
    // Laravel će potražiti datoteku 'resources/views/pozdrav.blade.php'
    return view('pozdrav');
}
```

### Organizacija pogleda u poddirektorijima
Poglede možemo organizirati u poddirektorije za bolju strukturu:

```php
// za pogled na putanji resources/views/admin/dashboard.blade.php
return view('admin.dashboard');

// možemo koristiti i kosu crtu
return view('admin/dashboard');
```

### Provjera postojanja pogleda
Prije vraćanja pogleda, možemo provjeriti postoji li:

```php
use Illuminate\Support\Facades\View;

if (View::exists('emails.customer')) {
    return view('emails.customer');
}

// vraćanje prvog pogleda koji postoji
return view()->first(['custom.admin', 'admin'], $data);
```

### Prosljeđivanje podataka u pogled
Rijetko kada imamo statične stranice, odnosno stranice u koje nećemo ubaciti apsolutno nikakve podatke. Najčešće želimo prikazati dinamičke podatke koje smo dohvatili u kontroleru iz baze ili s nekog API-a. Podatke prosljeđujemo kao drugi argument `view()` funkciji, u obliku asocijativnog polja (najčešće korišteni način prosljeđivanja podataka).

```php
// u WelcomeController.php
public function show()
{
    $imeKorisnika = 'Pero';
    $grad = 'Zagreb';

    return view('pozdrav', [
        'ime' => $imeKorisnika,
        'lokacija' => $grad
    ]);
    
    // alternativni načini:
    // korištenje with() metode
    return view('pozdrav')
            ->with('ime', $imeKorisnika)
            ->with('lokacija', $grad);
    
    // korištenje compact() funkcije
    $ime = $imeKorisnika;
    $lokacija = $grad;
    return view('pozdrav', compact('ime', 'lokacija'));
}
```

Sada unutar `pozdrav.blade.php`, možemo pristupiti tim podacima koristeći standardnu PHP sintaksu

```php
<h1>Pozdrav, <?php echo $ime; ?>!</h1>
<p>Drago nam je što ste nam se javili iz grada: <?php echo $lokacija; ?>.</p>
```

Ovo radi, ali nije baš elegantno. Kako bismo to jednostavnije odradili, pomoći će nam blade predlošci.

### Dijeljenje podataka sa svim pogledima (napredna tematika)
Ponekad trebamo neke podatke učiniti dostupnima svim pogledima:

```php
// u AppServiceProvider boot() metodi
use Illuminate\Support\Facades\View;

public function boot()
{
    View::share('nazivAplikacije', 'Moja Laravel Aplikacija');
    
    // ili samo za specifične poglede
    View::composer('dashboard', function ($view) {
        $view->with('brojKorisnika', User::count());
    });
}
```

## URL generiranje
Laravel pruža nekoliko pomoćnih funkcija za generiranje URL-ova koje možemo koristiti u pogledima:

### url() helper
Generira potpuni URL do zadane putanje:

```php
// u Blade pogledu
<a href="{{ url('/kontakt') }}">Kontaktirajte nas</a>
<a href="{{ url('/korisnik', $id) }}">Profil korisnika</a>

{{ url()->current() }} // trenutni URL
{{ url()->full() }}  // s query stringom
{{ url()->previous() }}  // prethodni URL
```

### route() helper
Generira URL na temelju imena rute (preporučeno):

```php
// ako imamo rutu Route::get('/profil/{id}', ...)->name('profil.show');
<a href="{{ route('profil.show', ['id' => $korisnik->id]) }}">Moj profil</a>

// provjera trenutne rute
@if(Route::currentRouteName() == 'home')
    <p>Na početnoj ste stranici!</p>
@endif
```

### asset() helper
Za dodavanje CSS, JavaScript i drugih resursa:

```php
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="{{ asset('js/app.js') }}"></script>
<img src="{{ asset('images/logo.png') }}" alt="Logo">

// za sigurne HTTPS linkove
<link rel="stylesheet" href="{{ secure_asset('css/app.css') }}">
```

## Uvod u Blade predloške
Blade je moćni sustav predložaka koji nam omogućuje da pišemo HTML na puno čišći i čitljiviji način nego u standardnom PHP-u, pružajući nam prečace za uobičajene PHP zadatke. Važno je znati da se sav Blade kod na kraju kompajlira u čisti PHP kod, tako da nema nikakvog gubitka performansi.

### Prikazivanje podataka
Umjesto `<?php echo $varijabla; ?>`, u Bladeu koristimo dvostruke vitičaste zagrade:

`{{ $varijabla }}`

Primjer:

`<h1>Pozdrav, {{ $ime }}!</h1>`

Ovo je puno čišće. Ali, još važnije, Blade automatski štiti od XSS napada (XSS - Cross-Site Scripting je sigurnosni propust gdje napadač unese maliciozni kod (najčešće JavaScript) u vašu web stranicu, npr. kroz polje za komentar). To znači da ako varijabla `$ime` sadrži maliciozni JavaScript kod, Blade će ga automatski "očistiti" (escapati) tako da se prikaže kao običan tekst, a ne kao izvršni kod.

### Prikazivanje ne-escapanih podataka
Ako ste sigurni da su podaci sigurni i trebate prikazati HTML:

```php
// OPREZ - koristite samo ako ste 100% sigurni da su podaci sigurni!
{{!! $htmlSadrzaj !!}}
```

### Blade direktive - uvjeti i petlje
Blade nudi jednostavne direktive za kontrolne strukture koje počinju sa znakom `@`.

UVJETI:
- `@if, @elseif, @else, @endif`
```php
@if (count($korisnici) === 1)
    Imamo samo jednog korisnika!
@elseif (count($korisnici) > 1)
    Imamo više korisnika!
@else
    Nemamo nijednog korisnika.
@endif
```

- `@unless`
    - suprotno od `@if` - izvršava se ako je uvjet netočan
```php
@unless (Auth::check())
  Molimo prijavite se.
@endunless
```

- `@isset`
    - izvršava se ako varijabla postoji i nije null
```php
@isset($zapis)
  Prikaz zapisa...
@endisset
```

- `@empty`
    - izvršava se ako je varijabla prazna
        - "prazno" znači da je vrijednost `null`, `false`, `0`, prazan string ('') ili prazno polje `[]`
```php
@empty($komentari)
    <p>Ovaj korisnik još nema nijedan komentar.</p>
@endempty
```

- `@auth i @guest`
    - provjera je li korisnik prijavljen
```php
@auth
    <p>Dobrodošli, {{ Auth::user()->name }}!</p>
    <a href="{{ route('logout') }}">Odjava</a>
@endauth

@guest
    <a href="{{ route('login') }}">Prijava</a>
    <a href="{{ route('register') }}">Registracija</a>
@endguest

// za specifični guard
@auth('admin')
    <p>Prijavljen kao administrator</p>
@endauth
```

PETLJE:

- `@foreach`
    - unutar nje dostupna je $loop varijabla s korisnim informacijama
```php
<ul>
    @foreach ($korisnici as $korisnik)
        <li>
            {{ $loop->iteration }}. {{ $korisnik->ime }}
            @if ($loop->first)
                (Prvi korisnik)
            @endif
            @if ($loop->last)
                (Zadnji korisnik)
            @endif
        </li>
    @endforeach
</ul>
```

- `$loop` svojstva:
    - $loop->index - indeks trenutne iteracije (počinje od 0)
    - $loop->iteration - broj trenutne iteracije (počinje od 1)
    - $loop->remaining - broj preostalih iteracija
    - $loop->count - ukupan broj elemenata
    - $loop->first - true ako je prva iteracija
    - $loop->last - true ako je zadnja iteracija
    - $loop->even - true ako je paran broj iteracije
    - $loop->odd - true ako je neparan broj iteracije
    - $loop->depth - razina ugniježđenja petlje
    - $loop->parent - $loop varijabla roditelj petlje (kod ugniježđenih)

- `@forelse` (najbolji izbor kada niste sigurni hoće li polje biti prazno)
```php
@forelse ($korisnici as $korisnik)
    <li>{{ $korisnik->ime }}</li>
@empty
    <p>Nema registriranih korisnika.</p>
@endforelse
```

- `@for` petlja
```php
@for ($i = 0; $i < 10; $i++)
    Broj je {{ $i }} <br>
@endfor
```

- `@while` petlja
```php
@php $i = 0; @endphp
@while ($i < 5)
    <p>Trenutna vrijednost je {{ $i }}</p>
    @php $i++; @endphp
@endwhile
```

- `@continue i @break`
```php
@foreach ($korisnici as $korisnik)
    @if ($korisnik->tip == 'admin')
        @continue
    @endif

    @if ($korisnik->blokiran)
        @break
    @endif

    <li>{{ $korisnik->ime }}</li>
@endforeach

// Mogu primiti uvjet direktno
@foreach ($korisnici as $korisnik)
    @continue($korisnik->tip == 'admin')
    @break($korisnik->blokiran)
    
    <li>{{ $korisnik->ime }}</li>
@endforeach
```

### Uključivanje podview-ova - @include direktiva
`@include` služi za uključivanje drugih Blade pogleda u trenutni pogled:

```php
// uključi pogled 'shared.errors'
@include('shared.errors')

// prosljeđivanje dodatnih podataka
@include('view.name', ['status' => 'active'])

// uključi ako postoji
@includeIf('view.name', ['status' => 'active'])

// uključi ako je uvjet ispunjen
@includeWhen($errors->any(), 'shared.errors')
@includeUnless($errors->any(), 'shared.success')

// uključi prvi koji postoji
@includeFirst(['custom.admin', 'admin'], ['status' => 'active'])
```

### Blade forme i CSRF zaštita
Laravel automatski generira CSRF token za svaku aktivnu korisničku sesiju. Ovaj token se koristi za provjeru da je autenticirani korisnik osoba koja zapravo šalje zahtjeve.

```php
<form method="POST" action="/profil">
    @csrf  <!-- generira skriveno polje s CSRF tokenom -->
    
    <input type="text" name="ime" value="{{ old('ime') }}">
    <button type="submit">Spremi</button>
</form>

// Za druge HTTP metode
<form method="POST" action="/profil/{{ $id }}">
    @csrf
    @method('PUT')  <!-- generira skriveno _method polje -->
    ...
</form>

// moguće metode: PUT, PATCH, DELETE
```

### Rad s greškama validacije
Laravel automatski dijeli greške validacije sa svim pogledima:

```php
<!-- prikaz svih grešaka -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Prikaz greške za specifično polje -->
@error('email')
    <span class="invalid-feedback">{{ $message }}</span>
@enderror

<!-- Dodavanje CSS klase ako ima greške -->
<input type="email" 
       name="email" 
       class="form-control @error('email') is-invalid @enderror"
       value="{{ old('email') }}">
```

### old() helper funkcija
Čuva stare vrijednosti nakon neuspješne validacije:

```php
<!-- osnovno korištenje -->
<input type="text" name="ime" value="{{ old('ime') }}">

<!-- sa zadanom vrijednošću -->
<input type="text" name="ime" value="{{ old('ime', $korisnik->ime) }}">

<!-- za select -->
<select name="grad">
    <option value="zagreb" {{ old('grad') == 'zagreb' ? 'selected' : '' }}>
        Zagreb
    </option>
    <option value="split" {{ old('grad') == 'split' ? 'selected' : '' }}>
        Split
    </option>
</select>

<!-- za checkbox -->
<input type="checkbox" 
       name="newsletter" 
       {{ old('newsletter') ? 'checked' : '' }}>

<!-- za radio -->
<input type="radio" 
       name="spol" 
       value="m" 
       {{ old('spol') == 'm' ? 'checked' : '' }}>
```

### @class i @style direktive
Za dinamičko dodavanje CSS klasa i stilova (Laravel 9+):

```php
@php
    $isActive = true;
    $hasError = false;
@endphp

<div @class([
    'p-4',
    'font-bold' => $isActive,
    'text-gray-500' => !$isActive,
    'bg-red' => $hasError,
])>
    Sadržaj
</div>

<div @style([
    'background-color: red',
    'font-weight: bold' => $isActive,
])>
    Sadržaj
</div>
```

### Blade nasljeđivanje (Layouts)
Jedan od najvećih problema u izradi web stranica je ponavljanje koda. Svaka stranica obično ima isti header, navigaciju i footer. Bilo bi grozno da to moramo kopirati u svaku datoteku.

Blade ovo rješava elegantno kroz nasljeđivanje predložaka (template inheritance).

1. kreiranje glavnog Layouta
- u `resources/views/` kreiramo novi direktorij `layouts`
- unutar njega, kreiramo datoteku `app.blade.php` koja će biti naš "okvir"

```html
<!DOCTYPE html>
<html>
<head>
    <title>Moja Aplikacija - @yield('title')</title>
    
    <!-- stack za dodatne CSS datoteke -->
    @stack('styles')
</head>
<body>
    <header>
        <h1>Glavna navigacija</h1>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2024 Moja Tvrtka</p>
    </footer>
    
    <!-- stack za JavaScript -->
    @stack('scripts')
</body>
</html>
```

- ključna je `@yield('ime_sekcije')` direktiva koja definira "rupu" ili "utor" koji će podređeni pogledi popuniti svojim sadržajem

### Proširivanje (Extending) Layouta
- sada `home.blade.php` ne mora sadržavati sav HTML, već samo proširuje glavni layout i definira sadržaj za "utore"
```php
<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Početna stranica')

@section('content')
    <h2>Dobrodošli na našu početnu stranicu!</h2>
    <p>Ovo je sadržaj specifičan samo za ovu stranicu.</p>
@endsection

@push('scripts')
    <script src="/js/home-page.js"></script>
@endpush
```

- `@extends('layouts.app')` - govori Bladeu da koristi `app.blade.php` iz layouts direktorija kao svoj okvir

- `@section('title', '...')` - definira sadržaj za `@yield('title')` utor

- `@section('content') ... @endsection` - definira glavni sadržaj za `@yield('content')` utor

### @parent direktiva
Omogućava dodavanje sadržaja postojećoj sekciji:

```php
<!-- u layoutu -->
@section('sidebar')
    <h3>Glavna navigacija</h3>
@show

<!-- u pogledu koji nasljeđuje -->
@section('sidebar')
    @parent  <!-- zadržava sadržaj iz layouta -->
    <h4>Dodatna navigacija</h4>
@endsection
```

- `@show` - koristite u glavnom layoutu da biste definirali sekciju koja ima neki početni, zadani sadržaj, a koju onda u podređenim pogledima možete ili potpuno zamijeniti ili elegantno nadopuniti pomoću `@parent`

### Blade komponente
Nasljeđivanje je odlično za strukturu cijele stranice, ali postoji problem ponavljanja manjih komponenata poput gumba, kartica (cards), modala ili poruka o grešci. Za to koristimo Blade komponente.

#### Klasične komponente (Class-based)
Laravel omogućava kreiranje komponenti kao PHP klasa:

```bash
# kreiranje komponente preko Artisan komande
php artisan make:component Alert
```

Ovo kreira dva fajla:
- `app/View/Components/Alert.php` - PHP klasa
- `resources/views/components/alert.blade.php` - Blade predložak

```php
// app/View/Components/Alert.php
namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type;
    public $message;

    public function __construct($type = 'info', $message = '')
    {
        $this->type = $type;
        $this->message = $message;
    }

    public function render()
    {
        return view('components.alert');
    }
    
    // dodatne metode dostupne u pogledu
    public function alertClass()
    {
        return [
            'info' => 'alert-info',
            'danger' => 'alert-danger',
            'success' => 'alert-success',
        ][$this->type] ?? 'alert-info';
    }
}
```

#### Anonimne komponente
- kreiranje i korištenje komponente
    - u `resources/views/` kreiramo novi direktorij `components`
    - unutar njega, kreiramo datoteku za našu komponentu, npr. `alert.blade.php`

```php
<!-- resources/views/components/alert.blade.php -->
@props(['type' => 'info', 'message'])

@php
    $classes = [
        'info' => 'background-color: lightblue; border: 1px solid blue;',
        'danger' => 'background-color: lightcoral; border: 1px solid red;',
        'success' => 'background-color: lightgreen; border: 1px solid green;',
    ];
@endphp

<div style="{{ $classes[$type] }} padding: 15px; margin-bottom: 20px;">
    <strong>Upozorenje!</strong> {{ $message }}
</div>
```

- `@props([...])` - definira koje "atribute" (podatke) naša komponenta očekuje (ovdje očekujemo type (sa zadanom vrijednošću 'info') i message)

- korištenje komponente u bilo kojem pogledu
    - sada možemo koristiti našu komponentu kao da je standardni HTML tag, s prefiksom x-
```html
<x-alert type="danger" message="Došlo je do greške prilikom spremanja." />
<x-alert message="Vaš profil je uspješno ažuriran." />
```
- prvi primjer će prikazati crvenu poruku, a drugi plavu (jer koristi zadanu info vrijednost)

#### Proslijeđivanje atributa
Komponente mogu automatski proslijediti HTML atribute:

```php
<!-- u komponenti -->
@props(['type' => 'info'])

<div {{ $attributes->merge(['class' => 'alert alert-' . $type]) }}>
    {{ $slot }}
</div>
```
```php
<!-- korištenje komponente -->
<x-alert type="danger" class="mt-4" id="main-alert">
    Poruka
</x-alert>
<!-- rezultat: <div class="alert alert-danger mt-4" id="main-alert"> -->
```

### Slotovi i Stackovi

#### Slotovi (Slots)
Slotovi služe kako bi naša komponenta mogla primiti cijele komade html koda.

1. zadani (Default) Slot
- svaka komponenta ima jedan zadani, neimenovani slot - to je sav sadržaj koji stavite unutar x- tagova

- prilagodimo našu alert komponentu da koristi slot
```php
<!-- resources/views/components/alert.blade.php -->
@props(['type' => 'info'])
...
<div style="...">
    {{ $slot }} <!-- Ovdje će se ubaciti HTML -->
</div>
```

- sada je možemo koristiti ovako
```html
<x-alert type="danger">
    <h4>Došlo je do greške!</h4>
    <p>Molimo provjerite unesene podatke.</p>
</x-alert>
```

- sav HTML unutar <x-alert> tagova bit će umetnut na mjesto {{ $slot }} varijable

2. imenovani Slotovi (Named Slots)
- ponekad komponenta treba više "utora" npr. kartica (card) može imati naslov i tijelo
```php
<!-- resources/views/components/card.blade.php -->
<div style="border: 1px solid #ccc; padding: 15px;">
    <h1>{{ $title }}</h1> <!-- Imenovani slot za naslov -->
    <hr>
    <div>
        {{ $slot }} <!-- Zadani slot za glavni sadržaj -->
    </div>
    @isset($footer)
    <footer>
        {{ $footer }} <!-- Imenovani slot za podnožje -->
    </footer>
    @endisset
</div>
```

- koristimo je ovako
```html
<x-card>
    <x-slot:title>
        Naslov kartice
    </x-slot>

    <x-slot:footer>
        Ovo je podnožje kartice.
    </x-slot>

    <!-- Sve ostalo ide u zadani slot -->
    <p>Ovo je glavni sadržaj kartice.</p>
</x-card>
```

#### Stackovi (Stacks)
Stackovi rješavaju problem dodavanja CSS-a ili JavaScripta iz podređenog pogleda u <head> ili na kraj <body> taga glavnog layouta.

1. definiranje stacka u layoutu (`layouts/app.blade.php`)

```html
<head>
    ...
    @stack('styles') <!-- Mjesto za CSS -->
</head>
<body>
    ...
    @stack('scripts') <!-- Mjesto za JS -->
</body>
```

2. guranje sadržaja na stack iz pogleda
- recimo da samo naša stranica s galerijom treba posebnu JavaScript biblioteku
```php
<!-- resources/views/gallery.blade.php -->
@extends('layouts.app')

@section('content')
    ... sadržaj galerije ...
@endsection

@push('scripts')
    <script src="/js/gallery-plugin.js"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="/css/gallery.css">
@endpush
```
- `@push` će odraditi ubacivanje plugina na stranicu
- sada će se `gallery-plugin.js` učitati samo na ovoj stranici i bit će ispravno smješten na dnu <body> taga, kako je definirano u glavnom layoutu

- `@prepend` - dodaje sadržaj na početak stacka
```php
@prepend('scripts')
    <script>
        // ovaj kod će biti prvi u stacku
        console.log('Učitavam prvi');
    </script>
@endprepend
```

- `@once` - osigurava da se sadržaj doda samo jednom
```php
@once
    @push('scripts')
        <script src="/js/analytics.js"></script>
    @endpush
@endonce
```

### PHP kod u Blade predlošcima
Iako Blade omogućava pisanje čistog PHP koda, treba ga koristiti minimalno:

```php
@php
    $counter = 1;
    $maxItems = 10;
    // kompleksnija logika
    $formattedDate = Carbon::parse($date)->format('d.m.Y');
    $isWeekend = Carbon::parse($date)->isWeekend();
@endphp
```

### Komentari u Blade-u
```php
{{-- Ovo je Blade komentar koji se neće prikazati u HTML-u --}}

<!-- Ovo je HTML komentar koji će biti vidljiv u pregledniku -->
```

### Prilagođene Blade direktive
Možete kreirati vlastite Blade direktive u service provideru:

```php
// u AppServiceProvider boot() metodi
use Illuminate\Support\Facades\Blade;

Blade::directive('datetime', function ($expression) {
    return "<?php echo ($expression)->format('d.m.Y H:i'); ?>";
});

// korištenje
@datetime($user->created_at)
```

### Najbolje prakse

1. **Držite logiku van pogleda** - sva poslovna logika treba biti u kontrolerima ili servisima
2. **Koristite komponente** - za elemente koji se ponavljaju
3. **Organizirajte poglede** - koristite poddirektorije za grupiranje povezanih pogleda
4. **Imenujte dosljedno** - koristite snake_case ili kebab-case za nazive datoteka
5. **Minimizirajte PHP u pogledima** - koristite Blade direktive umjesto čistog PHP-a
6. **Korištenje @forelse** - uvijek kad iterirate kroz kolekciju koja može biti prazna
7. **Escapajte output** - koristite {{ }} osim ako niste 100% sigurni da je sadržaj siguran

### Debugging pogleda
Za lakše otkrivanje grešaka:

```php
// prikaži sve dostupne varijable
{{ dd(get_defined_vars()['__data']) }}

// dump varijablu bez zaustavljanja
@dump($varijabla)

// dump i die
@dd($varijabla)
```

# Autentikacija i Autorizacija u Laravelu

## Što je autentikacija?
Autentikacija je proces provjere identiteta korisnika - odgovaramo na pitanje "Tko si ti?". U web aplikacijama to najčešće znači provjeru korisničkog imena i lozinke. Nakon uspješne autentikacije, sustav "pamti" da je korisnik prijavljen kroz sesiju.

## Auth "fasada" i helperi
Laravel nudi Auth "fasadu" i `auth()` helper funkciju za rad s autentikacijom. Ove alate koristimo za provjeru je li korisnik prijavljen, dohvaćanje podataka o korisniku, prijavu i odjavu.

### Osnovne Auth metode
```php
use Illuminate\Support\Facades\Auth;

// provjera je li korisnik prijavljen
if (Auth::check()) {
    echo "Korisnik je prijavljen!";
}

// dohvaćanje trenutno prijavljenog korisnika
$user = Auth::user();
// ili kraće preko helper funkcije
$user = auth()->user();

// dohvaćanje ID-ja trenutnog korisnika
$userId = Auth::id();
$userId = auth()->id();

// provjera je li korisnik gost (nije prijavljen)
if (Auth::guest()) {
    echo "Molimo prijavite se";
}
```

## Login/Logout proces

### Ručna prijava korisnika
```php
// u LoginController.php
public function login(Request $request)
{
    // validacija podataka
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // pokušaj prijave
    if (Auth::attempt($credentials)) {
        // regeneracija sesije (sigurnosna mjera)
        $request->session()->regenerate();
        
        return redirect()->intended('dashboard');
    }

    // ako prijava nije uspjela
    return back()->withErrors([
        'email' => 'Podaci za prijavu nisu ispravni.',
    ])->onlyInput('email');
}
```

### Remember me funkcionalnost
```php
// drugi parametar u attempt() je za "remember me"
if (Auth::attempt($credentials, $request->boolean('remember'))) {
    // korisnik će ostati prijavljen duže vrijeme
}
```

### Odjava korisnika
```php
// U LogoutController.php
public function logout(Request $request)
{
    Auth::logout();
    
    // invalidacija sesije
    $request->session()->invalidate();
    
    // regeneracija CSRF tokena
    $request->session()->regenerateToken();
    
    return redirect('/');
}
```

### Prijava specifičnog korisnika (korisno za testiranje)
```php
// prijava User objekta
$user = User::find(1);
Auth::login($user);

// prijava prema ID-ju
Auth::loginUsingId(1);

// prijava samo za ovaj zahtjev (bez sesije)
Auth::once($credentials);
```

## Middleware "auth"
Middleware "auth" automatski provjerava je li korisnik prijavljen prije nego što mu dopusti pristup određenoj ruti ili grupi ruta.

### Korištenje u rutama
```php
// routes/web.php

// pojedinačna ruta
Route::get('/profil', function () {
    // samo prijavljeni korisnici mogu pristupiti
    return view('profil');
})->middleware('auth');

// grupa ruta
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/settings', [SettingsController::class, 'index']);
    Route::post('/settings', [SettingsController::class, 'update']);
});

// na kontroleru
Route::resource('posts', PostController::class)->middleware('auth');
```

### Korištenje u kontroleru
```php
class PostController extends Controller
{
    public function __construct()
    {
        // zaštiti sve metode
        $this->middleware('auth');
        
        // ili samo specifične metode
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update']);
        
        // sve osim navedenih
        $this->middleware('auth')->except(['index', 'show']);
    }
}
```

### Preusmjeravanje neprijavljenih korisnika
Kada neprijavljeni korisnik pokuša pristupiti zaštićenoj ruti, automatski se preusmjerava na login stranicu. Nakon uspješne prijave, vraća se na originalnu stranicu koju je htio posjetiti.

```php
// možete prilagoditi gdje se korisnik preusmjerava u 
// app/Http/Middleware/Authenticate.php
protected function redirectTo($request)
{
    if (!$request->expectsJson()) {
        return route('login');
    }
}
```

## Blade direktive za autentikaciju
Blade nudi korisne direktive za provjeru statusa autentikacije direktno u pogledima.

```php
{{-- Prikaži samo prijavljenim korisnicima --}}
@auth
    <p>Dobrodošli, {{ auth()->user()->name }}!</p>
    <form method="POST" action="/logout">
        @csrf
        <button type="submit">Odjava</button>
    </form>
@endauth

{{-- Prikaži samo gostima (neprijavljenima) --}}
@guest
    <a href="/login">Prijavite se</a>
    <a href="/register">Registrirajte se</a>
@endguest

{{-- Kombinacija auth i guest --}}
@auth
    <li>Moj profil</li>
    <li>Postavke</li>
@else
    <li>Login</li>
    <li>Registracija</li>
@endauth
```

# Autorizacija

## Razlika između autentikacije i autorizacije
- **Autentikacija** odgovara na pitanje: "Tko si ti?" (provjera identiteta)
- **Autorizacija** odgovara na pitanje: "Što smiješ raditi?" (provjera dozvola)

Primjer: Svi prijavljeni korisnici su autenticirani, ali samo vlasnik posta smije ga uređivati ili brisati (autorizacija).

## Gates (Vrata)
Gates su jednostavan način definiranja autorizacijskih pravila. Definiramo ih u `AuthServiceProvider` klasi i koristimo kroz aplikaciju.

### Definiranje Gate-a
```php
// app/Providers/AuthServiceProvider.php
use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Models\User;

public function boot()
{
    // jednostavan gate - provjerava je li korisnik admin
    Gate::define('admin-access', function (User $user) {
        return $user->role === 'admin';
    });
    
    // gate s parametrom - provjerava može li korisnik urediti post
    Gate::define('edit-post', function (User $user, Post $post) {
        return $user->id === $post->user_id;
    });
    
    // gate s više uvjeta
    Gate::define('delete-post', function (User $user, Post $post) {
        // admin može obrisati bilo koji post
        if ($user->role === 'admin') {
            return true;
        }
        
        // vlasnik može obrisati svoj post
        return $user->id === $post->user_id;
    });
}
```

### Korištenje Gate-a u kontroleru
```php
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function edit(Post $post)
    {
        // metoda 1 - provjera s if
        if (Gate::allows('edit-post', $post)) {
            return view('posts.edit', compact('post'));
        }
        
        abort(403, 'Nemate dozvolu za uređivanje ovog posta.');
    }
    
    public function update(Request $request, Post $post)
    {
        // metoda 2 - direktno odbacivanje ako nema dozvole
        Gate::authorize('edit-post', $post);
        
        // ako je prošlo, nastavi s update logikom
        $post->update($request->validated());
        
        return redirect()->route('posts.show', $post);
    }
    
    public function destroy(Post $post)
    {
        // metoda 3 - korištenje deny() za provjeru
        if (Gate::denies('delete-post', $post)) {
            abort(403);
        }
        
        $post->delete();
        return redirect()->route('posts.index');
    }
}
```

### Korištenje Gate-a u Blade pogledima
```php
{{-- Prikaži link samo ako korisnik ima dozvolu --}}
@can('edit-post', $post)
    <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary">
        Uredi post
    </a>
@endcan

@can('delete-post', $post)
    <form method="POST" action="{{ route('posts.destroy', $post) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Obriši</button>
    </form>
@endcan

{{-- Suprotno od @can --}}
@cannot('edit-post', $post)
    <p>Nemate dozvolu za uređivanje ovog posta.</p>
@endcannot

{{-- Za gate bez parametara --}}
@can('admin-access')
    <a href="/admin">Admin panel</a>
@endcan
```

## Policies (Politike)
Policies su klase koje grupiraju autorizacijsku logiku za određeni model. Idealne su kada imate više autorizacijskih pravila za isti resurs.

### Kreiranje Policy klase
```bash
# kreiranje policy za Post model
php artisan make:policy PostPolicy --model=Post
```

### Definiranje Policy metoda
```php
// app/Policies/PostPolicy.php
namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    // može li korisnik vidjeti sve postove
    public function viewAny(User $user): bool
    {
        // svi prijavljeni korisnici mogu vidjeti listu
        return true;
    }

    // može li korisnik vidjeti specifičan post
    public function view(User $user, Post $post): bool
    {
        // svi mogu vidjeti objavljene, samo autor može vidjeti draftove
        return $post->published || $user->id === $post->user_id;
    }

    // može li korisnik kreirati post
    public function create(User $user): bool
    {
        // samo verificirani korisnici
        return $user->email_verified_at !== null;
    }

    // može li korisnik urediti post
    public function update(User $user, Post $post): bool
    {
        // samo vlasnik može urediti post
        return $user->id === $post->user_id;
    }

    // može li korisnik obrisati post
    public function delete(User $user, Post $post): bool
    {
        // vlasnik ili admin
        return $user->id === $post->user_id || $user->role === 'admin';
    }
    
    // "Super admin" provjera - ako vrati true, sve ostale metode se preskaču
    public function before(User $user): bool|null
    {
        if ($user->role === 'super-admin') {
            return true;
        }
        
        return null; // nastavi s normalnom provjerom
    }
}
```

### Registriranje Policy
Laravel automatski povezuje Policy s modelom ako slijede konvenciju imenovanja. Ako ne, ručno ih registrirajte:

```php
// app/Providers/AuthServiceProvider.php
protected $policies = [
    Post::class => PostPolicy::class,
];
```

### Korištenje Policy u kontroleru
```php
class PostController extends Controller
{
    public function index()
    {
        // provjeri može li vidjeti sve
        $this->authorize('viewAny', Post::class);
        
        return view('posts.index', [
            'posts' => Post::all()
        ]);
    }
    
    public function show(Post $post)
    {
        // provjeri može li vidjeti ovaj post
        $this->authorize('view', $post);
        
        return view('posts.show', compact('post'));
    }
    
    public function create()
    {
        // provjeri može li kreirati
        $this->authorize('create', Post::class);
        
        return view('posts.create');
    }
    
    public function edit(Post $post)
    {
        // provjeri može li urediti
        $this->authorize('update', $post);
        
        return view('posts.edit', compact('post'));
    }
    
    public function destroy(Post $post)
    {
        // provjeri može li obrisati
        $this->authorize('delete', $post);
        
        $post->delete();
        
        return redirect()->route('posts.index');
    }
}
```

### Korištenje Policy u Blade pogledima
```php
{{-- @can direktiva automatski koristi policy --}}
@can('create', App\Models\Post::class)
    <a href="{{ route('posts.create') }}">Novi post</a>
@endcan

@can('update', $post)
    <a href="{{ route('posts.edit', $post) }}">Uredi</a>
@endcan

@can('delete', $post)
    <form method="POST" action="{{ route('posts.destroy', $post) }}">
        @csrf
        @method('DELETE')
        <button type="submit">Obriši</button>
    </form>
@endcan

{{-- možete provjeriti više dozvola odjednom --}}
@canany(['update', 'delete'], $post)
    <div class="admin-tools">
        <!-- prikaži admin alate -->
    </div>
@endcanany
```

# Migracije i Seederi

Što su migracije?

Migracije su sustav za kontrolu verzija vaše baze podataka, baš kao što je Git za vaš kod. Umjesto da ručno klikate i stvarate tablice u nekom alatu poput phpMyAdmina, vi sve promjene definirate u PHP datotekama.

One olakšavaju timski rad - kada novi programer dođe na projekt, ne morate mu slati SQL datoteku. On samo preuzme kod s Gita, pokrene jednu naredbu i migracije automatski izgrade identičnu strukturu baze podataka kakvu ima i ostatak tima.

## Kreiranje migracije
Sve se radi putem artisan naredbi.

`php artisan make:migration create_posts_table`

Laravel nam nudi korisne prečace:

`--create=products` → generira migraciju s kodom za kreiranje nove tablice products

`--table=posts` → generira migraciju s kodom za izmjenu postojeće tablice posts

`--path=database/migrations/extra` → sprema migraciju u neki drugi folder po vašem izboru (u ovom slučaju `database/migrations/extra`)

## Struktura migracije
Svaka migracijska datoteka ima dvije ključne metode: `up()` i `down()`.
```php
// database/migrations/2025_08_30_100000_create_posts_table.php
public function up(): void
{
    // ovdje ide kod za primjenu promjene
    Schema::create('posts', function (Blueprint $table) {
        $table->id(); // auto-incrementing BigInt primary key
        $table->string('title');
        $table->text('content');
        $table->timestamps(); // kreira created_at i updated_at stupce
    });
}

public function down(): void
{
    // ovdje ide kod za poništavanje promjene
    Schema::dropIfExists('posts');
}
```
- `up()` - izvršava se kada pokrenete php artisan migrate
  - ovdje definirate što želite napraviti (stvoriti tablicu, dodati stupac)

- `down()` - izvršava se kada pokrenete `php artisan migrate:rollback`
  - ovdje definirate suprotnu operaciju kako biste se mogli vratiti na stanje prije migracije

Redoslijed izvršavanja migracija određuje se vremenom (timestampom) u nazivu datoteke.

## Izmjena postojeće tablice
Kada koristimo `--table` opciju, Laravel generira migraciju koja koristi `Schema::table()` umjesto `Schema::create()`. Ovo nam omogućuje dodavanje, izmjenu ili brisanje postojećih stupaca.
```php
// migracija generirana s: php artisan make:migration add_is_active_to_users_table --table=users

public function up(): void
{
    // koristimo Schema::table() za izmjenu postojeće tablice 'users'
    Schema::table('users', function (Blueprint $table) {
        // dodajemo novi boolean stupac 'is_active' nakon stupca 'email'
        $table->boolean('is_active')->default(true)->after('email');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        // u 'down' metodi, radimo suprotnu operaciju - brišemo stupac
        $table->dropColumn('is_active');
    });
}
```

## Pokretanje migracija
Glavna naredba koju ćete koristiti: `php artisan migrate`

Laravel će provjeriti koje migracije još nisu izvršene i pokrenut će njihove `up()` metode.

## Povratne naredbe (Rollback)
`migrate:rollback` - poništava zadnju "seriju" (batch) izvršenih migracija

`migrate:reset` - poništava SVE migracije, pokrećući `down()` metodu za svaku

`migrate:refresh` - poništava sve migracije i odmah ih ponovno pokreće

`migrate:fresh` - najčešće korištena naredba u razvoju
  - ona ne pokreće `down()` metode
  - ona jednostavno obriše sve tablice iz baze i onda pokrene sve migracije od početka
  - brža je i čišća

`php artisan migrate:fresh --seed` - nakon što kreira bazu, odmah je i popuni s podacima iz seeder-a

## Schema builder – dodatne mogućnosti
Provjere:

`Schema::hasTable('users')` - provjerava postoji li tablica

`Schema::hasColumn('users', 'email')` - provjerava postoji li stupac

Indeksi i strani ključevi:
```php
$table->string('email')->unique(); // jedinstveni indeks
$table->index(['state', 'city']); // obični indeks preko više stupaca
$table->foreign('user_id')->references('id')->on('users'); // strani ključ
```

Posebne opcije:

`Schema::disableForeignKeyConstraints()` - privremeno isključuje provjeru stranih ključeva, korisno kod brisanja podataka

`Schema::defaultStringLength(191)` - stavlja se u AppServiceProvider i rješava problem s indeksom na starijim verzijama MySQL-a

# Što su Seederi?

Svrha
  - početni podaci - popunjavanje baze s podacima nužnim za rad aplikacije (npr. popis država, kategorije proizvoda, administratorski korisnik)
  - testni podaci - generiranje velike količine lažnih podataka (npr. 1000 korisnika, 5000 članaka) kako biste mogli testirati performanse i izgled aplikacije u realnim uvjetima

## Kreiranje Seedera
`php artisan make:seeder UserSeeder`

- ovo kreira datoteku `database/seeders/UserSeeder.php`

## Struktura Seedera
```php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // koristimo Query Builder za unos osnovnih podataka
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
```
- unutar `run()` metode pišemo logiku za unos podataka - možemo koristiti Query Builder (`DB::table(...)`) ili Eloquent modele

## Model Factory (Tvornice modela)
Za generiranje velike količine lažnih podataka, koristimo Factoryje.

Laravel koristi odličan paket Faker za generiranje lažnih podataka.
```php
// u database/factories/UserFactory.php (već postoji)
public function definition(): array
{
    return [
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'email_verified_at' => now(),
        'password' => static::$password ??= Hash::make('password'),
        'remember_token' => Str::random(10),
    ];
}

// u seederu - kreiraj 10 lažnih korisnika pomoću factoryja
// ...
use App\Models\User;
// ...
User::factory(10)->create();
```

## Pokretanje Seedera
Pokreće SAMO navedeni seeder
`php artisan db:seed --class=UserSeeder`

Pokreće SVE seeder-e navedene u DatabaseSeeder.php
`php artisan db:seed`

Glavna datoteka je `database/seeders/DatabaseSeeder.php`. Unutar njene `run()` metode, pozivate ostale seedere koje želite pokrenuti:
```php
public function run(): void
{
    $this->call([
        UserSeeder::class,
        PostSeeder::class,
    ]);
}
```

# Eloquent ORM i Relacije

## Uvod u Eloquent – modeli i osnovne operacije

### ORM i Eloquent
- **ORM (Object‑Relational Mapping)** - omogućava nam rad s bazom kroz PHP objekte umjesto sirovog SQL‑a (isti koncept dostupan i svim popularnim jezicima)
- **Eloquent** - Laravelova implementacija ORM‑a - analogija pametnog asistenta za dohvat i manipulaciju podataka

### Kreiranje modela
```bash
php artisan make:model Post
php artisan make:model Post -m // dodaje i migraciju
```
- u Laravelu se modeli po defaultu generiraju u `app/Models/`
- **Zaštita mass assignment‑a** - modeli su zaštićeni prema defaultu
    - prije `create()` definiraj `protected $fillable = [...]` ili `protected $guarded = [...]`

### Mass assignment
Mass assignment ili masovno dodjeljivanje je mogućnost koju nam Eloquent pruža, a služi kako bismo kreirali ili ažurirali model (redak u bazi) slanjem cijelog polja (array) podataka odjednom, umjesto da postavljamo svaku vrijednost pojedinačno.

```php
// bez mass assignmenta
$post = new Post;
$post->title = $request->input('title');
$post->content = $request->input('content');
$post->save();

// s mass assignmentom
Post::create($request->all());
```

Mass assignment predstavlja sigurnosni rizik jer uopće ne provjerava korisnikov unos i on može u samu formu dodati polja koja mi uopće nismo predvidjeli u toj formi.

Primjer:
- vi očekujete da će korisnik poslati podatke `['ime' => 'Pero', 'prezime' => 'Perić']`
- zlonamjeran korisnik će koristeći alate u pregledniku u formu dodati još jedno skriveno polje i poslati vam podatke `['ime' => 'Pero', 'prezime' => 'Perić', 'is_admin' => '1']`

Medutim, Laravel po defaultu zabranjuje mass assignment tako da ako pokušate primjeniti npr. `Post::create($request->all())`, dobit ćete grešku.

Ako želimo omogućiti mass assignment, moramo Laravelu dati do znanja koja polja u modelu su dozvoljena za mass assignment. To radimo pomoću `$fillable` (definira koja su polja dozvoljena za mass assignment) i `$guarded` (definira koja su polja zabranjena za mass assignment) polja u modelu.

```php
// app/Models/User.php
class User extends Model
{
    protected $fillable = [
      'ime',
      'prezime',
      'email',
      'password',
    ];

    protected $guarded = [
      'is_admin',
    ];
}
```

`$fillable` je sigurniji pristup ("safe by default"). Ako sutra u bazu dodate novi osjetljivi stupac (npr. stanje_racuna) i zaboravite ga dodati na `$guarded` listu, stvorili ste sigurnosni propust. S `$fillable` pristupom, novi stupac automatski nije dozvoljen dok ga vi svjesno ne dodate na listu.

Preporuka je koristiti samo `$fillable` polje jer sva polja koja nisu dodana u `$fillable` polje, automatski su zaštićena od mass assignmenta i time sprječavamo bilo kakav sigurnosni propust.
Dakle, sva polja koja nisu u `$fillable`, dodana su u `$guarded`.

Primjer: (koristimo samo `$fillable`) - ako sutra dodamo polje `is_admin` u našu tablicu `users` i zaboravimo izmjeniti kod u `User.php`, neće se desiti apsolutno ništa.

Primjer 2: (koristimo samo `$guarded`) - ako sutra dodamo polje `is_admin` u našu tablicu `users` i zaboravimo izmjeniti kod u `User.php`, otvaramo sigurnosni propust i mogla bi se desiti greška koja bi nas mogla koštati tužbe, krade podataka, ucjene...

### Napredne konfiguracije modela
```php
protected $table = 'my_posts';
protected $primaryKey = 'post_id';
public $incrementing = false;
protected $keyType = 'string';
public $timestamps = false;
// ili:
const CREATED_AT = 'creation_date';
const UPDATED_AT = 'last_changed';
use HasUuids;
use HasUlids;
```
`protected $table = 'my_posts';`
- Laravelova pretpostavka - ako se vaš model zove `Post`, Laravel pretpostavlja da se tablica u bazi zove `posts` (množina, mala slova, tzv. "snake_case")
- zašto biste ovo mijenjali? Zato što vaša postojeća tablica u bazi možda ima drugačije ime, npr. naslijedili ste stari projekt i tablica se zove my_posts ili tbl_postovi. Ovom linijom vi eksplicitno kažete Eloquentu: "Zanemari svoje pravilo, tablica za ovaj model se zove 'my_posts'."

`protected $primaryKey = 'post_id';`
- Laravelova pretpostavka - svaka tablica ima primarni ključ (identifikator) koji se zove id
- zašto biste ovo mijenjali? Vaš primarni ključ u tablici se možda zove post_id, PostID ili nešto treće. Ovom linijom govorite Eloquentu koji stupac treba koristiti kao jedinstveni identifikator

`public $incrementing = false; i protected $keyType = 'string';` (ove dvije linije idu zajedno)
- Laravelova pretpostavka - primarni ključ (id) je broj (integer) koji se automatski povećava (1, 2, 3, 4...)
- zašto biste ovo mijenjali? Ponekad ne želite koristiti brojeve kao ID. Moderni pristup je često korištenje UUID-a (Universally Unique Identifier). To je dugačak, nasumičan string poput a1b2c3d4-e5f6-7890-1234-567890abcdef
- ako vaš primarni ključ nije broj koji se povećava, morate reći Laravelu:
    - `public $incrementing = false;` - "Nemoj pokušavati povećavati ovaj ključ jer nije broj!"
    - `protected $keyType = 'string';` - "Ovaj ključ je tipa string."

`public $timestamps = false;`
- Laravelova pretpostavka - vaša tablica ima dva posebna stupca: `created_at` i `updated_at` - Laravel će automatski popunjavati i ažurirati te stupce svaki put kad kreirate ili izmijenite redak
- zašto biste ovo mijenjali? Možda imate tablicu u koju samo upisujete podatke koji se nikad ne mijenjaju (npr. popis država) i vremenske oznake vam jednostavno ne trebaju. Ovom linijom kažete Eloquentu: "Nemoj se brinuti oko `created_at` i `updated_at` stupaca za ovaj model, oni ne postoje."

`const CREATED_AT = '...';` i `const UPDATED_AT = '...';`
- Laravelova pretpostavka - stupci za vremenske oznake se zovu točno `created_at` i `updated_at`
- zašto biste ovo mijenjali? U vašoj postojećoj bazi, ti stupci se možda zovu `creation_date` i `last_changed`. Ovim konstantama vi samo preslikavate Laravelova interna imena na stvarna imena stupaca u vašoj tablici

`use HasUuids;`
- ovo je moderan i elegantan prečac koji zamjenjuje neke od gornjih postavki
- ovo su tzv. traitovi - kada dodate `use HasUuids;` na vrh svog modela, Laravel će automatski napraviti nekoliko stvari za vas:
    - postavit će `$incrementing = false;`
    - postavit će `$keyType = 'string';`
- svaki put kad budete kreirali novi model - `Post::create(...)`, Laravel će automatski generirati novi UUID i spremiti ga kao primarni ključ

`use HasUlids;`
- ne morate se više brinuti o ručnom generiranju ID-jeva. HasUlids radi sličnu stvar kao HasUuids, samo generira ULID-ove, koji su slični UUID-ovima ali se mogu sortirati po vremenu

Zaključak: sva ova svojstva služe da biste preformulirali Laravelove zadane pretpostavke i prilagodili svoj Eloquent model točnoj strukturi vaše tablice u bazi podataka, pogotovo kada radite s bazama koje niste vi originalno dizajnirali.

### CRUD operacije
```php
Post::create([...]); // kreiranje novog zapisa u bazi - zahtijeva fillable/guarded
$post = Post::find(1); // dohvaćanje podataka - id proslijeden u find metodu - u ovom slučaju broj 1
$post = Post::findOrFail(1);
$post->title = 'Novi'; // ažuriranje dohvaćenih podataka
$post->save(); // spremanje ažuriranih podataka
$post->delete(); // brisanje dohvaćenog zapisa
Post::updateOrCreate(['id'=>1], ['title'=>'...', 'author' => '...']); // ažuriranje postojećeg ili spremanje novog zapisa u bazu
```
- `updateOrCreate()` - prima dva niza - kriterij i vrijednosti
- `findOrFail()` - baca 404 ako model nije pronađen

#### Kreiranje (Create)
- prvi način - `new` i `save()`
```php
$post = new Post;
$post->title = 'Moj prvi članak';
$post->content = 'Ovo je sadržaj...';
$post->save(); // Sprema u bazu
```
- drugi način - `create()` (mass assignment)
    - zahtijeva da u Post modelu imamo definirano `$fillable` ili `$guarded` polje
```php
// zahtijeva da su 'title' i 'content' u $fillable polju
$post = Post::create([
    'title' => 'Moj drugi članak',
    'content' => 'Novi sadržaj...'
]);
```

#### Čitanje (Read)
Ovdje Eloquent najviše sjaji.
- dohvaćanje jednog modela
```php
// pronađi post po primarnom ključu (npr. id = 1)
$post = Post::find(1);

// isto kao find(), ali baci 404 grešku ako post ne postoji (idealno za kontrolere)
$post = Post::findOrFail(1);

// pronađi prvi post koji zadovoljava uvjet
$post = Post::where('is_published', true)->first();
```

- dohvaćanje više modela (kolekcije)
    - kada dohvatimo više modela, dobijemo poseban objekt - kolekciju - to je "super-niz" s puno korisnih metoda
```php
// dohvati SVE postove
$posts = Post::all();

// dohvati sve objavljene postove, sortirane po datumu
$posts = Post::where('is_published', true)
               ->orderBy('created_at', 'desc')
               ->get();

// dohvati 5 najnovijih postova
$latestPosts = Post::latest()->take(5)->get();

// dohvati postove čiji je autor 'Pero' ili 'Ana'
$posts = Post::whereIn('author', ['Pero', 'Ana'])->get();
```

- agregati
```php
$brojPostova = Post::count();
$najveciBrojPregleda = Post::max('views');
```

#### Ažuriranje (Update)
- prvi način - `find()` i `save()`
```php
$post = Post::findOrFail(1);
$post->title = 'Novi ažurirani naslov';
$post->save();
```

- drugi način - `update()` (mass assignment)
```php
$post = Post::findOrFail(1);
$post->update(['title' => 'Još noviji naslov']); // zahtijeva $fillable
```

- masovno ažuriranje - možemo ažurirati više redaka odjednom
```php
// objavimo sve postove koji su u statusu 'draft'
Post::where('status', 'draft')->update(['status' => 'published']);
```

- `updateOrCreate()` - izuzetno korisna metoda koja ili ažurira postojeći zapis ili kreira novi ako ne postoji
```php
// ako postoji post s naslovom 'Uvod', ažuriraj mu content
// ako ne postoji, kreiraj novi post s oba podatka
Post::updateOrCreate(
    ['title' => 'Uvod'],
    ['content' => 'Novi uvodni sadržaj...']
);
```
#### Brisanje (Delete)
- brisanje 1 modela
```php
$post = Post::findOrFail(1);
$post->delete();
```

- brisanje po ključu
```php
// obriši post s ID-om 1
Post::destroy(1);

// obriši više postova
Post::destroy(1, 2, 3);
```

- masovno brisanje
```php
// obriši sve neobjavljene postove starije od godinu dana
Post::where('is_published', false)
      ->where('created_at', '<', now()->subYear())
      ->delete();
```

### Kolekcije, chunking i cursors
- `Post::all()` ili `Post::where(...)->get()` vraća `Illuminate\Database\Eloquent\Collection` – moćan skup metoda
    - ta "kolekcija" dolazi s desecima super korisnih metoda koje vam omogućuju da elegantno manipulirate podacima nakon što ste ih dohvatili iz baze
```php
->filter() // filtriraj elemente

->map() // primijeni funkciju na svaki element

->pluck('title') // izvuci samo vrijednosti iz 'title' stupca

->sum('views') // zbroji sve preglede

->groupBy('author') // grupiraj postove po autoru
```

- `->chunk(200, fn($chunk) => ...)` - rješava problem memorije tako da dohvaća podatke iz baze u manjim "komadima" (chunks)
    - primjer: Umjesto da pokušate odjednom iznijeti 500,000 cigli iz kamiona, vi ih prenosite u kolicima, 200 po 200. Nakon što obradite jednu turu, vraćate se po sljedeću
```php
Post::chunk(200, function ($chunkOfPosts) {
    foreach ($chunkOfPosts as $post) {
      // obavi neku operaciju na svakom postu
    }
});
```

- Laravel će iz baze dohvatiti prvih 200 postova
- izvršit će vašu funkciju (closure) s tih 200 postova
- nakon što funkcija završi, Laravel "zaboravlja" tih 200 postova i oslobađa memoriju
- zatim se vraća u bazu i dohvaća sljedećih 200 postova (od 201 do 400)
- ponavlja proces sve dok ne prođe kroz sve postove
- ključna prednost - u bilo kojem trenutku, u memoriji imate samo 200 postova, a ne 500,000
- mana - izvršava više upita prema bazi (jedan za svaki "chunk")


`->cursor()` - obrada 1 po 1
- još efikasnija po pitanju memorije

- primjer: umjesto da koristite kolica (chunk) za cigle, vi ste na pokretnoj traci. Traka vam donosi jednu po jednu ciglu. Vi uzmete ciglu, obradite je i stavite sa strane. U ruci nikada nemate više od jedne cigle.
```php
foreach (Post::cursor() as $post) {
    // obavi neku operaciju na ovom jednom postu
}
```
- Laravel izvrši samo jedan upit prema bazi podataka
- ali, umjesto da sve rezultate odmah učita u PHP, on koristi mehanizam baze podataka koji mu omogućuje da iterira kroz rezultate jedan po jedan, bez da ih sve drži u memoriji
- ključna prednost - ovo je najštedljiviji način za rad s ogromnim skupovima podataka jer u memoriji imate samo jedan model u bilo kojem trenutku
- idealno za zadatke poput eksportiranja milijuna redaka u CSV datoteku

### Eloquent događaji
Eloquent događaji (events) su "kuke" ili "okidači" (eng. hooks) koji vam omogućuju da automatski izvršite neki kod u ključnim trenucima životnog ciklusa jednog modela.

To metode poput `creating`, `updating`, `saving`, `deleting` koje mogu presresti akcije na modelima.

Primjer: zamislite da imate pametnu kuću. Možete postaviti pravila: "TOČNO PRIJE nego što se ulazna vrata zaključaju, provjeri jesu li svi prozori zatvoreni." ili "ODMAH NAKON što se alarm upali, pošalji mi notifikaciju na mobitel."

Eloquent događaji rade na isti način. Vi postavljate "pravila" koja se izvršavaju prije ili poslije neke akcije u bazi podataka.

Najčešće se definiraju unutar booted metode samog modela. Laravel će automatski pozvati ovu metodu kada se model prvi put koristi.

#### Najvažniji događaji i njihova svrha
Postoji razlika između događaja koji završavaju na `-ing` (izvršavaju se PRIJE akcije) i onih koji završavaju na `-ed` (izvršavaju se NAKON akcije).

`creating / created`
- creating - okida se prije nego što se novi model spremi u bazu
    - idealno za postavljanje zadanih vrijednosti, generiranje slugova, UUID-ova itd.
- created - okida se nakon što je novi model spremljen u bazu
    - idealno za slanje notifikacija, logiranje aktivnosti, itd.

`updating / updated`
- updating - okida se prije nego što se postojeći model ažurira
- updated - okida se nakon što je model ažuriran

`saving / saved`
- ovo su općeniti događaji - saving se okida prije spremanja (i za kreiranje i za ažuriranje), a saved se okida nakon

`deleting / deleted`
- deleting - okida se prije nego što se model obriše - savršeno mjesto za brisanje povezanih datoteka (npr. korisnikovog avatara iz storage direktorija)
- deleted - okida se nakon što je model obrisan

```php
// app/Models/Post.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // potrebno za rad sa stringovima

class Post extends Model
{
    protected $fillable = ['title', 'content', 'slug'];

    protected static function booted(): void
    {
        // postavi događaj koji će se izvršiti TOČNO PRIJE kreiranja novog posta
        static::creating(function (Post $post) {
            // generiraj slug iz naslova
            $post->slug = Str::slug($post->title);
        });
    }
}
```

- kada u svom kodu napišete: `Post::create(['title' => 'Moj Novi Super Članak', 'content' => '...'])`, Eloquent pokrene proces kreiranja
- PRIJE nego što pošalje INSERT naredbu u bazu, on vidi da postoji creating događaj
- izvrši kod unutar te funkcije -> uzme naslov "Moj Novi Super Članak", pretvori ga u "moj-novi-super-clanak" i postavi ga kao vrijednost slug svojstva
- tek tada spremi model u bazu s popunjenim i title i slug poljem
- sve je potpuno automatizirano, a naši kontroleri ostaju čisti i ne moraju se brinuti o generiranju slugova

## Relacije među modelima
Relacije u Eloquentu su način na koji "učimo" naše modele kako su međusobno povezani. To nam omogućuje da pišemo čist i čitljiv kod za dohvaćanje povezanih podataka.

### Tipovi relacija 

**One-to-One (hasOne/belongsTo)**  
- svaki korisnik ima točno jedan profil (User -> hasOne -> Profile)
- svaki profil pripada točno jednom korisniku (Profile -> belongsTo -> User)

**One-to-Many (hasMany/belongsTo)**
- jedan autor (User) može imati više postova (User -> hasMany -> Post)
- svaki post pripada točno jednom autoru (Post -> belongsTo -> User)
- ovo je najčešći tip relacije

**Many-to-Many (belongsToMany)**
- jedan članak (Post) može imati više tagova (npr. 'tehnologija', 'laravel')
- jedan tag može biti dodijeljen na više članaka
- za ovo je potrebna treća, pomoćna tablica (tzv. "pivot" tablica, npr. post_tag)

**HasOneThrough / HasManyThrough**
- omogućuje definiranje relacije "kroz" neki drugi model
- primjer - država ima mnogo postova kroz svoje korisnike (Country -> hasManyThrough -> Post -> through -> User)

**Polymorphic (morphOne, morphMany, morphToMany)**
- napredna relacija koja omogućuje da jedan model pripada više od jednom modelu, koristeći jednu vezu -> primjer: i članci (Post) i slike (Image) mogu imati komentare
    - umjesto da kreirate dvije tablice za komentare, imate jednu koja se može vezati za oba modela

Primjer one-to-one relacije
```php
// unutar app/Models/User.php
public function profile() {
    return $this->hasOne(Profile::class);
}

// unutar app/Models/Profile.php
public function user() {
    return $this->belongsTo(User::class);
}

// dodavanje nove migracije
// ...
// u up() metodu dodati ovu liniju:
$table->foreignId('user_id')->constrained()->onDelete('cascade');
```

- `hasOne(Profile::class)` - ovime govorite: "Jedan User ima jedan Profile"
- Laravel će automatski pretpostaviti da u profiles tablici postoji stupac `user_id` koji služi kao strani ključ

- `belongsTo(User::class)` - ovo je inverzna strana relacije i njome govorite: "Ovaj Profile pripada jednom User-u"

- `$table->foreignId('user_id')` - dodaje stupac `user_id` tipa BIGINT (unsigned) u tablicu - namijenjen za pohranu ID-a korisnika (strani ključ)
- `->constrained()` - automatski postavlja strani ključ prema tablici users i stupcu id
    - Laravel pretpostavlja da je povezani model users (prema nazivu stupca)
- `->onDelete('cascade')` - ako se korisnik (user) obriše iz tablice users, automatski će se obrisati svi povezani zapisi (npr. postovi) iz ove tablice tj. održava referencijalni integritet u bazi

- korištenje: sada možete pisati kod poput `$user->profile->phone_number` ili `$profile->user->email`

Što radi `withDefault()`?
- ako pokušate pristupiti `$user->profile->phone_number`, a korisnik nema kreiran profil (relacija vrati null), dobit ćete grešku
- `withDefault()` rješava taj problem tako da vraća prazan "dummy" model umjesto null
- `return $this->hasOne(Profile::class)->withDefault();`
    - sada, ako korisnik nema profil, `$user->profile` će biti prazan Profile objekt i nećete dobiti grešku, već prazan string

### Prilagođeni ključevi
Laravel se oslanja na konvencije (npr. da se strani ključ zove user_id). Ako vaša baza ne prati te konvencije, možete ih eksplicitno navesti.

```php
// unutar modela Post.php, ako želimo dohvatiti autora
return $this->belongsTo(User::class, 'author_id', 'uuid');
```
Ovdje metodi `belongsTo` dajemo dodatne argumente:
- `User::class` - model s kojim se povezujemo
- `author_id` - ime stranog ključa u našoj (posts) tablici -> Laravel bi inače tražio `user_id`
- `uuid` - ime primarnog ključa u drugoj (`users`) tablici -> Laravel bi inače tražio `id`

### Eager Loading i withCount()
#### Problem N+1 upita i rješenje `with()` (Eager Loading)
Zamislimo da imate 100 postova i želite prikazati naslov svakog posta i ime njegovog autora.

-> loš način (bez Eager Loadinga)
```php
$posts = Post::all(); // 1 upit za sve postove
foreach ($posts as $post) {
    echo $post->user->name; // 1 upit za SVAKI post da se dohvati autor
}
// ukupno: 1 + 100 = 101 upit - ovo je jako sporo
```

-> dobar način (`with()` - Eager Loading)
```php
$posts = Post::with('user')->get(); // 2 upita ukupno
foreach ($posts as $post) {
    echo $post->user->name; // nema novih upita, autor je već dohvaćen
}
```
- `with('user')` kaže Eloquentu - "Hej, kada budeš dohvatio postove, odmah nakon toga jednim dodatnim upitom dohvati i sve njihove autore." - time se broj upita drastično smanjuje

Što je `withCount()`?

Ponekad nam ne trebaju svi povezani modeli, već samo njihov broj
- `$users = User::withCount('posts')->get();`
  - ovo će dohvatiti sve korisnike i svaki korisnik će imati dodatno svojstvo `posts_count` s brojem njegovih postova
  - to je puno brže nego da za svakog korisnika dohvaćamo sve postove pa onda brojimo

# Query Builder i DB klasa
**Query Builder** - omogućuje gradnju SQL upita pomoću fluent PHP metoda (`->where()`, `->limit()`, `->get()` itd.)
  - direktniji od Eloquenta, ali sigurniji od sirovog SQL-a
    - **analogija** -> Eloquent je pametni asistent, Query Builder je set preciznih alata
  - koristi se za kompleksne upite, agregacije, ili kada nisu potrebni Eloquent modeli

Početak rada – DB fasada
```php
use Illuminate\Support\Facades\DB;

$users = DB::table('users')->get();
foreach ($users as $user) {
    echo $user->name;
}
```

```php
$user = DB::table('users')->find(1);
$user = DB::table('users')->where('name', 'Pero')->first();
```
- vraća **stdClass objekte**, ne Eloquent modele

### Razlika stdClass objekta i Eloquent modela
```php
// s Eloquentom
$eloquentPost = Post::find(1);
echo $eloquentPost->user->name; // radi
$eloquentPost->title = 'Novi naslov';
$eloquentPost->save(); // radi

// s Query Builderom
$stdClassPost = DB::table('posts')->find(1);
echo $stdClassPost->title; // radi čitanje podataka

echo $stdClassPost->user->name; // GREŠKA! stdClass nema 'user' relaciju
$stdClassPost->save(); // GREŠKA! stdClass nema 'save' metodu
```
- Eloquent model (npr. objekt Post)
  - kada koristite Eloquent, npr. `Post::find(1)`, dobijete objekt koji je instanca vaše klase `App\Models\Post` - taj objekt je "pametan" i "živ"
  - zna tko je - predstavlja točno jedan redak u tablici posts
  - ima sposobnosti (metode) - na njemu možete pozvati metode poput `$post->save()`, `$post->delete()`, ili bilo koju custom metodu koju ste vi definirali unutar Post klase
  - zna svoje relacije - ako ste definirali relaciju, možete jednostavno napisati `$post->user` da dohvatite autora ili `$post->comments` da dohvatite sve komentare

- stdClass objekt
  - kada koristite Query Builder, npr. `DB::table('posts')->find(1)`, dobijete generički stdClass objekt -> to je najjednostavniji mogući objekt u PHP-u -> on je "glup" i pasivan
  - zna tko je - sadrži podatke iz jednog retka tablice kao svoja javna svojstva (npr. `$post->title`)
  - nema sposobnosti - na njemu ne možete pozvati metode poput `save()` ili `delete()` jer on ne zna kako komunicirati s bazom
  - ne zna svoje relacije - ne možete pozvati `$post->user` jer on nema pojma o relacijama koje ste definirali u Eloquent modelu

### Građenje upita (method chaining)

```php
$products = DB::table('products')
  ->where('is_available', true)
  ->where('price', '<', 50)
  ->orderBy('name', 'asc')
  ->get();
```
Što se dešava - korak po korak:
1. `DB::table('products')` = `SELECT * FROM products`
2. `->where('is_available', true)` = `SELECT * FROM products WHERE is_available = true`
3. `->where('price', '<', 50)` = `SELECT * FROM products WHERE is_available = true AND price < 50`
4. `->orderBy('name', 'asc')` = `SELECT * FROM products WHERE is_available = true AND price < 50 ORDER BY name ASC`
5. `->get()` = "ok, sad izvrši ovaj sastavljeni upit i daj mi rezultate."

- svaka metoda dodaje jedan dio u konačni SQL upit, a `get()` (ili `first()`, `find()`, `count()` itd.) je "okidač" koji ga izvršava
- ovo je puno sigurnije od pisanja sirovog SQL-a jer Laravel automatski štiti od SQL Injection napada

## Proširene mogućnosti

### Osnovni alati (must know)
Ovo je set alata koji ćete koristiti u 80% svog rada.

- `select()` - bira koje "stupce" iz tablice želite dohvatiti - ako se ne navede, dohvaćaju se svi (*)
```php
// dohvati samo ime i email svih korisnika
$users = DB::table('users')->select('name', 'email')->get();
```
- `where()` - "filter" za retke koji postavlja jedan uvjet
```php
// dohvati sve proizvode čija je cijena manja od 100
$products = DB::table('products')->where('price', '<', 100)->get();
```
- `orderBy()` - definira po kojem stupcu i u kojem smjeru (rastuće asc ili padajuće desc) želite poredati rezultate
```php
// dohvati sve korisnike poredane po imenu, abecednim redom
$users = DB::table('users')->orderBy('name', 'asc')->get();
```
- `limit()` - ograničava broj redaka koje želite dohvatiti
```php
// dohvati samo 5 najnovijih postova
$posts = DB::table('posts')->orderBy('created_at', 'desc')->limit(5)->get();
```
- `offset()` - govori upitu koliko redaka na početku treba preskočiti - koristi se npr. za paginaciju
```php
// prikaz druge stranice rezultata, ako je na stranici 10 itema (preskoči prvih 10)
$users = DB::table('users')->offset(10)->limit(10)->get();
```
- `first()` - dohvaća samo prvi redak koji zadovoljava sve prethodne uvjete i vraća jedan stdClass objekt ili null
```php
// dohvati prvog registriranog korisnika
$user = DB::table('users')->orderBy('created_at', 'asc')->first();
```
- `find()` - prečac za dohvaćanje jednog retka po njegovom primarnom ključu (id)
```php
// dohvati korisnika s ID-om 5
$user = DB::table('users')->find(5);
```
- `insert()` - umeće jedan ili više novih redaka u bazu
```php
// umetni novog korisnika
DB::table('users')->insert(['email' => 'pero@peric.com', 'name' => 'Pero']);
```
- `update()` - ažurira retke koji zadovoljavaju where uvjet
```php
// ažuriraj ime korisnika s ID-om 5
DB::table('users')->where('id', 5)->update(['name' => 'Novi Pero']);
```
- `delete()` - briše retke koji zadovoljavaju where uvjet
```php
// obriši korisnika s ID-om 5
DB::table('users')->where('id', 5)->delete();
```
- `count()` - najčešća agregacija, vraća ukupan broj redaka koji zadovoljavaju uvjete
```php
// prebroji koliko ima aktivnih korisnika
$activeUsers = DB::table('users')->where('active', 1)->count();
```
- `join()` - vraća samo retke koji imaju par u obje tablice
- `leftJoin()` - vraća sve retke iz prve (lijeve) tablice, bez obzira imaju li par u drugoj
```php
// dohvati sve postove i ime autora svakog posta
$posts = DB::table('posts')
    ->join('users', 'posts.user_id', '=', 'users.id')
    ->select('posts.title', 'users.name as author_name')
    ->get();
```

### Često korišteni specijalizirani alati (nice to have)
Ovo su metode koje rješavaju vrlo česte, specifične probleme i čine kod puno čišćim.

- `whereBetween()` - dohvaća retke gdje je vrijednost stupca unutar zadanog raspona
```php
// dohvati sve narudžbe napravljene u lipnju
$orders = DB::table('orders')
    ->whereBetween('created_at', ['2024-06-01', '2024-06-30'])
    ->get();
```
- `whereIn()` - dohvaća retke gdje vrijednost stupca odgovara bilo kojoj vrijednosti iz zadanog niza
```php
// dohvati korisnike s ID-evima 1, 5 i 10
$users = DB::table('users')->whereIn('id', [1, 5, 10])->get();
```
- `whereNull()` - dohvaća retke gdje je vrijednost zadanog stupca null
- `whereNotNull()` - radi suprotno od `whereNull()`
```php
// dohvati sve korisnike koji nisu "soft-deleted"
$users = DB::table('users')->whereNull('deleted_at')->get();
```
- `pluck('name')` - dohvaća sve vrijednosti iz samo jednog stupca i vraća ih kao jednostavan, indeksirani niz
```php
// dohvati listu svih email adresa korisnika
$emails = DB::table('users')->pluck('email');
```
- `value('email')` - dohvaća jednu jedinu vrijednost iz prvog retka koji zadovoljava uvjet
```php
// dohvati email adresu korisnika s ID-om 5
$email = DB::table('users')->where('id', 5)->value('email');
```
- `when()` - uvjetno dodaje klauzule u upit, čime se izbjegavaju neuredne if petlje
```php
$isAdmin = true;
$users = DB::table('users')
    ->when($isAdmin, function ($query) {
        // ovaj dio će se dodati samo ako je $isAdmin true
        $query->where('role', 'admin');
    })
    ->get();
```

### Napredni alati za posebne slučajeve (možda nekad zatreba)
Ovo su alati koje nećete koristiti svaki dan, ali je dobro znati da postoje za rješavanje specifičnih problema.

- `selectRaw()` - omogućuje pisanje sirovog SQL-a unutar select dijela upita -> koristiti oprezno i s ? placeholderima za zaštitu!!
```php
// dohvati cijenu s uračunatim PDV-om
$products = DB::table('products')
    ->selectRaw('price * 1.25 as price_with_vat')
    ->get();
```
- `groupBy()` i `having()` - koriste se za agregaciju i izvještaje
  - groupBy grupira retke
  - having filtrira rezultate nakon grupiranja
```php
// dohvati sve gradove koji imaju više od 10 korisnika
$cities = DB::table('users')
    ->select('city', DB::raw('count(*) as user_count'))
    ->groupBy('city')
    ->having('user_count', '>', 10)
    ->get();
```
- `upsert()` i `updateOrInsert()` - "Update or Insert" operacije
- `updateOrInsert()` - Pponalazi jedan redak po uvjetu i ažurira ga, ili ga kreira ako ne postoji
```php
// ažuriraj korisnika 'pero@peric.com' ili ga kreiraj ako ne postoji
DB::table('users')->updateOrInsert(
    ['email' => 'pero@peric.com'],
    ['name' => 'Pero']
);
```
- `upsert()` - radi istu stvar ali za više redaka odjednom, što je puno efikasnije

- `chunk()` i `lazy()` - koriste se za obradu ogromnih količina podataka bez da se sruši memorija servera
- `chunk()` dohvaća podatke u "komadima"
- `lazy()` dohvaća jedan po jedan podatak
```php
// prođi kroz sve korisnike u serijama od 100
DB::table('users')->orderBy('id')->chunk(100, function ($users) {
    foreach ($users as $user) {
        // obradi korisnika
    }
});
```
- `lockForUpdate()` (pessimistic locking) - "zaključava" odabrane retke unutar transakcije, sprječavajući druge procese da ih mijenjaju dok vi ne završite
```php
// osiguraj da nitko ne može promijeniti stanje zaliha dok mi radimo narudžbu
DB::transaction(function () {
    $product = DB::table('products')->where('id', 1)->lockForUpdate()->first();
    // provjeri zalihe i ažuriraj
});
```
- Debugging (`dd()`, `dump()`, `ddRawSql()`) - izuzetno korisni alati za provjeru SQL upita koji se generira

- `dd()` - ispisuje generirani upit i podatke te zaustavlja izvršavanje skripte
- `dump()` - radi isto, ali ne zaustavlja izvršavanje
- `ddRawSql()` - ispisuje "sirovi" SQL upit sa svim vrijednostima na pravim mjestima
```php
// pogledaj koji se točno SQL generira prije nego se izvrši
DB::table('users')->where('id', 1)->dd();
```

### Sigurnost
Zaštita od SQL Injectiona (PDO Binding) - Query Builder automatski štiti vaše upite. On odvaja strukturu upita od podataka koje šalje korisnik, sprječavajući zlonamjerne korisnike da "ubrizgaju" maliciozni kod.
```php
// sigurno - Laravel ovo pretvara u siguran upit s placeholderima
$email = $request->input('email');
DB::table('users')->where('email', $email)->get();
```

Imena stupaca se ne mogu "bindati" - zaštita se odnosi samo na vrijednosti, ne i na imena stupaca (npr. u orderBy). Nikada ne prosljeđujte direktan unos korisnika u te metode.
```php
// sigurno rješenje (whitelist)
$sortByInput = $request->input('sort_by'); // npr. 'name'
$allowed = ['name', 'email']; // dozvoljeni stupci

if (in_array($sortByInput, $allowed)) {
    DB::table('users')->orderBy($sortByInput)->get();
}
```

# Testiranje u Laravelu
Zašto testiramo? Ručno testiranje je sporo i nepouzdano - klikanje kroz cijelu aplikaciju nakon svake male promjene je nepraktično i podložno ljudskim greškama.

- zaštita od regresija - automatizirani testovi su vaša "sigurnosna mreža" tj. oni osiguravaju da nova funkcionalnost nije pokvarila neku staru

- Unit testovi - testiraju jedan mali, izolirani dio koda (jednu metodu ili klasu) bez ostatka aplikacije

- Feature (HTTP) testovi - testiraju jednu funkcionalnost iz perspektive korisnika, simulirajući cijeli zahtjev kroz aplikaciju

## Ugrađeno testno okruženje
Laravel koristi PHPUnit (ili Pest) kao temelj za testiranje.
Testovi se nalaze u `tests/Unit` i `tests/Feature` direktorijima.

- `.env.testing` - ako ova datoteka postoji, Laravel će je automatski koristiti prilikom pokretanja testova
  - to vam omogućuje da za testove koristite potpuno odvojenu bazu podataka (npr. u memoriji - SQLite) i tako sačuvate svoje stvarne podatke

- session i cache driveri (array) - tijekom testiranja, Laravel automatski postavlja drivere za sesiju i cache na array, što znači da se ti podaci ne zapisuju na disk, već se čuvaju u memoriji
  - to čini testove drastično bržima

## Paralelizacija i performanse
- zahtijeva `composer require brianium/paratest --dev`
- pokretanje: `php artisan test --parallel --processes=4`
- objašnjenje: umjesto da pokreće testove jedan po jedan, Laravel će ih pokrenuti istovremeno u 4 odvojena procesa (kao da imate 4 radnika koji istovremeno rade testove)
  - ovo može značajno ubrzati izvršavanje velikog broja testova
  - Laravel se automatski brine o kreiranju odvojenih testnih baza za svaki proces

## Coverage i profiliranje
- coverage - `php artisan test --coverage`
- objašnjenje - generira izvještaj koji vam pokazuje koliko je posto (npr. 85%) vašeg koda "pokriveno" testovima
  - to vam pomaže da identificirate dijelove aplikacije koje niste testirali
- profiliranje - `php artisan test --profile`
- objašnjenje - nakon izvršavanja, ispisat će listu vaših 10 najsporijih testova
  - ovo je izuzetno korisno za optimizaciju i pronalaženje problematičnih dijelova koda

## Kreiranje i pokretanje testa
```php
php artisan make:test HomepageTest
```

Primjer testa:
```php
// tests/Feature/HomepageTest.php
namespace Tests\Feature;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    /** @test */
    public function the_homepage_is_accessible(): void
    {
        // 1. simuliraj GET zahtjev na početnu stranicu
        $response = $this->get('/');

        // 2. provjeri (assert) je li HTTP status odgovora 200 (OK)
        $response->assertStatus(200);
    }
}
```
Pokretanje:
```php
php artisan test // pokreće sve testove
php artisan test --filter=HomepageTest // pokreće samo specifični test
```

## HTTP Testovi (Feature Tests)
Osnovne asertacije tj. metode kojima provjeravamo je li odgovor ispravan
```php
$response->assertStatus(200);   // je li odgovor bio uspješan?
$response->assertOk();          // skraćenica za assertStatus(200)
$response->assertNotFound();    // je li odgovor bio 404 Not Found?
$response->assertCreated();                 // je li HTTP status 201 Created?
$response->assertForbidden();               // je li HTTP status 403 Forbidden?
$response->assertNoContent();               // je li HTTP status 204 No Content?
$response->assertRedirect('/login'); // je li korisnik preusmjeren na /login?
$response->assertSee('Dobrodošli');  // vidi li se tekst "Dobrodošli" na stranici?
$response->assertDontSee('Pristup zabranjen'); // je li sigurno da se ovaj tekst NE vidi?
$response->assertSeeInOrder(['Prvi', 'Drugi']); // vide li se ovi tekstovi, točno ovim redoslijedom?
```
JSON testiranje - za testiranje API endpointa
```php
$response->assertJson(['created' => true]); // sadrži li JSON odgovor ovaj fragment?
$response->assertExactJson([...]);          // odgovara li JSON odgovor u potpunosti ovom polju?
$response->assertJsonPath('user.name', 'Pero'); // je li vrijednost na putanji user.name jednaka 'Pero'?
$response->assertJsonFragment(['active' => true]); // sadrži li JSON ovaj mali dio, bez obzira na strukturu?
```
Session i autentikacija - simuliranje prijavljenih korisnika
```php
// simuliraj da je ovaj korisnik prijavljen za sljedeće zahtjeve
$this->actingAs($user);

// Provjere
$this->assertAuthenticated();      // je li bilo koji korisnik prijavljen?
$this->assertAuthenticatedAs($user); // je li točno ovaj korisnik prijavljen?
$this->assertGuest();              // je li sigurno da nitko nije prijavljen?
```
Headers i kolačići - slanje dodatnih informacija uz zahtjev
```php
// pošalji GET zahtjev s dodatnim zaglavljem
$this->withHeaders(['X-Custom-Header' => 'Vrijednost'])->get('/');

// pošalji GET zahtjev s kolačićem
$this->withCookie('ime_kolacica', 'vrijednost')->get('/');
```
View testiranje - testiranje pogleda (views) direktno, bez rute
```php
$this->view('welcome', ['name' => 'Pero']) // renderiraj 'welcome.blade.php' s podacima
     ->assertViewIs('welcome')               // je li ispravan pogled renderiran?
     ->assertViewHas('name', 'Pero')         // sadrži li pogled varijablu 'name' s vrijednošću 'Pero'?
     ->assertViewMissing('age');             // je li sigurno da pogled NE sadrži varijablu 'age'?
```
Uploadi i storage - testiranje uploada datoteka
```php
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// 1. Stvori lažni, virtualni disk 'avatars' u memoriji
Storage::fake('avatars');

// 2. Stvori lažnu sliku u memoriji
$file = UploadedFile::fake()->image('avatar.jpg');

// 3. Pošalji POST zahtjev s lažnom datotekom
$response = $this->post('/avatar', ['avatar' => $file]);

// 4. Provjeri je li datoteka s očekivanim imenom spremljena na lažni disk
Storage::disk('avatars')->assertExists($file->hashName());
```
Debugging i exception handling - alati za pronalaženje grešaka u testovima
```php
// Ispiši header i sadržaj odgovora i nastavi s testom
$response->dump();

// Ispiši header i sadržaj odgovora i zaustavi izvršavanje testa
$response->dd();

// Ako test pada, nemoj hvatati grešku i prikazivati lijepu poruku.
// Umjesto toga, prikaži puni, "ružni" stack trace da vidim točno gdje je problem.
$this->withoutExceptionHandling();
```

## Laravel Dusk (kratki uvod)
Dusk automatizira stvarni Chrome preglednik za testiranje frontend interakcija.

Instalacija - `composer require laravel/dusk --dev` i `php artisan dusk:install`

Pokretanje - `php artisan dusk`

DB u Dusk-u - koristiti DatabaseMigrations ili DatabaseTruncation traitove u testovima
  - RefreshDatabase koji se koristi u PHPUnit ne radi jer Dusk i PHPUnit rade u odvojenim procesima

Selektori - koristite `dusk="ime-elementa"` atribut u HTML-u za stabilne selektore

Primjer Dusk testa
```php
// tests/Browser/RegistrationTest.php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class RegistrationTest extends DuskTestCase
{
    // koristimo DatabaseMigrations trait da osiguramo čistu bazu za svaki test
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_register_successfully()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    // koristimo @ simbol za referenciranje dusk atributa
                    ->type('@registration-name-input', 'Pero Peric')
                    ->type('@registration-email-input', 'pero@peric.com')
                    ->type('@registration-password-input', 'password')
                    ->type('@registration-password-confirmation-input', 'password')
                    ->press('@register-button')
                    ->assertPathIs('/dashboard')
                    ->assertSee('Pero Peric');
        });
    }
}
```