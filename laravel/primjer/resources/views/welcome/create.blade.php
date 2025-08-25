<div>
  <form method="POST" action="/welcome/store">
    @csrf
    <label>
      Naslov: <br>
      <input type="text" name="naslov" id="naslov" value="{{ old('naslov') }}">
      @error('naslov')
        <p style="color: red">{{ $message }}</p>
      @enderror
    </label>

    <br><br>

    <label>
      Adresa: <br>
      <input type="text" name="adresa" id="adresa" value="{{ old('adresa') }}">
      @error('adresa')
        <p style="color: red">{{ $message }}</p>
      @enderror
    </label>

    <br><br>

    <input type="submit" value="Submit">
  </form>
</div>
