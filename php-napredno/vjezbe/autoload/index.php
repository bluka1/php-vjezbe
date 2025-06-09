<?php

include 'autoload.php';

use Fruits\Apple;
use Fruits\Orange;
use Fruits\Banana;

$apple = new Apple();
$orange = new Orange();
$banana = new Banana();

echo $apple->fruit;
echo '<br>';
echo $orange->fruit;
echo '<br>';
echo $banana->fruit;