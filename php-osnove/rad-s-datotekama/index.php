<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rad s datotekama</title>
</head>
<body>
  <h1>Rad s datotekama</h1>
  <hr>
  <?php
    $polazniciContent = file_get_contents('../polaznici.json', true);
    // print_r($polazniciContent);
    // var_dump($polazniciContent);

    $polaznici = json_decode($polazniciContent, true);
    // var_dump($polaznici);
  ?>

  <table border="1">
    <tr>
      <th>Ime</th>
      <th>Prezime</th>
      <th>Godine</th>
      <th>Email</th>
      <th>Telefon</th>
    </tr>
    <?php
      function ispisiPolaznike($nizPolaznika) {
        foreach($nizPolaznika as $jedanPolaznik) {
          echo '<tr>';
          foreach($jedanPolaznik as $vrijednostiOsobe) {
            echo '<td>' . $vrijednostiOsobe . '</td>';
          }
          echo '</tr>';
        }
      }

      ispisiPolaznike($polaznici);

    ?> 
  </table>

  <h2>Dodavanje novog polaznika</h2>

  <hr>

  <table border="1">
    <tr>
      <th>Ime</th>
      <th>Prezime</th>
      <th>Godine</th>
      <th>Email</th>
      <th>Telefon</th>
    </tr>

    <?php
      array_push($polaznici, [
        'name' => 'Marko',
        'surname' => 'Antic',
        'age' => 45,
        'email' => 'marko.antic@gmail.com',
        'phone' => '38599555666'
      ]);

      file_put_contents('../polaznici.json', json_encode($polaznici));

      ispisiPolaznike($polaznici);
    ?>
  </table>

</body>
</html>