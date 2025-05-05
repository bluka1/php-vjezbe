<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test vjezba</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php
    require 'funkcije.php';
    define('FILE_PATH', 'people.json');
  ?>
  <!-- <h1>Test vjezba</h1>
  <hr> -->
  <!-- 
  - s lijeve strane nalazi se forma
  - s desne strane nalazi se tablica
  -->

  <form action="obrada.php" method="POST">
    <label>Ime:
      <input type="text" name="ime" required>
    </label>
    <br>
    <br>
    <input type="submit" value="Dodaj ime">
  </form>
  <table border='1'>
    <tr>
      <th>Ime</th>
      <th>Broj Slova</th>
      <th>Sadrži A</th>
      <th>Ime velikim slovima</th>
      <th>Ime malim slovima</th>
    </tr>

    <?php
      // $file_json = file_get_contents(FILE_PATH);
      // $people = json_decode($file_json, true);
      // foreach($people as $name) {
      //   echo '<tr>';
      //   echo '<td>' . $name . '</td>';
      //   echo '<td>' . brojSlova($name) . '</td>';
      //   echo '<td>' . sadrziA($name) . '</td>';
      //   echo '<td>' . velikaSlova($name) . '</td>';
      //   echo '<td>' . malaSlova($name) . '</td>';
      //   echo '</tr>';
      // } 

      $file_json = file_get_contents(FILE_PATH);
      $people = json_decode($file_json, true);
      foreach($people as $person) {
        
        echo '<tr>';
        foreach($person as $vrijednost) {
          echo '<td>' . $vrijednost . '</td>';
        }
        echo '</tr>';

      } 
    ?>
  </table>
</body>
</html>