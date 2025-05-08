<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Petlje</title>
</head>
<body>
  <h1>Petlje</h1>
  <h2>Prvi zadatak</h2>
  <hr>
  <?php
    echo 'WHILE:';
    echo '<br>';
    $i = 1;
    while ($i < 11) {
      echo $i . " "; 
      $i++;
    }

    echo '<br>';
    echo 'FOR:';
    echo '<br>';

    for ($i = 1; $i < 100; $i++) {
      if ($i % 2 === 0) {
        echo $i . " ";
      }
    }

    echo '<br>';

    for ($i = 2; $i < 100; $i += 2) {
      echo $i . " ";
    }

  ?>

  <br>

  <h2>Drugi zadatak</h2>
  <hr>
  <?php
    $names = ['Matej', 'Marko', 'Ivan', 'Luka', 'Ilija'];

    $asocNames = [
      'ime1' => 'Matej',
      'ime2' => 'Marko',
      'ime3' => 'Ivan',
      'ime4' => 'Luka',
      'ime5' => 'Ilija'
    ];

    echo 'FOREACH (key -> value sintaksa):';
    echo '<br>';

    foreach ($names as $kljuc => $vrijednost) {
      echo $kljuc . ' -> ' . $vrijednost . '<br>';
    }

    echo '<br>';
    echo 'FOREACH (value sintaksa):';
    echo '<br>';

    foreach ($asocNames as $currentValue) {
      echo $currentValue . '<br>';
    }

    echo '<br>';
    echo 'FOREACH (key -> value sintaksa):';
    echo '<br>';

    foreach ($asocNames as $currentKey => $currentValue) {
      echo $currentKey . ' -> ' . $currentValue . '<br>';
    }
  ?>
</body>
</html>