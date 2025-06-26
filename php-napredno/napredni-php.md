# napredni php

## Uvod u OOP (Objektno orijentirano programiranje)

- Objekti = podaci(svojstva) + metode(funkcije)

4 temeljna principa OOP-a:
1. enkapsulacija - zapakiravanje podataka i funkcionalnosti unutar jedne cjeline
2. apstrakcija - skrivanje detalja funkcioniranja objekta
3. nasljedivanje - ponovna upotreba kroz hijerarhiju
4. polimorfizam - modifikacija zadanih svojstava/funkcionalnosti u primjenjenom objektu

Razlika proceduralnog tipa programiranja i OOP-a:
- proceduralno - bazira se na funkcijama koje obraduju podatke i ispisuju ih ili vracaju (korisno je za manje programe/protipe/jednostavnije skripte)
- OOP - bazira se na objektima - kod je organiziraniji, razumljiviji i lakši za održavanje

Glavne prednosti OOP-a:
- bolja struktura i organizacija koda
- lakša ponovna upotreba
- lakše održavanje i proširavanje koda
- smanjenje kompleksnosti
- lakša kolaboracija

--- 

## Klase i objekti

Klasa je "nacrt" na temelju kojeg nastaje novi primjerak nekog objekta.
Objekt je primjerak nastao na temelju neke klase.

```php
class ImeKlase {
  // svojstva
  // metode
}

$noviObjekt = new ImeKlase();
```

Svaki objekt ima svojstva(properties) i metode(methods).

### Svojstva
Svojstva su varijable deklarirane unutar klase. U svojstva spremamo podatke ili stanje objekta.

Svojstva deklariramo na sljedeći način:
1. odredimo djelokrug(visibility) svojstva (public, private, protected)
2. dodijelimo ime svojstva (poput deklariranja varijable)

```php
class Osoba {
  // svojstva
  public $ime;
  public $prezime;
}
```

### Metode
Metode su funkcije definirane unutar klase. One definiraju ponašanje odnosno funkcionalnosti objekta.
Deklariraju se na isti način kao i obične funkcije uz dodatak djelokruga.

```php
class Osoba {
  // svojstva
  public $ime;
  public $prezime;

  // metode
  public function prikaziOsobneDetalje() {
    // ... kod metode
  }
}
```

`$this` ključna riječ je pseudo-varijabla koja se odnosi na trenutni objekt i time nam pomaže pristupiti svojstvima i metodama na trenutnom objektu.

```php
class Osoba {
  // svojstva
  public $ime;
  public $prezime;

  // metode
  public function prikaziOsobneDetalje() {
    echo $this->$ime . ' ' . $this->prezime;
  }
}

$novaOsoba = new Osoba();
$novaOsoba->prikaziOsobneDetalje();
```

### Djelokrug
Djelokrug odreduje odakle sve možemo pristupiti svojstvima i metodama klase(objekta).
3 glavne razine djelokruga:
1. public - može se pristupiti svojstvima i metodama iz bilo kojeg dijela koda
2. private - može se pristupiti samo unutar same klase i niotkuda drugdje
3. protected - može se pristupiti samo unutar same klase te klasama koje su istu naslijedile

### Konstruktor i destruktor
Konstruktor je posebna metoda unutar klase koja se automatski poziva prilikom kreiranja novog objekta te klase.
Njegova glavna svrha je inicijalizacija objekta odnosno postavljanje početnih vrijednosti za svojstva objekta ili izvodenje bilo kakvih setup radnji potrebnih prije nego se objekt krene koristiti.

Destruktor je posebna metoda unutar klase koja se automatski poziva kada objekt više nije potreban odnosno kada skripta završi izvodenje. Svrha mu je čišćenje resursa koje je objekt koristio (npr. oslobadanje zauzete memorije, zatvaranje konekcije na bazu i sl.).
Destruktori su najkorisniji kada radimo s vanjskim resursima poput baza podataka ili datoteka. Oni osiguravaju da su ti resursi ispravno zatvoreni.

```php
class NekoImeKlase {
  // svojstva
  $ime;
  $prezime;

  public function __construct($_ime, $_prezime) {
    $this->ime = $_ime;
    $this->prezime = $_prezime;
  }

  public function __destruct() {
    echo 'Osoba ' . $this->ime . ' više ne postoji u aplikaciji.';
  }
}

$noviObjekt = new NekoImeKlase('Matko', 'Matkić');
```

Umjesto da čekamo na destruktor da pokrene `__destruct()` metodu, ako znamo da nam neki objekt više nije potreban u aplikaciji, mi možemo manualno uništiti objekt pomoću `unset` funkcije.

```php
unset($noviObjekt);
```

### Apstraktne klase
Apstraktna klasa je klasa iz koje ne možemo napraviti objekt tj. ne možemo ju direktno instancirati koristeći ključnu riječ `new`. Njena poanta je da ju druge klase naslijede i "pokupe" njena svojstva i metode. Ona je drugim riječima temelj za kreiranje druge klase.

Apstraktna klasa može sadržavati:
- konkretne metode s punom implementacijom (kao i metode na običnoj klasi)
- apstraktne metode - deklarirana metoda, ali bez implementacije (implementacija je ostavljena klasama koje nasljeduju apstraktnu klasu)
- svojstva - public/private/protected

Apstraktnu klasu definiramo pomoću ključne riječi `abstract class` dok apstraktne metode definiramo pomoću ključne riječi `abstract function`.

```php
abstract class Zivotnja {
  public $vrsta;

  public function __construct($_vrsta) {
    $this->vrsta = $_vrsta;
  }

  public function trci() {
    echo 'fijuuuuu...';
  }

  abstract function glasajSe();
}
```

Svaka klasa koja nasljeduje apstraktnu klasu MORA koristiti `extends` ključnu riječ da bi ju naslijedila. Ta klasa koja nasljeduje apstraktnu klasu MORA implementirati sve apstraktne metode iz apstraktne(roditeljske) klase. Ako slučajno ne implementira sve metode, ona sama MORA biti definirana kao apstraktna.


### Sučelja (interfaces)
Sučelja se mogu okarakterizirati kao ugovori izmedu sučelja i klase koja će implementirati to sučelje.
Sučelja definiraju koje metode klasa mora implementirati ako implementira to sučelje, a definira se pomoću ključne riječi `interface`.

U usporedbi s apstraktnim klasama, sučelja:
- ne mogu sadrżavati implementaciju metoda - sadrže samo deklaraciju metoda
- ne mogu sadržavati svojstva
- klasa može implementirati jedno ili više sučelja (koristeći `implements` ključnu riječ)

