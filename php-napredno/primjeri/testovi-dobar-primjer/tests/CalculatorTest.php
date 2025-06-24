<?php
namespace TestoviDobarPrimjer\Tests;

use PHPUnit\Framework\TestCase;
use TestoviDobarPrimjer\Calculator\Calculator;

class CalculatorTest extends TestCase {
  /*
   * @dataProvider pruziPodatke
   */
  private Calculator $calculator;

  protected function setUp() : void {
    // Arrange
    $this->calculator = new Calculator();
  }

  public function pruziPodatke() : array {
    return [
      'pozitivniBrojevi' => [10, 20, 30],
      'negativniBrojevi' => [-5, -7, -12],
      'nule' => [0, 0, 0],
      'pozitivniINegativniBrojevi' => [10, -20, -10],
      'negativniIPozitivniBrojevi' => [-40, 50, 10]
    ];
  }

  public function testAdd(int $a, int $b, int $expected) : void {
    $result = $this->calculator->add($a, $b);
    $this->assertSame($result, $expected);
  }

  protected function tearDown() : void {
    $this->calculator = null;
  }

  public static function setUpBeforeClass() : void {}

  public static function tearDownAfterClass() : void {}
}