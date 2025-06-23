<?php

// prvo definiramo test
class CalculatorTest extends PHPUnit\Framework\TestCase {
  public function testAddTwoNumbers() {
    $calcutor = new Calculator();
    $result = $calculator->add(2,3);
    $this->assertEquals(5, $result);
  }
}


// tek onda slijedi implementacija