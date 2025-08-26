@extends('layouts.container')

@section('title', 'Proizvodi')

@section('naslov', 'Proizvodi kompanije')

@section('content')
  <div>
    <h3>Proizvodi koje nudimo:</h3>

    <ul>
      <li>Kruh</li>
      <li>Mlijeko</li>
      <li>Sir</li>
      <li>Banane</li>
      <li>Borovnice</li>
      <li>Maline</li>
      <li>Kefir</li>
      <li>Piletina</li>
    </ul>
  </div>
  <hr>
  <div>
    <x-button text='Dodaj u košaricu'>
      <x-slot:ikona>X</x-slot:ikona>
    </x-button>
  </div>
@endsection()