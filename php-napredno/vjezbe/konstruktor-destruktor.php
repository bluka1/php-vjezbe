<?php

// kreirajte klasu Korisnik koja ima privatno svojstvo ime
// kreirajte konstruktor koji postavlja ime na vrijednost proslijedenu kod stvaranja objekta
// kreirajte getter metodu za svojstvo ime
// stvorite novi objekt iz klase Korisnik
// ispišite ime korisnika

class Korisnik {
  private $ime;

  public function __construct($_ime) {
    $this->ime = $_ime;
  }

  public function getIme() {
    return $this->ime;
  }
}

$noviKorisnik = new Korisnik('Luka');
echo $noviKorisnik->getIme();