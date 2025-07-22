<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request) {
      $age = $request->input('age');
      $spol = $request->input('spol', 'm');

      if ($age && $spol) {
        return "Godine: {$age}, Spol: {$spol}";
      }

      return "Nedostaje neki parametar.";
    }
}
