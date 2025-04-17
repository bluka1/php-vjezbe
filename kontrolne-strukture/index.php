<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>kontrolne strukture</title>
</head>
<body>
  <h1>Kontrolne strukture</h1>
  <h2>Prvi zadatak</h2>
  <hr>
  <?php
    $a = 15;
    $b = 10;
    $c = 5;

    if($b > $a && $b < $c || $b < $a && $b > $c) {
      echo 'Varijabla b je između a i c';
    } else {
      echo 'Varijabla b nije između a i c';
    }

    echo '<hr>';

    if ($b > $a && $b < $c) {
      echo 'Varijabla b je između a i c';
    } elseif ($b < $a && $b > $c) {
      echo 'Varijabla b je između a i c';
    } else {
      echo 'Varijabla b nije između a i c';
    }

    echo '<hr>';

    switch($b) {
      case $b > $a && $b < $c:
        echo 'Varijabla b je izmedu a i c';
        break;
      case $b < $a && $b > $c:
        echo 'Varijabla b je izmedu a i c';
        break;
      default:
        echo 'Varijabla b nije između a i c';
    }

    echo '<hr>';
  ?>

  <h2>Drugi zadatak</h2>
  <hr>
  <?php
    $dan = date('N');

    switch($dan) {
      case 1:
        echo 'Danas je ponedjeljak.';
        break;
      case 2:
        echo 'Danas je utorak.';
        break;
      case 3:
        echo 'Danas je srijeda.';
        break;
      case 4:
        echo 'Danas je četvrtak.';
        break;
      case 5:
        echo 'Danas je petak.';
        break;
      case 6:
        echo 'Danas je subota.';
        break;
      case 7:
        echo 'Danas je nedjelja.';
        break;
    }
  ?>

</body>
</html>