```php
interface MozeGovoriti {
  public function govori($poruka);
}

interface MozeHodati {
  public function hodaj();
}

class Osoba implements MozeGovoriti, MozeHodati {
  public function govori($poruka){
    echo $poruka;
  }

  public funtion hodaj() {
    echo 'korak 1...'
  }
}
```

#### Razlike sučelja i apstraktnih klasa
- implementacija
  - apstraktne klase mogu imati i apstraktne i obične metode
  - sučelja mogu imati samo apstraktne metode (bez implementacije)
- svojstva
  - apstraktne klase mogu imati svojstva
  - sučelja ne mogu imati svojstva
- višestruko nasljedivanje/implementacija
  - klasa može naslijediti samo jednu klasu (apstraktnu ili bilo koju drugu)
  - klasa može implementirati više sučelja

Apstraktne klase dobre su za odnos `je` - npr. Pas je Životinja (želimo podijeliti zajednički kod i strukturu klase)

Sučelja su dobra za `može` odnos - npr. Osoba može govoriti, Osoba može hodati (želimo definirati "ugovor" o ponašanju bez obzira na pojedinu implementaciju)

### Imenski prostori (namespaces)
Imenski prostori su način organiziranja i grupiranja povezanog koda u logičke cjeline te način sprječavanja kolizije izmedu imena funkcija, klasa i konstanti.

Oni se mogu poistovjetiti s mapama na vašem računalu.

primjer:

 unutar naše aplikacije imamo mapu Korisnici i unutar nje imamo datoteku podaci.txt; imamo mapu Partneri i unutar nje imamo datoteku podaci.txt. Ta 2 dokumenta neće biti u koliziji ako koristimo imenske prostore jer se nalaze u različitim mapama.


`MojaAplikacija/Korisnici/Korisnik.php`
```php
<?php
  namespace MojaAplikacija\Korisnici

  class Korisnik {
    public $ime;
    public $email;

    public __construct($ime, $email) {
      $this->ime = ime;
      $this->email = email;
    }
  }
>
```


Korištenje imenskih prostora i kreiranje aliasa:
`MojaApikacija/index.php`
```php
<?php
  ...
  // import klase koju namjeravamo koristiti
  include 'MojaAplikacija/Korisnici/Korisnik.php'

  // korištenje klase bez imenskog prostora
  $korisnik = new MojaAplikacija\Korisnici\Korisnik('Franjo', 'franjo@email.com');
  
  // korištenje klase uz ključnu riječ use
  use MojaAplikacija\Korisnici\Korisnik;
  $korisnik = new Korisnik('Franjo', 'franjo@email.com');

  // kreiranje aliasa za klasu iz imenskog prostora
  use MojaAplikacija\Korisnici\Korisnik as K;
  $korisnik = new K('Franjo', 'franjo@email.com');
  ...
>
```

- ključna riječ `use` omogućuje nam da uvezemo klasu iz odredenog prostora i koristimo ju kraćim imenom
- alias je posebno koristan kad imamo koliziju imena iz različitih prostora ili kad je ime predugačko

Prednosti korištenja imenskih prostora:
1. Sprječavanje kolizije imena
2. Bolja organizacija koda (logičko grupiranje povezanih klasa)
3. Lakše održavanje (jasnija struktura u većim aplikacijama)
4. Kompatibilnost s vanjskim bibliotekama (izbjegavanje "sukoba" s kodom iz vanjskih biblioteka)


### Automatsko učitavanje
Automatsko učitavanje je mehanizam koji omogućuje PHP-u da automatski pronade i učita datoteku koja sadrži klasu koju želimo instancirati. Umjesto da eksplicitno uključujemo datoteke u naš kod, PHP će korištenjem automatskog učitavanja automatski to učiniti za nas i to isključivo onda kad mi to zatražimo (tj. kad pozovemo konstruktor funkciju neke klase - kad ju želimo instancirati).

PHP ima ugradenu funkciju `spl_autoload_register()` pomoću koje možemo registrirati vlastitu funkciju koja će se pozivati svaki put kad PHP pokuša koristiti klasu koju nije učitao.

Prednosti automatskog učitavanja:
1. čišći kod - nema require/include naredbi
2. bolje performanse - klase se učitavaju samo onda kad su potrebne
3. lakše održavanje - dodavanje nove klase ne zahtjeva mijenjanje postojećeg koda
4. standardizirani pristup - kompatibilnost s composerom i modernim frameworcima

### Iznimke (Exception handling)
Iznimke su objekti koji predstavljaju greške ili neke neočekivane situacije koje se mogu dogoditi prilikom izvršavanja programa. 
Umjesto da nam greška naruši ponašanje aplikacije, naš zadatak je da "uhvatimo" problem koji se desi i elegantno ga riješimo (ili prikažemo korisniku neku razumljivu poruku o grešci).
Za upravljanje iznimkama, koristi se `try-catch-finally` blok.

Kako funkcionira try-catch-finally blok?
1. try blok - kod koji može uzrokovati grešku
2. catch blok - kod koji se izvršava kad se iznimka dogodi
3. Exception objekt - sadrži informacije o grešci (npr. poruku, lokaciju, kod...)
4. finally blok - izvršava se na kraju, neovisno o tome je li došlo do greške ili nije (nije ga obavezno pisati) - često za čišćenje resursa, zatvaranje konekcija i sl.

Sintaksa `try-catch-finally` bloka:
```php
try {
  ...
  // kod koji može uzrokovati iznimku
  $rezultat = rizicnaOperacija();
  echo $rezultat;
} catch (Exception $e) {
  ...
  // kod koji se izvršava u slučaju greške iz gornjeg bloka
  echo 'Greška: ' . $e->getMessage();
} finally {
  ...
  // uvijek se izvršava
}
```

Više iznimaka i različiti tipovi iznimaka:

```php
try {
  $pdo = new PDO("mysql:host=localhost;dbname=test", $user, $password);
  $file = file_get_contents('nepostojeciFile.txt');
  $rezultat = 10 / 0;
} catch(PDOException $e) {
  echo 'Greška baze podataka: ' . $e->getMessage();
} catch(ErrorException $e) {
  echo 'Greška datoteke: ' . $e->getMessage();
} catch(DivisonByZeroError $e) {
  echo 'Matematička greška: ' . $e->getMessage();
} catch(Exception $e) {
  echo 'Općenita greška: ' . $e->getMessage();
}
```

Prednosti upravljanja greškama (Excption handling):
1. elegantno rukovanja greškama - program ne prekida rad
2. bolje korisničko iskustvo - prikladne i razumljive poruke o greškama
3. lakše debuggiranje - detaljnije informacije o grešci
4. čišći kod - odvajamo glavnu logiku od rukovanja greškama


