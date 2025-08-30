@extends('layouts.container')

@section('title', 'Prijava')

@section('naslov', 'Prijava')

@section('content')
  <div>
    @if(auth()->check())
      <p>Dobrodošli, {{ auth()->user()->name }}!</p>
    @endif
    @if(!auth()->check())
      <p>Molimo vas da se prijavite.</p>
    @endif
    
    <form action="{{ url('/obrada') }}" method="POST">
      @csrf
      <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div>
        <label for="password">Lozinka:</label>
        <input type="password" id="password" name="password" required>
        @error('password')
        <div>{{ $message }}</div>
        @enderror
      </div>
      <button type="submit">Prijavi se</button>
      @error('email')
        <div>{{ $message }}</div>
      @enderror
    </form>
  </div>

  @if (auth()->user())
    <form action="{{ url('/odjava') }}" method="POST">
      @csrf
      <button type="submit">Odjavi se</button>
    </form>
  @endif
@endsection