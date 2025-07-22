<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KnjigeController extends Controller
{
    public function index() {
      return view('knjige/index');
    }

    public function store(Request $request) {
      return "Uspješno ste naručili knjigu {$request->input('naslov')} na adresu {$request->input('adresa')}";
      // return redirect('/knjige');
    }
}
