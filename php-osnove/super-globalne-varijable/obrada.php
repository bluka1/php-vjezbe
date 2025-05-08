<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Obrada</title>
</head>
<body>
  <h1>Obrada</h1>
  <hr>
  <h2>Prvi zadatak</h2>
  <?php
    $isPostEmpty = empty($_POST);

    if (!$isPostEmpty) {
      if (isset($_POST['ime']) && strlen($_POST['ime']) > 0) {
        echo 'Ime je: ' . $_POST['ime'];
      } else {
        echo 'Ime nije postavljeno.';
      }
      
      echo '<br>';

      if (isset($_POST['prezime']) && strlen($_POST['prezime']) > 0) {
        echo 'Prezime je: ' . $_POST['prezime'];
      } else {
        echo 'Prezime nije postavljeno.';
      }

      echo '<br>';
      
    } else {
      echo 'Nema podataka za obradu.';
    }
  ?>
  <br>
  <br>
  <br>
  <h2>Drugi zadatak</h2>
  <hr>
  <?php
    if(empty($_GET)) {
      echo 'Nema podataka u GET varijabli.';
    } else {
      foreach($_GET as $key => $value) {
        if (strlen($_GET[$key]) > 0) {
          echo $key . ' : ' . $value . '<br>';
        } else {
          echo $key . ' nije postavljeno.' . '<br>';
        }
      }
    }
  ?>
</body>
</html>