@extends('layouts.app')

@section('title', 'kontakt')
@push('styles')
  <link rel="stylesheet" href="{{ asset('kontakt.css') }}">
@endpush

@section('content')
  <h2>Kontakt podaci</h2>
  <p>Broj mobitela: 0912345678</p>
  <address>
    <p>Adresa: Zagrebačka cesta 138, 10000 Zagreb</p>
  </address>
@endsection