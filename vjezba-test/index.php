<?php
  define('FILE_PATH', './words.json');

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

  function dodajRijec($word, $nizRijeci) {
    $trimmedRijec = trim($word);
    if (strlen($trimmedRijec) === 0) return;

    $brojSlova = izracunajBrojSlova($trimmedRijec);
    // echo $brojSlova . '<br>';

    $brojSamoglasnika = izracunajBrojSamoglasnika($trimmedRijec);

    $brojSuglasnika = izracunajBrojSuglasnika($trimmedRijec);
    // $brojSuglasnika = $brojSlova - $brojSamoglasnika;

    $nizRijeci[] = $trimmedRijec;

    $rijeciJson = json_encode($nizRijeci);
    file_put_contents(FILE_PATH, $rijeciJson);
    header('Location: ' . $_SERVER['PHP_SELF']);
  }

  $rijeci = citajJsonDatoteku(FILE_PATH);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo 'Ovo je POST metoda.';
    echo '<br><br>';

    $rijec = $_POST['rijec'];
    
    dodajRijec($rijec, $rijeci);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo 'Ovo je GET metoda.';
    echo '<br><br>';
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vjezba - test</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Vježba - test</h1>
  <hr>

  <main class="main">
    <form action="" method="POST">
      <label>
        Upišite riječ: <br>
        <input type="text" name="rijec" required>
      </label>
      <br><br>
      <input type="submit" value="pošalji">
    </form>
    
    <table border="1">
      <tr>
        <th>Riječi</th>
        <th>Broj slova</th>
        <th>Broj samoglasnika</th>
        <th>Broj suglasnika</th>
      </tr>

      <?php
        foreach($rijeci as $rijecUNizu) {
          echo '<tr>';
          echo '<td>' . $rijecUNizu . '</td>';
          echo '<td>' . izracunajBrojSlova($rijecUNizu) . '</td>';
          echo '<td>' . izracunajBrojSamoglasnika($rijecUNizu) . '</td>';
          echo '<td>' . izracunajBrojSuglasnika($rijecUNizu) . '</td>';
          echo '</tr>';
        }
      ?>
    </table>
  </main>
</body>
</html>