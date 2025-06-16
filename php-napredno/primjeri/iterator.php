<?php

// eksterni iterator
class RijecniIterator implements Iterator {
  public $trenutnaPozicija = 0;
  public $objektKolekcije;

  public function __construct($objektKolekcije) {
    $this->objektKolekcije = $objektKolekcije;
  }

  public function current(): mixed {
    return $this->objektKolekcije->getRijeci()[$this->trenutnaPozicija];
  }

  public function key(): int {
    return $this->trenutnaPozicija;
  }

  public function next(): void {
    $this->trenutnaPozicija++;
    // $this->trenutnaPozicija = $this->trenutnaPozicija + 1;
  }

  public function rewind() : void {
    $this->trenutnaPozicija = 0;
  }

  public function valid(): bool {
    return isset($this->objektKolekcije->getRijeci()[$this->trenutnaPozicija]);
  }
}

// klasa koja koristi eksterni iterator
class KolekcijaRijeci implements IteratorAggregate {
  public $rijeci = [];

  public function __construct($rijeci) {
    $this->rijeci = $rijeci;
  }

  public function addRijec($rijec) {
    $this->rijeci[] = $rijec;
    // array_push($this->rijeci, $rijec);
  }

  public function getRijeci() {
    return $this->rijeci;
  }

  public function getIterator() : Iterator {
    return new RijecniIterator($this);
  }
}

// korištenje klase i ispisivanje vrijednosti
$kolekcija = new KolekcijaRijeci(['aaaa', 'bbbb', 'cccc', 'dddd']);

// iskorištavanje iteratora za ispis vrijednosti iz objekta
foreach($kolekcija->getIterator() as $element) {
  echo $element . '<br>';
}

// primjer nevezan uz implementaciju i korištenje iteratora
// class Rijeci {
//   public $rijeci = [];

//   public function __construct($rijeci) {
//     $this->rijeci = $rijeci;
//   }
// }

// $nizRijeci = new Rijeci(['aaa', 'bbb', 'ccc', 'ddd']);

// echo 'NIZ RIJEČI:';
// echo '<br>';

// foreach ($nizRijeci as $key=>$value) {
//   echo $key . ' ' . $value;
// }