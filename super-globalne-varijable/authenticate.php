<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Authenticate</title>
</head>
<body>
  <h1>Authenticate</h1>
  <hr>
  <?php
    $isPostEmpty = empty($_POST);
    var_dump($isPostEmpty);
  ?>
  <h2>Username: <?php echo $isPostEmpty ? '-' : $_POST['username']; ?></h2>  
  <h2>Password: <?php echo $isPostEmpty ? '-' : $_POST['password']; ?></h2>
</body>
</html>