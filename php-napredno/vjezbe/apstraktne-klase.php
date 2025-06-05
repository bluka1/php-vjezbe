<?php

// definirajte apstraktnu klasu Osoba
// definirajte jedno normalno svojstvo
// definirajte jednu noramlnu metodu
// definirajte jednu apstraktnu metodu
// napravite child klasu Student
// napravite child klasu Profesor
// napravite instancu klase Student
// napravite instancu klase Profesor
// pozovite definirane metode

abstract class Osoba {
  public $dob;

  public function setDob($godine) {
    $this->dob = $godine;
  }

  abstract public function strucnaSprema();
}

class Student extends Osoba {
  public function strucnaSprema() {
    echo 'bacc.';
  }
}

class Profesor extends Osoba {
  public function strucnaSprema() {
    echo 'dr.sc.';
  }
}

$student = new Student();
$student->setDob(22);
$student->strucnaSprema();


echo '<br>';

$profesor = new Profesor();
$profesor->setDob(42);
$profesor->strucnaSprema();