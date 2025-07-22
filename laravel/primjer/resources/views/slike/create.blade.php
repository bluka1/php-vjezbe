<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <h1>Upload slike:</h1>
  <form action="/slike/store" method="POST" enctype="multipart/form-data">
    @csrf
    <label>
      Slika:
      <br>
      <input type="file" name="slika" id="slika">
    </label>
    <br><br>
    <input type="submit" value="Upload slike">
  </form>
</body>
</html>