<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <h1>Pošalji nam email:</h1>

  <form action="/customers/store" method="POST">
    @csrf
    <label>
      Email:
      <input type="email" name="email" id="email" value="{{old('email')}}">
      @error('email')
        <p style="color: red">{{$message}}</p>
      @enderror
    </label>
    <br>
    <input type="submit" value="Pošalji email">
  </form>
</body>
</html>