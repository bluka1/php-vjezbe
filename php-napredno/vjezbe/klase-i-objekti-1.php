<?php

// deklarirajte klasu User
// deklarirajte public svojstvo name
// dekrarirajte getter i setter metode za to svojstvo
// napravite instancu klase
// pozovite definirane metode
// ispišite rezultat

class User {
  public $name;


  public function getName() {
    return $this->name;
  }

  public function setName($ime){
    return $this->name = $ime;
  }
}

$noviUser = new User();
$noviUser->setName('Luka');


echo $noviUser->getName();