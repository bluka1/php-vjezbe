<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <h1>GET Nova</h1>
  <form action="{{route('abc.post')}}" method="POST">
    @csrf
    <input type="number" name="age" id="age" value="20">
    <input type="submit" value="Napravi POST request na rutu /nova">
  </form>
</body>
</html>