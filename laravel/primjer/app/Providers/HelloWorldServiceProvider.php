<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\HelloWorldService;

class HelloWorldServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
      $this->app->bind(HelloWorldService::class, function () {
        return new HelloWorldService();
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
