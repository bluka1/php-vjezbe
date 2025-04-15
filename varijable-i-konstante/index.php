<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Varijable i konstante</title>
</head>
<body>
  <div>
    <?php
      $cijeli_broj = 7;
      $decimalni_broj = 3.7;
      $tekst = 'Tekstualni zapis';
      $logicka_vrijednost = false;

      echo $cijeli_broj;
      echo "<br/>";
      echo $decimalni_broj;
      echo "<br/>";
      echo $tekst;
      echo "<br/>";
      echo $logicka_vrijednost;
      echo "<br/>";

      define('PI', 3.14);
      echo PI;
      echo "<br/>";

      // Reference

      $a = 1;
      $b = $a; // ovo je iskljucivo kopija vrijednosti varijable a u varijablu b
      $b = &$a; // ovo je referenca varijabli a
      // referenca kaze -> varijabla b prati sve sto se desava s varijablom a i preslikava njeno stanje

      $a = 2;
      // zbog reference na varijablu a, mijenja se i varijabla b

      echo 'a: ' . $a;
      echo '<br/>';
      echo 'b: ' . $b;
    ?>
  </div>
</body>
</html>