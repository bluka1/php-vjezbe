<?php

// kreirajte funkciju koja baca error(Exception)
function provjeriBroj($broj) {
  if ($broj > 1) {
    throw new Exception('Broj mora biti 1 ili manji');
  }
  return true;
}

// dodajte try-catch blok i hendlajte (ispišite) poruku errora
try {
  provjeriBroj(2);
} catch(Exception $e) {
  echo $e->getMessage();
}
echo '<br>';
echo '<br>';
echo '<br>';

// napravite vlastitu exception klasu koja nasljeduje Exception klasu i dodajte metodu errorMessage()
// ta metoda treba ispisivati podatke o liniji i datoteci gdje je greška nastala te mora ispisivati poruku
// hint: getLine(), getFile(), getMessage() su metode na Exception objektu kojima možete pristupiti

class CustomException extends Exception {
  public function errorMessage() {
    return "Linija greške: " . $this->getLine() . "\n" . "File u kojem je nastala greška: " . $this->getFile() . "\n" . "Broj " . $this->getMessage() . " je veći od 1.";
  }
}

function baciGresku($broj) {
  if ($broj > 1) {
    throw new CustomException($broj);
  }
  return true;
}

try {
  baciGresku(2);
} catch(CustomException $e) {
  echo $e->errorMessage();
}