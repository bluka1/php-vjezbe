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

```
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

```
class Osoba {
  // svojstva
  public $ime;
  public $prezime;
}
```

### Metode
Metode su funkcije definirane unutar klase. One definiraju ponašanje odnosno funkcionalnosti objekta.
Deklariraju se na isti način kao i obične funkcije uz dodatak djelokruga.

```
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

```
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

```
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

```
unset($noviObjekt);
```