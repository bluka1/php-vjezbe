<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Funkcije</title>
</head>
<body>
  <h1>Funkcije</h1>
  <h2>Prvi zadatak</h2>
  <hr>
  <?php
    function vratiTekst($txt) {
      return $txt;
    }

    $tekst = vratiTekst('Tekskskkskskskt');
    echo $tekst;
  ?>

  <hr>

  <?php
    function addNumbers($a, $b, $printResult = false) {

      $sum = $a + $b;

      if ($printResult) {
        echo '$a + $b = ' . $sum;
      }

      echo '* <br>';

      return $sum;
    }

    addNumbers(17, 10, true);
    addNumbers(5, 6, false);
    addNumbers(5, 6);
    addNumbers(5, 6, 0);
    addNumbers(5, 6, 1);
    addNumbers(5, 6, 100);
    addNumbers(1, 2, true, 0, 5, true);
  ?>

  <hr>
  <h2>Drugi zadatak</h2>

  <?php
    function getFullNameToUpper($name, $surname) {
      $fullName = $name . ' ' . $surname;
      $fullName = strtoupper($fullName); // pretvorba stringa u velika slova
      return $fullName;
      // strtolower(); // pretvorba stringa u mala slova
    }

    $luka = getFullNameToUpper('Luka', 'Horvat');
    echo $luka;
  ?>

  <hr>

  <h2>Doseg varijabli</h2>

  <?php
    function primjerDosega() {
      $a = 0;
      static $b = 0;

      echo '$a: ' . $a . ' ; $b: ' . $b . '<br>';

      $a++; // $a = $a + 1; $a = 1;
      $b++;
    }

    // for($i = 0; $i < 100; $i++) {
    //   primjerDosega();
    // }

    for ($i = 5; $i < 4; $i++) {
      echo 'Ovo se nece nikada ispisati.';
    }

    $j = 5;
    do {
      echo 'Ovo se nece nikada ispisati.'; // ovo ce se BAREM 1 ispisati!
      $j++;
    } while ($j < 4)
  ?>

  <hr>

  <h2>Treći zadatak</h2>
  <?php
    function addToCurrentSum($number) {
      static $sum = 0;
      $sum += $number;

      echo '$sum: ' . $sum . '<br>';

      return $sum;
    }


    // primjer za istoimenu staticku varijablu u 2 razlicite funkcije
    // da vidimo da je staticka varijabla posebna za svaku funkciju
    function addToCurrentSummmmm($number) {
      static $sum = 0;
      $sum += $number;

      echo '$sum: ' . $sum . '<br>';

      return $sum;
    }

    addToCurrentSummmmm(1);
    addToCurrentSummmmm(1);
    addToCurrentSummmmm(1);
    addToCurrentSummmmm(1);
    addToCurrentSummmmm(1);
    // kraj primjera

  
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';

    $add = 'addToCurrentSum';

    for($i = 0; $i < 5; $i++) {
      $add(rand(1, 10));
    }
  ?>
</body>
</html>