<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KnjigeController extends Controller
{
    public function index() {
      return view('knjige/index');
    }

    public function store(Request $request) {
      $validatedData = $request->validate(
        [
          "adresa" => "required|string|min:4",
          "naslov" => "required|string|min:7"
        ],
        [
          "adresa.required" => "Adresa je obavezna.",
          "adresa.min" => "Adresa mora imati minimalno 4 znaka.",
          "naslov.required" => "Naslov mora biti unesen.",
          "naslov.min" => "Naslov mora imati barem 7 znakova.",
        ]
      );

      return "Uspješno ste naručili knjigu {$request->input('naslov')} na adresu {$request->input('adresa')}";
      // return redirect('/knjige');
    }
}
