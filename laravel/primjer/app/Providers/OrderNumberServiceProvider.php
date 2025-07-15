<?php
// ovaj file je stvoren putem artisan naredbe i samim time je stavljen u ispravan folder
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// moramo use-ati klasu koju namjeravamo koristiti unutar Service Providera
use App\Services\OrderNumberGenerator;

class OrderNumberServiceProvider extends ServiceProvider
{
    /**
     * Ovo je metoda u kojoj registrirammo servise u našem servisnom spremniku (Service Containeru).
     * Registracija servisa dešava se kroz register metodu.
     * 
     * Mi nikada ne instanciramo sami servisni spremnik već se on automatski instancira kroz bootstrapping.
     * 
     * U register metodi mi se referiramo na Service Container pomoću $this->app izraza te na tom izrazu potrebno
     * pozvati bind metodu kako bismo registrirali novi servis u Service Container.
     */
    public function register(): void
    {
      // kod pozivanja bind metode, potrebno je kao prvi argument proslijediti Fully Qualified Path(FQP) do naše klase i zato koristimo ::class dio
      // drugi argument bind metode je funkcija koja će se izvršiti kada god se netko referira na servis koji smo dodali u servisni spremnik
      // u ovom slučaju, kada god neki controller želi korisititi OrderNumberGenerator, samo ga treba referirati poput argumenta u kontruktoru ili nekoj metodi
      // i to će biti dovoljno da unutar tog controllera imamo novu instancu OrderNumberGenerator klase
      $this->app->bind(OrderNumberGenerator::class, function () {
        return new OrderNumberGenerator();
      });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
