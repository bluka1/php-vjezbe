<?php

function izracunajBrojSlova($nekaRijec) {
  return strlen($nekaRijec);
}

function izracunajBrojSamoglasnika($nekaRijec) {
  $rijec = strtolower($nekaRijec);
  $samoglasnici = ['a', 'e', 'i', 'o', 'u'];
  $slovaURijeci = preg_split('//u', $rijec);

  $brojSamoglasnika = 0;
  foreach($slovaURijeci as $slovo) {
    if (in_array($slovo, $samoglasnici)) {
      $brojSamoglasnika++;
    }
  }
  // echo $brojSamoglasnika . '<br>';
  return $brojSamoglasnika;
}

function izracunajBrojSuglasnika($nekaRijec) {
  return izracunajBrojSlova($nekaRijec) - izracunajBrojSamoglasnika($nekaRijec);
}

function citajJsonDatoteku($filePath) {
  $wordsJson = file_get_contents($filePath, false);
  $nizRijeci = json_decode($wordsJson);
  return $nizRijeci;
}

function dodajRijec($word, $nizRijeci, $filePath) {
  $r = htmlspecialchars($word);

  $trimmedRijec = trim($r);
  if (strlen($trimmedRijec) === 0) return;

  $brojSlova = izracunajBrojSlova($trimmedRijec);
  // echo $brojSlova . '<br>';

  $brojSamoglasnika = izracunajBrojSamoglasnika($trimmedRijec);

  $brojSuglasnika = izracunajBrojSuglasnika($trimmedRijec);
  // $brojSuglasnika = $brojSlova - $brojSamoglasnika;

  $nizRijeci[] = $trimmedRijec;

  $rijeciJson = json_encode($nizRijeci);
  file_put_contents($filePath, $rijeciJson);
  header('Location: ' . $_SERVER['PHP_SELF']);
}