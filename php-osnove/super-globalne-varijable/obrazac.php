<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Obrazac</title>
</head>
<body>
  <h1>Obrazac</h1>
  <hr>
  <form action="obrada.php" method="post">
    <label>Ime
      <input type="text" name="ime" required>
    </label>
    <br>
    <br>
    <label>Prezime
      <input type="text" name="prezime" required>
    </label>
    <br>
    <br>
    <input type="submit" value="Pošalji">
  </form>
</body>
</html>