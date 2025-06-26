<?php

namespace Testovi\Posiljatelj;

class Posiljatelj {
  public int $tretnutnoStanje;

  public function __construct(int $pocetnoStanje) {
    $this->tretnutnoStanje = $pocetnoStanje;
  }

  public function provjeriStanje(int $iznosSlanja) {
    return $iznosSlanja <= $this->tretnutnoStanje;
  }

  public function posaljiNovac($iznosSlanja) {
    $this->promijeniStanje();
  }

  public function promijeniStanje($iznosSlanja) {
    if ($this->provjeriStanje($iznosSlanja)) {
      $this->tretnutnoStanje -= $iznosSlanja;
    }
    return;
  }
}