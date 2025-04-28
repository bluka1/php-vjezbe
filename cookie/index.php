<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cookie</title>
</head>
<body>
  <h1>Cookie</h1>
  <hr>
  <?php
    // print_r($_COOKIE);
    $cookieName = 'email';
    $cookieValue = 'b@b.com';
    $expirationTime = time() + 864000; // time() - trenutno vrijeme, 86400 = 1 dan
    $path = '/';

    setcookie($cookieName, $cookieValue, $expirationTime, $path);

    print_r($_COOKIE);

    echo '<br>';
    
    setcookie($cookieName, '', time() - 3600, $path);

    print_r($_COOKIE);
  ?>
</body>
</html>