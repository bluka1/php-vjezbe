<?php

// napravite interface Sir
// mora imati 3 metode: kuhaj(), cijedi(), susi()
// napravite 3 razlicita sira koji u metodama ispisuju razlicite vrijednosti vremena potrebnog za radnju o kojoj se radi
// napravite SirFactory klasu koja instancira sireve
// napravite 3 objekta i pogledajte što se ispisalo na ekranu

interface Sir {
  public function kuhaj();
  public function cijedi();
  public function susi();
}

class Zrnati implements Sir {
  public function kuhaj() {
    echo '5 minuta';
  }
  public function cijedi() {
    echo '15 minuta'; 
  }
  public function susi() {
    echo '7 minuta';
  }
}

class Skripavac implements Sir {
  public function kuhaj() {
    echo '30 minuta';
  }
  public function cijedi() {
    echo '40 minuta'; 
  }
  public function susi() {
    echo '60 minuta';
  }
}

class Parmezan implements Sir {
  public function kuhaj() {
    echo '60 minuta';
  }
  public function cijedi() {
    echo '90 minuta'; 
  }
  public function susi() {
    echo '180 minuta';
  }
}

// class SirFactory {
//   public static function napraviSir($vrsta) {
//     switch($vrsta) {
//       case 'zrnati':
//         return new Zrnati();
//       case 'skripavac':
//         return new Skripavac();
//       case 'parmezan':
//         return new Parmezan();
//       default: 
//         throw new InvalidArgumentException('Ne postoji vrsta sira: ' . $vrsta);
//     }
//   }
// }

// $zrnati = SirFactory::napraviSir('zrnati');
// $skripavac = SirFactory::napraviSir('skripavac');
// $parmezan = SirFactory::napraviSir('parmezan');

class SirFactory {
  public function napraviSir($vrsta) {
    switch($vrsta) {
      case 'zrnati':
        return new Zrnati();
      case 'skripavac':
        return new Skripavac();
      case 'parmezan':
        return new Parmezan();
      default: 
        throw new InvalidArgumentException('Ne postoji vrsta sira: ' . $vrsta);
    }
  }
}

$sirFactory = new SirFactory();
$zrnati = $sirFactory->napraviSir('zrnati');
$skripavac = $sirFactory->napraviSir('skripavac');
$parmezan = $sirFactory->napraviSir('parmezan');

$zrnati->susi();
$skripavac->susi();
$parmezan->susi();