@extends('layouts.container')

@section('title', 'Narudžbe')

@section('naslov', 'Moje narudžbe')

@section('content')
  <div>
    <h3>Narudžbe proizvoda</h3>

    <x-button text='Pogledaj detalje posljednje narudžbe'>
      <x-slot:ikona>
        O
      </x-slot:ikona>
    </x-button>

    <ul>
      <li>Kruh</li>
      <li>Mlijeko</li>
      <li>Sir</li>
      <li>Banane</li>
    </ul>
  </div>
@endsection