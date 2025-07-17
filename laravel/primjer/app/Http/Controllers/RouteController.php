<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
  public function get() {
    return view('routesget');
    // require __DIR__ . '/../../../resources/view/routesget.blade.php'
  }

  public function post() {
    return 'POST';
  }

  public function getParams(string $id) {
    return "Ovo je vrijednost parametra proslijedena na params ruti: {$id}";
  }

  public function getNeoParams(string $neobavezniParametar = '') {
    return "Neobavezni parametar: {$neobavezniParametar}";
  }

  public function getNova() {
    return view('getNova');
  }

  public function postNova() {
    return 'POST Nova uspješno napravljen.';
  }
}
