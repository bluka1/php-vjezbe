<?php

class Iznimka extends Exception {
  public $message;
  // public function __construct($message, Exception $previous, $code) {
  //   parent::__construct($message, $previous, $code);
  // }

  public function __construct($message) {
    $this->message = $message;
  }

  public function __toString() {
    return __CLASS__ . ": $this->message";
  }
}

class KorisnikNePostojiIznimka extends Exception {}

class NedovoljnoStanjeRacunaIznimka extends Exception {}

function dohvatiKorisnika(int $id) {
  if ($id < 0) {
    throw new InvalidArgumentException('ID korisnika mora biti pozitivan broj.');
  }

  $korisnikPostoji = false; // ...kod koji dohvaca tj. provjerava postoji li korisnik (rizicna operacija)

  if (!$korisnikPostoji) {
    // throw new KorisnikNePostojiIznimka("Korisnik s ID-em $id ne postoji.");
    throw new Iznimka("Korisnik s ID-em $id ne postoji.");
  }

  // return dohvatiKorisnikaIzBaze($id);
}

dohvatiKorisnika(1);

$broj = null;