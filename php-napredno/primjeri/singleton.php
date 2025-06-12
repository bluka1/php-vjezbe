<?php

// stvorite singleton klasu
// sprječite stvaranje novih instanci kroz metode koje to omogućuju
// dodajte static svojstvo koje će pratiti stanje instance
// napravite public metodu za kreiranje/vraćanje instance
// u konstruktoru ispišite nešto
// stvorite 3 instance i vidite ispis na ekranu

class Singleton {

  private static $instanca = null;

  private function __construct(){
    echo 'Stvorena nova instanca Singleton klase.';
  }

  public function __clone(){}
  public function __wakeup(){}

  public static function getInstancu() {
    if (self::$instanca === null) {
      self::$instanca = new self();
    }

    return self::$instanca;
  }
}

$instanca1 = Singleton::getInstancu();
$instanca2 = Singleton::getInstancu();
$instanca3 = Singleton::getInstancu();