<?php

// napravite jedno sučelje Zivotinja
// napravite klasu koja implementira sučelje
// pozovite i ispišite rezultat implementirane metode

interface Zivotinja {
  public function pije();
}

class Pas implements Zivotinja {
  public function pije() {
    echo 'pije vodu';
  }
}

$pas = new Pas();
$pas->pije();