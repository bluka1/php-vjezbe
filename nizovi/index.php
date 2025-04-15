<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nizovi</title>
</head>
<body>

<!-- prvi zadatak -->
  <?php
    $primeNumbers = [1,2,3,5,7];
    // $primeNumbers = [1,2];
    $isThirdElementSet = isset($primeNumbers[2]);
    if($isThirdElementSet == true) {
      var_dump($primeNumbers[2]);
    } else {
      echo "Treci element ne postoji.";
    };

    echo "<br>";

    $primeNumbers[] = 11;

    $brojElemenataUNizu = count($primeNumbers);
    echo 'Broj elemenata u nizu: ' . $brojElemenataUNizu;

    echo "<br>";
    echo "PRIME NUMBERS: " . "<br>";
    // echo '<pre>';
    var_dump($primeNumbers);
    // echo '</pre>';

    echo "<br>";

    rsort($primeNumbers);

    echo "SORTED PRIME NUMBERS: " . "<br>";

    var_dump($primeNumbers);

  ?>
  
  <br><br><br><br>

  <hr>
  <h2>DRUGI ZADATAK</h2>

  <br>
  <!-- drugi zadatak -->
  <?php
    $users = [
      'luka' => [
        'ime' => 'Luka',
        'prezime' => 'Horvat',
        'godine' => 22,
        'spol' => 'M'
      ],
      'ana' => [
        'ime' => 'Ana',
        'prezime' => 'Anic',
        'godine' => 25,
        'spol' => 'Z'
      ]
    ];

    echo '<pre>';
    var_dump($users);
    echo '</pre>';

    echo "<br>";
    echo '<hr>';
    echo "<br>";

    unset($users['luka']['spol']);
    unset($users['ana']['spol']);

    echo '<pre>';
    var_dump($users);
    echo '</pre>';

    
    echo "<br>";
    echo '<hr>';
    echo "<br>";

    $users['mirko'] = [
      'ime' => 'Mirko',
      'prezime' => 'CroCop',
      'godine' => 50,
    ];

    echo '<pre>';
    var_dump($users);
    echo '</pre>';

  ?>

</body>
</html>