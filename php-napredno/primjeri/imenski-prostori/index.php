<?php

include_once 'Math/Constants.php';
include_once 'Math/Geometry/Circle.php';

// bez use
$circle = new Math\Geometry\Circle(7);

echo $circle->getDiameter();
echo '<br>';
echo $circle->getArea();
echo '<br>';
echo $circle->getCircumference();
echo '<br>';


// koristeći use
use Math\Geometry\Circle;

$circle2 = new Circle(5);
// new Math\Geometry\Circle();

echo $circle2->getDiameter();
echo '<br>';
echo $circle2->getArea();
echo '<br>';
echo $circle2->getCircumference();
echo '<br>';

// koristeći alias
use Math\Geometry\Circle as C;

$c = new C(10);

echo $c->getDiameter();
echo '<br>';
echo $c->getArea();
echo '<br>';
echo $c->getCircumference();
echo '<br>';