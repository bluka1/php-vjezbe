<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <h1>Unos novog posta</h1>

  <form action="{{url('/posts/add')}}" method="POST">
    @csrf
    <div>
      <label>
        Title: <br>
        <input type="text" name="title" id="title">
      </label>
    </div>
    <br>
    <div>
      <label>
        Content: <br>
        <input type="text" name="content" id="content">
      </label>
    </div>
    <br>
    <button type="submit">Dodaj novi post</button>
  </form>
</body>
</html>