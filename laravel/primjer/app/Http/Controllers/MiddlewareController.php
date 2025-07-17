<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// *** NIKADA u kodu nećete imati ovako nazvan controller ***
// ovo je samo za primjer i posljedica je manjka ideje za ime controllera
class MiddlewareController extends Controller
{
  public function get() {
    return 'MIDDLE ROUTE';
  }

  public function check() {
    return 'CHECKING AGE';
  }
}