Sve iznimke baziraju se na Throwable sučelju koje implementiraju Error (fatalne greške) i Exception (iznimke koje možemo uhvatiti) klase.
- `Throwable`
  - `Error` (fatalne greške u PHP-u - potrebno ispraviti u kodu)
    - `ParseError` (greške u sintaksi - npr. kad zaboravimo ; ili zatvoriti/otvoriti zagradu i sl.)
    - `TypeError` (greška u proslijedenom tipu podatka - npr. funkcija očekuje int, a proslijedimo string)
    - `ArgumentCountError` (proslijeden pogrešan broj parametara funkcije)
    - `ArithmeticError` (greška pogrešne matematičke operacije koja nije dijeljenje s nulom)
      - `DivisionByZeroError` (greška kod dijeljenja s nulom)
  - `Exception` (iznimke koje možemo uhvatiti i trebamo predvidjeti)
    - `ErrorException` (omogućuje da se PHP greške nižeg ranga pretvore u iznimke koje se mogu uhvatiti - npr. Warning ili Notice greške)
    - `InvalidArgumentException` (argument proslijeden funkciji je ispravnog tipa, ali neispravne vrijednosti - npr. funkcija očekuje pozitivan broj, a mi proslijedimo negativan broj)
    - `LogicException` (greška u samoj logici programa - npr. 2 puta pošaljemo narudžbu)
    - `RuntimeException` (greška uzrokovana vanjskim faktorima kao npr. nedostupnost API-ja, nemamo ovlasti za pisanje u datoteku i sl.)
      - `OutOfBoundsException` (greška kod pristupanja nepostojećem indeksu u nizu)
      - `UnexpectedValueException` (greška uzrokovana pogrešnom vrijednosti npr. neispravno formatiran JSON)
    - `PDOException` (greška u komunikaciji s bazom)

Najbolje prakse za iznimke:
1. specifičnost - hvatanje specifičnih iznimaka, a ne samo generalni Exception
2. logiranje - uvijek bilježite (logirajte) greške
3. čišćenje - korisitite finally blok za oslobadanje resursa
4. informativne poruke - dajte korisne informacije o grešci
5. ne skrivajte poruke - ne ostavljajte prazan catch blok


### Obrasci dizajna (Design patterns)

Obrasci dizajna dokazana su rješenja za česte probleme u programiranju. To su "recepti" za rješavanje tih problema no nisu gotov kod koji ćemo od nekuda iskopirati. Radi se o konceptu tj. načinu pisanja koda koji se može prilagoditi traženoj situaciji.

Prije nego krenemo s obrascima, moramo znati što znači `static` keyword odnosno djelokrug(visibility).

Kada neko svojstvo ili neka metoda ima djelokrug postavljen na `static`, to znači da to svojstvo odnosno ta metoda nije dostupna na instanci objekta nastalog iz klase već su oni dostupni na samoj klasi.
To znači da se na njih ne referiramo unutar instance objekta već da ih pozivamo odnosno referiramo se na njih pomoću imena klase te znaka `::`.
Dakle, ta svojstva i metode žive unutar same klase, a ne unutar objekta.

#### Singleton obrazac
Singleton obrazac osigurava da klasa ima samo jednu instancu i pruža globalan pristup toj instanci.
Koristi se za:
- konekciju na bazu podataka
- logger objekte
- konfiguraciju aplikacije
- cache objekte...

