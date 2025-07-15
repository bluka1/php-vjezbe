<?php
// ovaj file je iskreiran pomoću artisan komande
namespace App\Http\Controllers;

use App\Services\OrderNumberGenerator;
use Illuminate\Http\Request;

class OrderController extends Controller
{
  // ovo je jedina metoda koju smo mi dodali u controller
  // ovaj "argument" u store metodi nije zapravo argument već DI (Dependency Injection) OrderNumberGenerator klase
  // ova metoda ima pristup OrderNumberGenerator klasi samo zato što smo ju mi registrirali u servisni spremnik (Service Container) u OrderNumberServiceProvideru
  // a taj OrderNumberServiceProvider smo, ponavljamo, registrirali u boostrap/providers.php
  public function store(OrderNumberGenerator $orderNumberGenerator) {
    echo $orderNumberGenerator->generate();
  }
}
