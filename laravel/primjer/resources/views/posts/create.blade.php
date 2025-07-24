<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <h1>Napravi novi post:</h1>
  <form action="/posts/store" method="POST">
    @csrf
    <label>
      Naslov: <br>
      <input type="text" name="naslov" value="{{old('naslov')}}">
      @error('naslov')
        <p style="color: red">{{$message}}</p>
      @enderror
    </label>
    <br>
    <br>
    <br>
    <label>
      Tijelo: <br>
      <textarea name="tijelo">{{old('tijelo')}}</textarea>
      @error('tijelo')
        <p style="color: red">{{$message}}</p>
      @enderror
    </label>
    <br><br><br>
    <button type="submit">Napravi Post</button>
  </form>
</body>
</html>