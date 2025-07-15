<?php

namespace App\Services;

class OrderNumberGenerator {
  public function generate() : string {
    $randomNumber = rand(1000,9999);
    return "Order: {$randomNumber}";
  }

  public function echoing() : string {
    return 'Hello world!';
  }

  public function getRadnomNumber() : int {
    return rand(1000,10000);
  }
}