<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vjezba - json</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Vjezba - json</h1>
  <hr>
  <?php
    // 1. korak - čitanje sadržaja datoteke
    $knjigeContent = file_get_contents('./knjige.json');
    // print_r($knjigeContent); // string podaci koje moramo pretvoriti u strukturu podataka razumljivu php-u

    echo '<hr>';
    // 2. korak - pretvoriti sadržaj datoteke u niz
    $knjige = json_decode($knjigeContent, true);
    // print_r($knjige);

    // 3. korak - prikazati knjige
    foreach($knjige as $knjiga) {
      echo '<div class="knjiga">';
      foreach($knjiga as $kljuc => $vrijednost) {
        echo '<p>' . $kljuc . ': ' . $vrijednost . '</p>';
      }
      echo '</div>';
    }
  ?>

  <form action="./dodajKnjigu.php" method="post">
    <label>
      Autor:
      <input type="text" name="autor" id="">
    </label>

    <br>
    <br>

    <label>
      Naslov:
      <input type="text" name="naslov" id="">
    </label>

    <br>
    <br>
    <label>
      Godina:
      <input type="text" name="godina" id="">
    </label>

    <br>
    <br>
    <input type="submit" value="Dodaj knjigu">
  </form>
</body>
</html>