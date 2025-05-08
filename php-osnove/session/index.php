<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Session</title>
</head>
<body>
  <h1>Session</h1>
  <hr>
  <?php
    echo 'varijabla session prije pokretanja sesije:';
    echo '<br>';
    print_r($_SESSION);

    session_start();

    echo '<br>';
    echo 'varijabla session nakon pokretanja sesije:';
    echo '<br>';
    print_r($_SESSION);

    $_SESSION['email'] = 'a@a.com';

    echo '<br>';
    echo 'varijabla email iz sesije ima vrijednost: ' . $_SESSION['email'];

    session_destroy();
    $_SESSION = [];

    echo '<br>';
    echo 'varijabla session nakon zatvaranja sesije: ';
    print_r($_SESSION);
  ?>
</body>
</html>