<?php
// prema PSR-4 standardu

// poanta autoloadera - includeati file umjesto nas (umjesto da to radimo manualno na vrhu svake skripte)

spl_autoload_register(function ($className) {
  // putanja do direktorija gdje se trenutno nalazimo tj. koji je polazišna točka za traženje klase
  $pocetniDirektorij = __DIR__ . '/src/';

  // odabiremo relativnu putanju do klase koju zelimo instancirati
  $putanjaDoKlase = str_replace('\\', '/', $className);

  $putanjaDoFilea = $pocetniDirektorij . $putanjaDoKlase . '.php';

  // odradimo provjeru postoji li ta klasa tj. taj file i zatim ga dohvacamo ako isti postoji
  if (file_exists($putanjaDoFilea)) {
    require $putanjaDoFilea;
  }
});