<?php

namespace Testovi\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

use Testovi\Posiljatelj;

class PosiljateljTest extends TestCase {
  public ?Posiljatelj $posiljatelj;

  protected function setUp() : void {
    // pokreće se prije svakog testa
    // Arrange (ili Given)
    $this->posiljatelj = new Posiljatelj(2000);
  }

  public static function dodajPodatkeZaSlanje() {
    return [
      'uspjesanPrijenos' => [2000, 100, 1900],
      'uspjesanPrijenosUzFinalnoStanje0' => [2000, 2000, 0],
      'neuspjesanPrijenosNedovoljnoStanje' => [2000, 2100, 2000]
    ];
  }

  #[DataProvider('dodajPodatkeZaSlanje')]
  public function testPosaljiNovac(int $trenutnoStanje, int $iznosSlanja, int $zavrsnoStanje) : void {
    // Act
    $zavrsniKonto = $this->posiljatelj->posaljiNovac($iznosSlanja);
    // Assert
    $this->assertEqual($zavrsnoStanje, $zavrsniKonto);
  }

  public static function dodajPodatkeZaProvjeruStanja() {
    return [
      'true' => [2000, 100, true],
      'false' => [2000, 2100, false]
    ];
  }

  #[DataProvider('dodajPodatkeZaProvjeruStanja')]
  public function testProvjeriStanje(int $trenutnoStanje, int $iznosSlanja, bool $jeDovoljno) : void {
    $jeDovoljnoStanje = $this->posiljatelj->provjeriStanje($iznosSlanja);
    $this->assetTrue($jeDovoljno, $jeDovoljnoStanje);
  }

  public static function dodajPodatkeZaPromjenuStanja() {
    return [
      'promijeniUspjesno' => [2000, 100, 1900],
      'promijeniNeuspjesno' => [2000, 2100, 2000]
    ];
  }

  #[DataProvider('dodajPodatkeZaPromjenuStanja')]
  public function testPromijeniStanje(int $trenutnoStanje, int $iznosSlanja, int $zavrsnoStanje) : void {
    $zavrsniKonto = $this->posiljatelj->promijeniStanje($iznosSlanja);
    $this->assetEqual($zavrsnoStanje, $zavrsniKonto);
  }

  protected function tearDown() : void {
    $this->posiljatelj = null;
  }
}