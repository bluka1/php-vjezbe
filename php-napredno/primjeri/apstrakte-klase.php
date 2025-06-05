<?php

abstract class Auto {
  protected $volumenTanka;

  public function setVolumenTanka($volumen) {
    $this->volumenTanka = $volumen;
  }

  abstract public function izracunajMaksimalnuDistancu();

  abstract public function ispisiNacinPaljenja();
}

class Rimac extends Auto {
  public function izracunajMaksimalnuDistancu() {
    return $this->volumenTanka * 100;
  }

  public function ispisiNacinPaljenja() {
    echo 'klik gumba';
  }
}

class Yugo extends Auto {
  public function izracunajMaksimalnuDistancu() {
    return $this->volumenTanka * 10;
  }

  public function ispisiNacinPaljenja() {
    echo 'stavi i okreni ključ';
  }
}

$rimac = new Rimac();

$rimac->setVolumenTanka(50);

echo $rimac->izracunajMaksimalnuDistancu();