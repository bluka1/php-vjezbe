<?php
  include 'helpers2.php';
  
  define('FILE_PATH', './words2.json');

  $rijeci = citajJsonDatoteku(FILE_PATH);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rijec = $_POST['rijec'];
    dodajRijec($rijec, $rijeci, FILE_PATH);
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
          foreach($rijecUNizu as $vrijednost) {
            echo '<td>' . $vrijednost . '</td>';
          }
          echo '</tr>';
        }
      ?>
    </table>
  </main>
</body>
</html>