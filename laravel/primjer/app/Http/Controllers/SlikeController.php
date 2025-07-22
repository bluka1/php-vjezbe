<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SlikeController extends Controller
{
    public function create() {
      return view('slike/create');
    }

    public function store(Request $request) {
      if ($request->hasFile('slika') && $request->file('slika')->isValid()) {
        $file = $request->file('slika');
        $originalName = $file->getClientOriginalName();
        $path = $file->store('slike', 'public');

        return "{$originalName} je spremljena na adresu: {$path}";
      }
      return "Molimo označite ispravnu datoteku.";
    }
}
