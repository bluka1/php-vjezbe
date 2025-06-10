<?php

// type error
function dupliraj(int $broj) {
  return $broj * 2;
}

try {
  dupliraj('nekiTekst');
} catch(TypeError $e) {
  echo 'Upisali ste pogrešnu vrijednost prilikom pozivanja funkcije.';
  // die();
}

echo '<br>';

echo 'Ostali kod...';

echo '<br>';

// division by zero error
try {
  $rez = 10 / 0;
} catch(DivisionByZeroError $e) {
  echo 'Nije dozvoljeno dijeliti s nulom.';
}

echo '<br>';

// argument count error
function zbroj(int $a, int $b, int $c) {
  return $a + $b + $c;
}

try {
  zbroj(1, 2, 3);
  zbroj(1, 2, 3, 4);
  zbroj(1, 2, 3, 4, 5);
  zbroj(1, 2);
} catch(ArgumentCountError $e) {
  echo 'Proslijedili ste nedovoljan broj argumenata';
  echo '<br>';
  echo $e->getMessage();
  echo '<br>';
  var_dump($e);
}

// nestani try-catch blokovi
try {
  // prva rizicnu operaciju
  try {
    // druga rizicna operacija temeljena na prvoj
  } catch (Exception $e) {
    // error handling za drugu rizicnu operaciju
  }
} catch(Exception $e) {
  // error handling za prvu rizicnu operaciju
}

// specifičniji error handling
try {
  // rizicna operacija
} catch(SpecificniException $e) {
  // error handling za specifični error
} catch(Exception $e) {
  // error handling općeniti error
}