@extends('layouts.app')

@section('title', 'Login')

@section('content')
  <h2>Prijava korisnika</h2>
  <form action="{{ url('/process') }}" method="POST">
    @csrf
    <div>
      <label>
        Email: <br>
        <input type="text" name="email" id="email" value="{{old('email')}}">
      </label>
      <br>
      @error('email')
        <p style="color: red">{{$message}}</p>    
      @enderror
    </div>
    <br><br>
    <div>
      <label>
        Password: <br>
        <input type="password" name="password" id="password">
      </label>
      <br>
      @error('password')
        <p style="color: red">{{$message}}</p>    
      @enderror
    </div>
    <br><br>
    <button type="submit">Prijava</button>
  </form>

  <br><br>

  <hr>

  <br><br>

  @auth
    <p>Dobrodošli, {{auth()->user()->name}}</p>

    <br>
    <form action="{{ url('/logout') }}" method="POST">
      @csrf
      <button type="submit">Odjava</button>
    </form>
  @else
    <p>Niste ulogirani.</p>
    <p>Molimo prijavite se.</p>
  @endauth
@endsection