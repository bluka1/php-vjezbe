<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POST</title>
</head>
<body>
  <h1>POST VARIJABLA</h1>
  <hr>
  <form action="authenticate.php" method="post">
    <div>
      <label>Username:
        <input type="text" name="username">
      </label>
    </div>  

    <label>Password:
      <input type="password" name="password">
    </label>

    <br>
    
    <input type="submit" value="Login">
  </form>

  <?php
    var_dump($_POST);
    echo '<br>';

    if(isset($_POST['username'])) {
      echo 'Username: ' . $_POST['username'];
    } else {
      echo 'Username nije postavljen';
    }
  ?>
</body>
</html>