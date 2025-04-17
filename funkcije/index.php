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
</body>
</html>