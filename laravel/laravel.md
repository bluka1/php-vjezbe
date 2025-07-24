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
Najjednostavniji odgovor je vraćanje stringa ili polja iz kontrolera. Laravel će ih automatski pretvoriti u ispravan HTTP odgovor.
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