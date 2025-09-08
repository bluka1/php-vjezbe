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
    // generalno se kontrolleri ne testiraju i logika se mice van kontrollera
    // ali za potrebe vjezbe, testiramo kontroller direktno

    // 1. napraviti test - UserControllerTest
    // 1.1 napraviti 2 testa u UserControllerTest - 1 za truthy, 1 za falsy path
    // 2. u testu napraviti post request i proslijediti age i spol parametre
    // 3. assertati status 200
    // 4. assertati sto vraca kontroller (assertSee metoda)
}
