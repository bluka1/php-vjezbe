<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  {{-- {{$uspjeh}} --}}
  <form action="{{route('books.store')}}" method="POST">
    @csrf
    <div>
      <label>Naslov: <br>
        <input type="text" name="naslov" id="naslov" value="{{old('naslov')}}">
        @error('naslov')
          <p style="color:red">{{$message}}</p>
        @enderror
      </label>
    </div>
    <input type="submit" value="Dodaj novu knjigu">
  </form>
  
</body>
</html>