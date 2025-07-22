<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function create() {
      return view('profile/create');
    }

    public function store(Request $request) {
      if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
        $file = $request->file('avatar');
        $originalName = $file->getClientOriginalName();

        $path = $file->store('avatars', 'public');

        return "Uspješno ste uploadali avatar {$originalName} i on se nalazi na lokaciji: {$path}";
      }
      return "Niste uploadali profilnu sliku.";
    }
}
