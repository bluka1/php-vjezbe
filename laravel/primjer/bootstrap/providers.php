<?php

// ovo je prvi korak kod registriranja novih servisa
// dakle, moramo dodati ServiceProvider klasu u ovaj array
// ovaj korak će biti izvršen putem artisan naredbe
return [
    App\Providers\AppServiceProvider::class,
    App\Providers\OrderNumberServiceProvider::class,
];
