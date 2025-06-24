<?php

require __DIR__ . '/../Calculator.php';

class CalculatorTest extends PHPUnit\Framework\TestCase {
  public function testAddTwoNumbers() {
    $calculator = new Calculator();
    $result = $calculator->add(3,4);
    $this->assertEquals(7, $result);
  }
}