Nedostaci Singletona:
- može otežati testiranje koda
- uvodi skrivene ovisnosti
- može narušiti [SOLID principe](https://www.digitalocean.com/community/conceptual-articles/s-o-l-i-d-the-first-five-principles-of-object-oriented-design)

Singleton koristimo samo onda kada je to stvarno potrebno.

Prilikom kreiranja instance objekta generalno, postoje 3 načina za izradu objekta:
1. korištenjem konstruktora
2. kloniranjem
3. deserijalizacijom

Da bismo osigurali da neka klasa može biti isključivo singleton objekt, moramo "zatvoriti" sve načine instanciranja objekta iz klase.
Iz tog razloga konstruktor nam mora biti privatan isto kao i `__clone()` i `__wakeup()` metode koje služe kreiranju objekta. `__clone()` je metoda za kloniranje i izradu nove instance objekta dok `__wakeup()` metoda služi da bi se neki string (npr. koji smo dobili iz JSON filea) pretvorio u objekt.

```php
class Database {
  private static $instance = null;
  private $connection;

  // privatni konstruktor sprječava direktno kreiranje objekta
  private function __construct() {
    $this->connection = new PDO('mysql:host=localhost;dbname=videoteka', 'user', 'pass');
  }

  // sprječava kloniranje objekta
  private function __clone() {}

  // sprječava deserijalizaciju
  private function __wakeup() {}

  // public metoda za kreiranje instance
  public static function getInstance() {
    // Database::$instance === null
    if (self::$instance === null) {
      self::$instance = new self(); // new Database();
    }
    return self::$instance;
  }

  public function getConnection() {
    return $this->connection;
  }
}

$baza = Database::getInstance();
$baza2 = Database::getInstance(); // isti objekt kao ovaj iznad
$baza->getConnection();
var_dump($baza === $baza2); // true
```


#### Factory obrazac
Factory obrazac je sučelje za kreiranje objekata bez specificiranja točne klase objekta koji se kreira.

Factory obrazac koristimo kada:
- ne znamo unaprijed točan tip objekta koji trebamo kreirati
- želimo imati centraliziranu logiku za stvaranje objekta
- objekti imaju zajedničko sučelje, a različitu implementaciju

Prednosti korištenja factory obrasca:
1. fleksibilnost - lako dodavanje novih tipova objekata
2. centralizirana logika - sva logika kreiranja nalazi se na samo jednom mjestu
3. loose coupling - kod ne ovisi o konkretnim klasama

```php
// sučelje koje dijele sve klase
interface Vozilo {
  public function stani();
  public function kreni();
}

class Automobil implements Vozilo {
  public function stani() {
    echo 'Zaustavljam automobil';
  }
  public function kreni() {
    echo 'Pokrećem automobil';
  }
}

class Bicikl implements Vozilo {
  public function stani() {
    echo 'Zaustavljam bicikl';
  }
  public function kreni() {
    echo 'Pokrećem bicikl';
  }
}

class Motor implements Vozilo {
  public function stani() {
    echo 'Zaustavljam motor';
  }
  public function kreni() {
    echo 'Zaustavljam motor';
  }
}

// Factory klasa
class VoziloFactory {
  public static function create($tip) {
    switch($tip) {
      case 'automobil':
        return new Automobil();
      case 'bicikl':
        return new Bicikl();
      case 'motor':
        return new Motor();
      default:
        throw new InvalidArgumentException('Nepoznat tip vozila: ' . $tip);
    }
  }
}

$vozilo1 = VoziloFactory::create('automobil');
$vozilo2 = VoziloFactory::create('bicikl');
```

Primjer kombinacije singleton i factory obrasca
 
```php
class VoziloFactory {
  private static $instanca = null;

  private function __construct() {}

  public function __clone() {}
  public function __wakeup() {}

  public static getInstance() {
    if (self::$instanca === null) {
      self::$instanca = new self();
    }

    return self::$instanca;
  }

  public static function create($tip) {
    switch($tip) {
      case 'automobil':
        return new Automobil();
      case 'bicikl':
        return new Bicikl();
      case 'motor':
        return new Motor();
      default:
        throw new InvalidArgumentException('Nepoznat tip vozila: ' . $tip);
    }
  }

  public function createVozilo($tip) {
    return VoziloFactory::create($tip);
  }
}
```

#### Iterator obrazac
Iterator obrazac je obrazac kojim se omogućuje sekvencijalni pristup elementima kolekcije(niz, asocijativni niz...) bez otkrivanja unutarnje implementacije te kolekcije.
On omogućuje prolazak kroz kolekciju bez poznavanja njene strukture te pruža standardizirani način iteracije.

Prednosti:
1. standardizirani pristup - ista sintaksa za različite kolekcije
2. enkapsulacija - skriva unutarnju strukturu
3. fleksibilnost - može imati različite načine iteracije

```php
class KolekcijaKnjiga implements Iterator {
  $knjige = [];
  $pozicija = 0;

  public function dodajKnjigu($knjiga) {
    $this->knjige[] = $knjiga;
  }

  public function current() {
    // vraća trenutni element
    return $this->knjige[$this->pozicija];
  }

  public function key() {
    // vraća ključ trenutog elementa
    return $this->pozicija;
  }

  public function next() {
    // nastavlja na sljedeći element
    $this->position++;
  }
  public function rewind() {
    // vraća iterator na prvi element
    $this->position = 0;
  }
  public function valid() {
    // provjerava je li trenutna pozicija valjana
    // return count($this->knjige) - 1 >= $this->pozicija;
    return isset($this->knjige[$this->pozicija]);
  }
}

$novaKolekcija = new KolekcijaKnjiga();
$novaKolekcija->dodajKnjigu('Papa Franjo');
$novaKolekcija->dodajKnjigu('Dvojica Pape');

foreach($novaKolekcija as $kljuc => $knjiga) {
  echo "$kljuc : $knjiga";
}
```

#### Observer obrazac
Obrserver obrazac omogućuje objektu da obavijesti više drugih objekata (observers) o promjenama u svom stanju.
Često se koristi za obavijesti, logging sustave, event handling i slično.

Prednosti:
1. loose coupling - subject i observer su slabo povezani
2. dinamiċnost - možemo dodavati/uklanjati ovservere tijekom izvršavanja
3. proširivost - lako dodavanje novih tipova observera

```php
interface Subject {
  public function attach(Observer $observer);  
  public function detach(Observer $observer);
  public function notify();
}

interface Observer {
  public function update(Subject $subject);
}

class Youtuber implements Subject {
  $observers = [];
  $newVideo;

  public function attach(Observer $observer) {
    $this->observers[] = $observer;
  }

  public function detach(Observer $observer) {
    $key = array_search($observer, $this->observers);
    if ($key !== false) {
      unset($this->observers[$key]);
    }
  }

  public function notify() {
    foreach($this->observers as $observer) {
      $observer->update();
    }
  }

  public function getVideo() {
    return $this->newVideo;
  }

  public function setVideo(string $video) {
    $this->newVideo = $video;
    $this->notify();
  }
}

class Subscriber implements Observer {
  $ime;

  public function __construct($ime) {
    $this->ime = $ime;
  }

  public function update(Subject $subject) {
    echo $this-ime . ' je primio obavijest o novom video koji se zove: ' . $subject->getVideo(); 
  }
}

$youtuber = new Youtuber();

$subscriber1 = new Subscriber('Mate');
$subscriber2 = new Subscriber('Miso');
$subscriber3 = new Subscriber('Kovac');

$youtuber->attach($subscriber1);
$youtuber->attach($subscriber2);
$youtuber->attach($subscriber3);

$youtuber->setVideo('NOVIIII VIDEOOOOOO');
```

*** Ostale obrasce i korisne materijale možete naći na: [https://refactoring.guru/](https://refactoring.guru/)

## MySQL konekcija

### MySQLi (MySQL improved)
To je PHP ekstenzija koja omogućuje rad s MySQL bazama podataka te predstavlja unaprijedenu verziju MySQL ekstenzije.
Pruža objektno orijentirano i proceduralno sučelje, podršku za prepared statemente(pripremljene naredbe), podršku za transakcije, poboljšane sigurnosne značajke te poboljšane performanse.

Osnovne metode:
- query() - izvršava SQL upit
- prepare() - priprema SQL naredbu (štiti nas od SQL injectiona)
- fetch_assoc() - dohvaća red kao asocijativni niz
- fetch_array() - dohvaća red kao numerički niz i asocijativni
- fetch_row() - dohvaća red kao numerički niz
- num_rows - broj redova u rezultatu
- affected_rows() - broj pogodenih redova
- insert_id - ID zadnje umetnutog reda

Načini korištenja:
1. proceduralno

```php
$connection = mysqli_connect('host', 'korisnik', 'lozinka', 'baza');

if (!$connection) {
  die('Konekcija na bazu nije bila uspješna: ' . mysqli_connect_error());
}

$sqlUpit = "SELECT * FROM korisnici";

$rezultati = mysqli_query($sqlUpit);

while($row = mysqli_fetch_assoc($rezultati)) {
  echo $row['ime'] . ' ' . $row['prezime'] . '\n';
}

mysqli_close($connection);
```

2. objektno orijentirano

```php
$mysqli = new mysqli('host','korisnik','lozinka','baza');

if ($mysqli->connect_error) {
  die('Konekcija na bazu nije uspjela: ' . $mysqli->connect_error);
}

$sqlUpit = "SELECT * FROM korisnici";

$rezultati = $mysqli->query($sqlUpit);

while($row = $rezultati->fetch_assoc()) {
  echo $row['ime'] . ' ' . $row['prezime'] . '\n';
}

$mysqli->close();
```

3. izrada vlastite klase
```php
class Db {
  private $host = 'localhost:3306';
  private $korisnik = 'root';
  private $lozinka = 'vasaDugaLozinka';
  private $baza = 'videoteka';
  private $konekcija;

  public function __construct() {
    $this->connect();
  }

  public function connect() {
    $this->konekcija = new mysqli(
      $this->host,
      $this->korisnik,
      $this->lozinka,
      $this->baza,
    );

    if ($this->konekcija->connect_error) {
      throw new Exception('Konekcija na bazu nije uspjela: ' . $this->konekcija->connect_error);
    }
  }

  public function getKonekcija() {
    return $this->konekcija;
  }

  public function query($sqlUpit) {
    $rezultati = $this->konekcija->query($sqlUpit);

    if (!$rezultati) {
      throw new Exception('Greška u upitu: ' . $this->konekcija->error);
    }

    return $rezultati;
  }

  public function close() {
    if ($this->konekcija) {
      $this->konekcija->close();
    }
  }

  public function __destruct() {
    $this->close();
  }
}

try {
  $db = new Db();
  $rezultati = $db->query("SELECT * FROM korisnici");
  while($row = $rezultati->fetch_assoc()) {
    echo $row['ime'] . ' ' . $row['prezime'] . '\n';
  }
} catch(Exception $e) {
  echo 'Greška: ' . $e->getMessage();
}
```

#### Izbjegavanje SQL injection napada

**LOŠE**
```php
$username = $_POST['username'];
$query = "SELECT * FROM korisnici WHERE username = '$username'";
```

**MALO BOLJE**
```php
$username = $mysqli->real_escape_string($_POST['username']);
$query = "SELECT * FROM korisnici WHERE username = '$username'";
```

**NAJBOLJE** -> prepared statements
```php
$stmt = $this->mysqli->prepare("SELECT id, ime, email FROM korisnici WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
```

#### Prepared statements
Prepared statementi su pripremljeni SQL upiti odnosno naredbe, a ujedno su i najsigurniji način izvršavanja SQL upita jer:
- sprječavaju SQL injection napade
- poboljšavaju performanse za ponavljajuće upite
- omogućuju čišći kod

primjer SQL injection napada
```php
$username = $_POST['username'];
// ...ostatak koda
$sqlUpit = "SELECT * FROM korisnici where username = $username";

// korisnik potencijalno može ubaciti maliciozan kod i izmjeniti prepostavljeno ponašanje našeg upita
// tako na primjer u polje username može ubaciti sljedeći kod: "a OR '1' = '1'"
// kada se taj kod ubaci u naš SQL query, on će izgledati ovako:
SELECT * FROM korisnici where username = a OR '1' = '1';
// ...ostatak koda
```

4 faze koje se dešavaju kod upita na SQL bazu:
1. parsiranje (analiza i provjera sintakse)
2. validacija (ima li trenutni korisnik potrebna prava za ovaj upit te postoje li sve tablice u bazi koja je navedena)
3. optimizacija (koje indekse koristiti da najbolje iskoristim resurse za ovaj upit)
4. izvršavanje (dohvaćanje podataka iz upita)

Prepared statementi za nas pripremaju prve 3 faze obrade SQL upita te se svaki proslijedeni parametar tretira kao string koji ne može promijeniti ponašanje SQL upita. Zatim nakon pripreme upita ostaje samo izvršavanje upita što može znatno poboljšati performanse.

Tipovi parametara za bind_param metodu:
- i - integer
- d - double
- s - string
- b - blob (binarni podaci)

```php
class UserManager {
  private $mysqli;

  public function __construct($mysqli) {
    $this->mysqli = $mysqli;
  }

  public function getUserById($id) {
    // pripremi upit
    $stmt = $this->mysqli->prepare("SELECT * FROM korisnici WHERE id = ?");

    if (!$stmt) {
      throw new Exception('Greška prilikom izrade statementa: ' . $this->mysqli->error);
    }

    // dodaj parametre
    $stmt->bind_param('i', $id);

    // izvrši upit
    $stmt->execute();

    // dohvati rezultate
    $rezultati = $stmt->get_result();

    // dohvati usera
    $user = $rezultati->fetch_assoc();

    $stmt->close();
    return $user;
  }

  public function createUser($ime, $prezime) {
    // pripremi upit
    $stmt = $this->mysqli->prepare("INSERT INTO korisnici (ime, prezime) VALUES (?, ?)");

    if (!$stmt) {
      throw new Exception('Greška prilikom izrade statementa: ' . $this->mysqli->error);
    }

    // dodaj parametre
    $stmt->bind_param('ss', $ime, $prezime);

    // izvrši upit
    if (!$stmt->execute()) {
      throw new Exception('Greška prilikom izvršavanja statementa: ' . $this->mysqli->error);
    }

    $insertId = $this->mysqli->insert_id;

    $stmt->close();
    return $insertId;
  }
}
```

#### Transakcije
Tranasakcije su skup SQL naredbi koje tvore jednu atomsku operaciju - ili se sve izvrši uspješno ili se ništa ne izvrši.

```php
class BankovniTransfer {
  private $mysqli;

  public function __construct($mysqli) {
    $this->mysqli = $mysqli;
  }

  public function prebaciNovac($racunPosiljatelja, $racunPrimatelja, $iznos) {
    // započni transakciju
    $this->mysqli->autocommit(false);

    try {
      // provjeri ima li pošiljatelj dovoljno novca na računu
      $stmt = $this->mysqli->prepare("SELECT stanje FROM racuni WHERE iban = ?");
      $stmt->bind_param('s', $racunPosiljatelja);
      $stms->execute();
      $rezultat = $stmt->get_result();
      $stanjeRacuna = $rezultat->fetch_assoc();
      $stmt->close();

      if ($stanjeRacuna['stanje'] < $iznos) {
        throw new Exception('Nedovoljan iznos novca na računu.');
      }

      // oduzmi novac s pošiljateljevog računa
      $stmt = $this->mysqli->prepare("UPDATE racuni SET stanje = stanje - ? WHERE iban = ?");
      $stmt->bind_param('ds', $iznos, $racunPosiljatelja);
      if (!$stmt->execute()) {
        throw new Exception('Greška prilikom oduzimanja novca sa stanja pošiljatelja: ' . $this->mysqli->error);
      }
      $stmt->close();

      // dodaj novac na primateljev račun
      $stmt = $this->mysqli->prepare("UPDATE racuni SET stanje = stanje + ? WHERE iban = ?");
      $stmt->bind_param('ds', $iznos, $racunPrimatelja);
      if (!$stmt->execute()) {
        throw new Exception('Greška prilikom dodavanja novca na stanje primatelja: ' . $this->mysqli->error);
      }
      $stmt->close();

      // potvrdi transakciju
      $this->mysqli->commit();
      return true;
    } catch(Exception $e) {
      // vrati sve promjene na početno stanje
      $this->mysqli->rollback();
      throw $e;
    } finally {
      $this->mysqli->autocommit(true);
    }
  }
}
```

### PDO (PHP Data Objects)
Moderna PHP ekstenzija za rad s bazama podatka. To je apstraktni sloj za pristup bazama podataka koji omogućuje rad s različitim tipovima baza podataka koristeći isti kod.
PDO podržava: MySQL, PostgreSQL, SQLite, Oracle DB, Microsoft SQL server...

Prednosti PDO-a u odnosu na MySQLi:
1. nezavisnost o bazi podataka (database agnostic) - isti kod za rad s različitim bazama
2. objektno orijentiran pristup - čišći kod (nije prednost, više značajka)
3. bolje rukovanje greškama (bolji error handling)
4. imenovani parametri (named parameters) - umjesto ? koriste se imenovani parametri kod prepared statementa
5. različiti modovi dohvaćanja podataka - veća fleksibilnost

Razlike MySQLi-a u odnosu na PDO:
```php
// mysqli
$mysqli = new mysqli('localhost', 'username', 'password', 'baza');
$stmt = $mysqli->prepare("SELECT * FROM korisnici WHERE id = ?");
$stmt->bind_param('i', $id);

// PDO
$pdo = new PDO('mysql:host=localhost;dbname=korisnici', 'username', 'password');
$stmt = $pdo->prepare("SELECT * FROM korisnici WHERE id = :id");
$stmt->bind_param(':id', $id);
```

Primjer PDO konekcije
```php
class DbPDO {
  private $host = 'localhost';
  private $username = 'vasKorisnik';
  private $password = 'vasaLozinka';
  private $baza = 'imeBaze';
  private $pdo;

  public function __construct() {
    $this->connect();
  }

  public function connect() {
    $konekcija = "mysql:host={$this->host};dbname={$this->baza}";
    // $konekcija = "pgsql:host={$this->host};dbname={$this->baza}";
    // $konekcija = "sqlite:/putanja/do/baze.db";
    // $konekcija = "sqlsrv:Server={$this->host};Database={$this->baza}";

    $opcije = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false
    ];

    try {
      $this->pdo = new PDO($konekcija, $this->username, $this->password, $opcije);
    } catch(PDOException $e) {
      throw new Exception('Konekcija nije uspjela: ' . $e->getMessage());
    }
  }

  public function getPdo() {
    return $this->pdo;
  }
}
```

PDO opcije:
1. `PDO::ATTR_ERRMODE` - definira hoće li PDO baciti grešku ili će (kao po defaultu) ne javiti ništa
2. `PDO::ATTR_DEFAULT_FETCH_MODE` - definira standardni format u kojem će PDO vraćati retke iz baze
3. `PDO::ATTR_EMULATE_PREPARES` - definira hoće li PDO "glumiti" prepared statemente ili će stvarno koristiti prave, nativne prepared statemente
4. `PDO::ATTR_PERSISTENT` - definira hoće li PDO stvoriti stalnu konekciju koja se neće zatvoriti nakon završetka skripte
5. `PDO::ATTR_INIT_COMMAND` - definira naredbu koja će se izvršiti ofmah nakon uspostave konekcije
6. `PDO::ATTR_TIMEOUT` - definira vrijeme u sekundama nakon kojeg se prekida konekcija ako baza ne odgovori
7. `PDO::ATTR_CASE` - definira hoće li imena stupaca u vraćenim rezultatima biti definirana velikim, malim slovima ili onako kako su zapisana u bazi
8. `PDO::ATTR_STRINGIFY_FETCHES` - definira hoće li sve vrijednosti dohvaćene iz baze biti pretvorene u stringove

Osnovne PDO metode:
1. `exec()` - metoda za upite koji ne vraćaju rezultate (npr. kreiranje nove tablice, pogleda i sl.)
2. `query()` - metoda za statičke upite odnosno upite koji ne primaju parametre (npr. dohvati sve zaposlenike)
3. `prepare()` - metoda za dinamičke upite u koje prosljedujemo parametre
4. `execute()` - metoda za izvršavanje upita na bazi
5. `bind_param()` - metoda za dodavanje parametara u prepared statemente
6. `setAttribute()` - metoda za postavljanje atributa tj. opcija na PDO konekciju
7. `getAttribute()` - metoda za dohvaćanje atributa
8. `beginTransaction()` - metoda za pokretanje transakcija
9. `commit()` - metoda za trajno spremanje svih promjena uzrokovanih izvršavanjem upita na bazi unutar transakcije
10. `fetch()` - metoda za dohvaćanje jednog(prvog sljedećeg) rezultata nakon izvršavanja `execute()` metode nad statementom
11. `rowCount()` - metoda za dohvaćanje ukupnog broja redaka iz baze koje smo dohvatili

--- 

## TDD (Test Driven Development)
TDD je pristup programiranju u kojem prvo pišete testove pa tek onda glavni kod. Dakle, polazi se od zahtjeva koje aplikacija treba ispuniti pa se tek onda implementira samo rješenje.

Prednosti:
1. bolja kvaliteta koda - kod je sam po sebi dizajniran da bude testabilan
2. manje bugova - problemi se otkrivaju odmah kod pisanja implementacije
3. bolja dokumentacija - testovi mogu poslužiti kao "živa" dokumentacija
4. jednostavniji refactoring - bez straha od novih bugova
5. bolji dizajn - prisiljava nas da razmišljamo prvo o sučeljima pa tek onda o implementaciji

Proces TDD-a je podijeljen u 3 faze:
1. RED faza - napišemo test (koji neće prolaziti jer implementacija na postoji)
2. GREEN faza - napišemo najmanji mogući kod da test prode (npr. hardkodiramo vrijednosti samo da test prode)
3. REFACTOR faza - poboljšavamo kod(implementiramo i mijenjamo implementaciju) bez mijenjanja funkcionalnosti

Proces TDD-a izgleda otprilike ovako:
RED -> GREEN -> REFACTOR -> RED -> GREEN -> REFACTOR -> RED -> GREEN -> REFACTOR -> ...

TDD najbolje prakse:
1. pišite najjednostavniji test koji pada
2. pišite najjednostavniji i najmanji mogući kod da test prode
3. jedan test = jedna stvar - testirajte samo jednu funkcionalnost po testu
4. pišite deskriptivne nazive testova
5. AAA pattern
    - Arrange - postavite podatke (mockajte podatke da reflektiraju stvarno stanje)
    - Act - izvedite akciju (pozivanje metoda na klasama i slično)
    - Assert - provjerite rezultat (usporedite očekivano i dobiveno)

Kada koristiti TDD?
- nova funcionalnost
- složena logika
- kritični dijelovi aplikacije
- refactoring postojećeg koda

Kada ne koristiti TDD?
- prototipovi
- eksperimenti
- jednostavne CRUD aplikacije
- hitni bugfixevi

Problemi u TDD: 
- testovi usporavaju razvoj - na početku znaju usporiti, ali kasnije mogu čak i ubrzati
- previše testova - potrebno se fokusirati ne bitne funkcionalnosti
- testovi su krhki - potrebno testirati ponašanje, a ne implementaciju
- ne znamo što treba testirati - potrebno početi od tzv. happy path scenarija tj. najjednostavnijeg i najočitijeg scenarija za neki test

### Composer
Composer je dependency manager za PHP odnosno alat za upravljanje vanjskim bibliotekama (paketima) koje vaš projekt koristi. Composer je poput AppStorea za vaš PHP projekt.

Prednosti korištenja composera:
- jednostavna instalacija paketa
- jednostavost pohranjivanja informacija o projektu u `composer.json` i `composer.lock` fileove
- ručno preuzimanje i uključivanje biblioteka prepušteno composeru
```php
// bez composera
require 'vendor/phpunit/phpunit/phpunit.php';
require 'vendor/monolog/monolog/src/logger.php';
... i tako dalje za sve pakete koje želimo koristiti u našoj aplikaciji

// s composerom
require 'vendor/autoload.php';
```

`composer.json`
```php
{
  "name": "MojProjekt/Calculator",
  "description": "Jednostavan kalkulator s testovima",
  "type": "project",
  "require": {
    "php": ">=8.0"
  },
  "require-dev": {
    "phpunit/phpunit": "^12"
  },
  "autoload": {
    "psr-4": {
      "MojProjekt\\": "src/"
    }
  },
  "autoload-dev": {
    "psr-4": {
      "MojProjekt\\Tests\\": "tests/"
    }
  },
  "scripts": {
    "test": "phpunit"
  }
}
```

- name - jedinstveno ime projekta
- description - opis projekta
- require - popis paketa potrebnih u produkciji
- require-dev - popis paketa potrebnih tijekom developmenta (testovi, alati...)
- autoload - vrši mapiranje namespacesa na direktorije
- autoload-dev - vrši autoload za development (testovi)
- scripts - dodavanje naredbi radi jednostavnijeg pokretanja često korištenih radnji tijekom developmenta

Osnovna struktura foldera uz composer:
```sh
MojProjekt/
|-- comopser.json  - metapodaci o našem projektu
|-- composer.lock  - točne, zaključane verzije korištenih paketa (uvijek commitati na git)
|-- vendor/  - folder s instaliranim paketima
|   |-- autoload.php  - glavni autoloader
|   |-- phpunit/
|   |__ ...folderi ostalih paketa
|-- src/  - naš kod
|   |__ Calculator.php
|-- tests/  - naši testovi
|   |__ CalculatorTest.php
|__ phpunit.xml  - konfiguracija za PHPUnit
```

#### Stvaranje novog projekta u praksi:
1. kreiranje direktorija - `mkdir MojProjekt && cd MojProjekt`
2. inicijalizacija composera - `composer init`
3. dodavanje PHPUnita - `composer require --dev phpunit/phpunit`
4. dodavanje src i tests direktorija - `mkdir src && mkdir tests`

### PHPUnit
PHPUnit je standard za izvršavanje unit testova u PHP-u. Unit testovi su testovi koji testiraju ponašanje koda odnosno neke funkcionalnosti u izolaciji (bez interakcije s ostalim dijelovima aplikacije).

On nam omogućuje da:
- pišemo i pokrećemo unit testove
- generiramo code coverage izvještaje (izvještaji o pokrivenosti koda testovima)
- koristimo mock objekte (za hardkodirane podatke prilikom testiranja)
- testiramo s fixtures i data providers (pomoćne funkcionalnosti unutar PHPUnita za bolje testiranje)

Proces instalacije:
- instalacija - `composer require --dev phpunit/phpunit`
- provjera instalacije - `./vendor/bin/phpunit --version`
- stvaranje `phpunit.xml` datoteke

#### `phpunit.xml` konfiguracija
```xml
<?xml version="1.0" encoding="UTF-8" ?>
<phpunit 
  bootstrap="vendor/autoload.php"
  xsi:noNamespaceSchemaLocation="https://schema.phpunit.de/9.3/phpunit.xsd"
  cacheResultFile=".phpunit.cache/test-results"
  executionOrder="depends,defects"
  beStrictAboutOutputDuringTests="true"
  beStrictAboutTodoAnnotatedTests="true"
  convertDeprecationsToExceptions="true"
  failOnRisky="true"
  failOnWarning="true"
  verbose="true"
>
  <testsuites>
    <testsuite name="default">
      <directory suffix="Test.php">tests</directory>
    </testsuite>
  </testsuites>

  <coverage 
    cacheDirectory=".phpunit.cache/code-coverage"
    processUncoveredFiles="true"
  >
    <include>
      <directory suffix=".php">src</directory>
    </include>
    <exclude>
      <directory>vendor</directory>
    </exclude>
  </coverage>

  <php>
    <env name="APP_ENV" value="testing"/>
    <server name="SERVER_NAME" value="localhost"/>
  </php>
</phpunit>
```
- `bootstrap` - atribut koji govori gdje se nalazi autoloader datoteka
- `testsuites` - definira gdje se nalaze testovi
- `coverage` - definira postavke za code coverage
- `php` - definira environment varijable za testove


Fixtures su pomoćne metode unutar testova koje se fokusiraju na okolinu odnosno pripremu i čišćenje okoline u kojoj se testovi izvršavaju. Dakle, u tim metodama najčešće se pripremaju konekcije, stvaraju klase, čiste resursi, brišu stvorene datoteke i slično.

DataProviders su anotacije koje se fokusiraju na podatke potrebne u testovima. Oni se referiraju na stvorene funkcije koje nam proslijeduju podatke potrebne za višestruko izvršavanje istog testa.

#### Primjer unit testa
```php
<?php

namespace MojProjekt\Tests;

use PHPUnit\Framework\TestCase;
use MojProjekt\Calculator;

class CalculatorTest extends TestCase {
  private Calculator $caculator;

  // fixture koji se izvršava prije svakog testa
  protected function setUp() : void {
    $this->calculator = new Calculator();
  }

  // fixture koji se izvršava nakon svakog testa
  protected function tearDown() : void {
    $this->calculator = null;
  }

  // fixture koji se izvršava prije svih testova u klasi
  public static function setUpBeforeClass() {
    // priprema podatka, konekcija na test bazu i sl.
  }

  // fixture koji se izvršava nakon svih testova u klasi
  public static function tearDownAfterClass() {
    // čišćenje resursa - npr. brisanje datoteka kreiranih kroz testove
  }

  public function testAddTwoNumbers() : void {
    $result = $this->calculator->add(2,3);
    $this->assertEquals(5, $result);
  }
}
>
```

#### Osnovne naredbe (osnovne metode)
Jednakost:
- assertEquals - `$this->assertEquals($očekivaniRezultat, $rezultatMetode)`
- assertSame - `$this->assertSame($očekivaniRezultat, $rezultatMetode)` (stroža provjera od assertEquals)

Booleans:
- assertTrue - `$this->assertTrue($calculator->isBiggerThan(4,3))` (provjerava li argument True)
- assertFalse - `$this->assertFalse($calculator->isLessThan(4,3))` (provjerava li argument false)

Null:
- assertNull - (provjerava je li argument null)
- assertNotNull - (provjerava je li argument različit od null)

Nizovi:
- assertContains - (provjerava sadržava li niz traženi argument)
- assertCount - (provjerava je li dužina array argumenta odgovara prvom argumentu)
- assertEmpty - (provjerava je li array argument prazan)

Stringovi:
- assertStringContains - (provjerava sadrži li string traženi argument)
- assertStringStartsWith - (provjerava započinje li string traženim argumentom)
- assertMatchesRegularExpression - (provjerava ispunjava li proslijedeni argument zadani regularni izraz)

Objekti:
- assertInstanceOf - (provjerava je li proslijedeni objekt instanca proslijedene klase)

Datoteke:
- assertFileExists - (provjerava postoji li datoteka na proslijedenoj ruti)

Iznimke:
- expectException - (provjerava baca li kod iznimku)
- expectExceptionMessage - (provjerava sadrži li iznimka traženu poruku)

#### Pokretanje testova (pokretanje u terminalu)
- svi testovi - `./vendor/bin/phpunit`
- specifična test klasa - `./vendor/bin/phpunit tests/CalculatorTest.php`
- specifičan test - `./vendor/bin/phpunit --filter testAdd`
- s code coverageom - `./vendor/bin/phpunit --coverage-html coverage`
- s detaljnijim outputom - `./vendor/bin/phpunit --verbose`
- testovi po grupama - `./vendor/bin/phpunit --group integration`
- s izostavljenom grupom - `./vendor/bin/phpunit --exclude-group slow`

#### Data providers
To su kombinacija anotacije naveden u komentaru i definirane metode u samoj klasi testa. Data provideri služe situaciji kada moramo istestirati jednu funkcionalnost s više različitih setova podataka da bismo istestirali sve scenarije koji se mogu desiti.

Primjer s data providerom i grupiranjem:

```php

<?php
class CalculatorTest extends TestCase {
  use PHPUnit\Framework\Attributes\DataProvider;
  /*
  * @group slow - anotacija za grupiranje testova
  * @dataProvider dodatniPodaci (ili ovaj drugi način)
  */
  #[DataProvider('pruziPodatke')]
  public static function dodatniPodaci() : array {
    return [
      'pozitivniBrojevi' => [1, 2, 3], // testAddTwoNumbers(1,2,3);
      'negativniBrojevi' => [-1, -2, -3],
      'nule' => [0, 0, 0],
      ...
    ]
  }

  public function testAddTwoNumbers(int $a, int $b, int $expected) : void {
    $calulator = new Calculator();
    $result = $calculator->add($a, $b);
    $this->assertEquals($expected, $result);
  }
}

```

#### Ostali korisni materijali vezani uz testove

PHPUnit najbolje prakse:
1. jedan koncept po testu - testirajte jednu stvar
2. deskriptivni nazivi testova i klasa
3. AAA pattern - arrange, act, assert
4. neovisni testovi - svaki test treba biti neovisan
5. brzi testovi - brzo izvršavanje


Primjeri dobro i loše imenovanih testova:
- `public function testUser() : void` - loše jer je preopćenito i nejasno što se testira
- `public function testCreateUserWithValidDataReturnsUserObject() : void` - dobro jer detaljno opisuje što točno testiramo i što očekujemo od testa

- `public function testCalculate() : void` - loše
- `public function testCalculateDiscountForPremiumUserWith20PercentRate() : void` - dobro

- `public function testLoginWithInvalidPasswordThrowsAuthException() : void` - dobro
- `public function testMethod() : void` - loše



Obični se testovi vode AAA patternom, ali ovisno o načinu i korištenju alata za testiranje, pattern može biti i Given-When-Then. Pri tome Given odgovara Arrange-u, When odgovara Act-u, a Then odgovara Assert-u. 

Najbolje prakse za definiranje testova:
1. jedan test = jedan za razlog za pad - testiraj jednu stvar po testu
2. neovisnost testova - testovi ne smiju ovisiti jedan o drugom niti o vanjskim resursima
3. ponovljivost - test uvijek mora dati isti rezultat
4. brzina - test bi se trebao izvršiti do 100ms
5. čitljivost - test mora biti lako razumljiv

Primjeri problema i kako ih izbjeći
```php
public function testGetUserFromDatabase() : void {
  $pdo = new PDO('mysql:host=localhost;dbname=testdb', 'user', 'pass');
  // LOŠE - ovisi o nekoj stvarnoj, produkcijskoj bazi
}

public function testGetUserFromDatabase() : void {
  $pdo = new PDO(sqlite::memory);
  // DOBRO - test ne ovisi o nekom vanjskom resursu
}

public function testUserCompleteWorkflow() : void {
  $user = $this->userService->createUser($data);
  $this->userService->activateUser($user);
  $this->userService->sendWelcomeEmail($user);
  // LOŠE - testiramo više funkcionalnosti u jednom testu
}

// DOBRO - sljedeći testovi su dobri jer su funkcionalnosti odvojene po testovima
public function testCreateUser() : void {}
public function testActivateUser() : void {}
public function testSendWelcomeEMail() : void {}
```

Kako provjeriti je li test kvalitetno napisan:
1. Ima li test jasan, deskriptivan naziv?
2. Je li test neovisan o drugim testovima?
3. Testira li test jednu, specifičnu stvar?
4. Koriste li se deskriptivni nazivi varijabli?
5. Ima li test `assert` koji provjerava neku važnu funkcionalnost?
6. Jesu li test podaci realistični?
7. Jesu li edge-casevi pokriveni?
8. Je li error handling testiran?
9. Koriste li se mockani podaci ispravno?
10. Je li test brz?