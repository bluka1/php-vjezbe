<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request) {
      $name = $request->input('name');
      $age = $request->input('age');
      $hobby = $request->input('hobby');

      if (!$name || !$age || !$hobby) {
        return "Molimo dodajte podatke o korisniku.";
      }

      return "Ime korisnika: {$name} ; Godine korisnika: {$age} ; Hobi korisnika: {$hobby}";
    }

    public function create() {
      return view('customers/create');
    }

    public function store(Request $request) {
      return "Hvala što ste nas kontaktirali putem emaila. Javit ćemo vam se s odgovorom na {$request->input('email')}";
    }
}
