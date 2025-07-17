<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <h1>Routes Forma</h1>
  <form action="{{route('admin.postR')}}" method="POST">
    @csrf
    <input type="submit" value="Napravi POST request na /routes">
  </form>
</body>
</html>