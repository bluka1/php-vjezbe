<?php
namespace Math\Geometry;

class Circle {
  public $radius;

  public function __construct($radius) {
    $this->radius = $radius;
  }

  public function getDiameter() {
    return $this->radius * 2;
  }

  public function getArea() {
    // (r^2*PI)
    return $this->radius ** 2 * \Math\Constants::PI;
  }

  public function getCircumference() {
    // 2rPI
    return $this->radius * 2 * \Math\Constants::PI;
  }
}