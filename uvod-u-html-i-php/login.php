<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

  <style>
    div {
      border: 1px solid black;
      margin: 30px;
      padding: 30px;
    }
  </style>
</head>
<body>
  <h1>Login</h1>
  <?php
    include 'obrazac.php';
  ?>

  <div>
    <?php
      $ime = 'Luka';
      $prezime = 'Bluka';

      $full_name = $ime . ' ' . $prezime;
      $full_name = "$ime $prezime";
      echo $full_name;
      echo "<br/>";

      $godine = 20;

      echo $ime . ' ima ' . $godine . ' godina';

      echo "<br/>";

      $je_li_musko = true;

      // ovaj dio ispisuje razlicite stringove ovisno o vrijednosti varijable $je_li_musko
      # ovo je komentar

      /**
       * ovo 
       * je 
       * viselinijski komentar
       */

      if ($je_li_musko == true) {
        echo $ime . ' je musko';
      } else {
        echo $ime . ' je zensko';
      }

      echo "<br/>";

      // definiranje konstante
      define('PI', 3.14);

      echo 'PI je: ' . PI;

      echo "<br/>";

      $varijabla_a = 'A';

      echo 'Varijabla a je: $varijabla_a';
      echo "<br/>";
      echo "Varijabla a je: $varijabla_a";
    ?>
  </div>
</body>
</html>