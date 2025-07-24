<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <h1>Naruči novu knjigu:</h1>
  <form action="/knjige/store" method="POST">
    @csrf
    <label>
      Adresa: <br>
      <input type="text" name="adresa" id="adresa" value="{{old('adresa')}}">
      @error('adresa')
        <p style="color: red">{{$message}}</p>
      @enderror
    </label>
    <br>
    <label>
      Naslov knjige: <br>
      <input type="text" name="naslov" id="naslov" value="{{old('naslov')}}">
      @error('naslov')
        <p style="color: red">{{$message}}</p>
      @enderror
    </label>
    <br>
    <input type="submit" value="Naruči knjigu ->">
  </form>
</body>
</html>