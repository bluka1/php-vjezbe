<?php

// Declare the class
class Car {
  // svojstva
  public $comp;
  public $color = 'beige';
  public $hasSunRoof = true;

  private $mjenjac;
  protected $brzina;

  // metode
  public function showProps() {
    return $this->comp . ' ' . $this->color . ' ' . $this->hasSunRoof;
  }

  public function getMjenjac() {
    return $this->mjenjac;
  }

  public function setMjenjac($mjenjac) {
    // provjere
    return $this->mjenjac = $mjenjac;
  }
}

// kreiranje instance klase tj. objekta
$bmw = new Car();
$mercedes = new Car();

$bmw->comp = 'BMW';
$mercedes->comp = 'Mercedes';

// $bmw->mjenjac = 'manual'; - ne radi jer je private property
// $mercedes->mjenjac = 'automatic'; - takoder

// echo $bmw->mjenjac; - takoder 
// echo $mercedes->mjenjac; - takoder

// $bmw->brzina = 50;
// echo $bmw->brzina . '<br>';

$bmw->setMjenjac('manual');
$mercedes->setMjenjac('automatic');

echo $bmw->getMjenjac() . '<br>';
echo $mercedes->getMjenjac() . '<br>';

$bmw->color = 'black';
$mercedes->color = 'white';

// pristupanje svojstvima objekta
echo 'BMW AUTO COMPANY: ' . $bmw->comp . '<br>';

echo 'MERCEDES AUTO COMPANY: ' . $mercedes->comp . '<br>';

echo 'BMW AUTO COLOR: ' . $bmw->color . '<br>';

echo 'MERCEDES AUTO COLOR:' . $mercedes->color . '<br>';


class SportsCar extends Car {
  private $turbo = true;

  public function getBrzina() {
    return $this->brzina;
  }

  public function setBrzina($broj) {
    return $this->brzina = $broj;
  }
}

echo '<br>';
echo '<hr>';
echo '<h1>SPORTS CAR CLASS</h1>';
echo '<br>';

$sportsCar = new SportsCar();
$sportsCar->setBrzina(100);
$sportsCar->setMjenjac('automatic');
echo $sportsCar->getMjenjac();
echo $sportsCar->getBrzina();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <p><?php echo $bmw->showProps(); ?></p>
  <p><?php echo $mercedes-> showProps(); ?></p>

</body>
</html>